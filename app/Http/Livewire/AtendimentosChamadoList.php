<?php

namespace App\Http\Livewire;

use App\CacheManagers\UsuarioCache;
use \Illuminate\Session\SessionManager;
use Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\Chamado;
use App\Models\Usuario;
use Livewire\Component;
use App\Enums\StatusEnum;
use App\Http\Controllers\UserPreferencesController;
use \App\Libs\Helpers\DateHelpers;
use App\Models\Area;
use App\Models\UsuarioRole;

class AtendimentosChamadoList extends Component
{
    protected $select_items;

    public $order_by            = 'id';
    public $order_dir           = 'DESC';
    public $items_by_page       = 10;
    public $paused_items_by_page= 10;
    public $selected_status     = null;
    public $keep_accordion_open = false;
    public $atendente           = null;
    public $em_atendimento      = null;
    public $cache_keys          = [];
    public $log_message         = null;
    public $transferencia_para   = null;
    public $transferencia_para_id  = null;
    public $options_data        = [];

    public function mount(SessionManager $session, array $select = [], int $items_by_page = 10)
    {
        //TODO colocar lógica que permita apenas atenddentes ver essa tela

        $this->select_items         = $this->getSelectItems($select, true);
        $this->items_by_page        = $items_by_page > 0 && $items_by_page < 200 ? $items_by_page : 10;
        $this->selected_status      = StatusEnum::ABERTO;
        $this->keep_accordion_open  = session()->get('user_preferences.atendente.chamados_a_atender.keep_accordion_open', false);
        $this->cache_keys           = session()->get('cache_keys', []);
        $this->atendente            = $this->getUsuario();
        $this->startEmAtendimento();
    }

    public function render()
    {
        return view('livewire.atendimentos-chamado-list', [
            'chamados' => $this->getFilteredChamados([], [
                'atendente' => function($query) {
                    $query->select('id','name',);
                },
            ])
                ->paginate($this->items_by_page),

            'chamados_pausados' =>$this->getPausedChamados()
                ->paginate($this->paused_items_by_page),
        ]);
    }

    protected function getChamados(array $columns_to_select = [], array $relationships = [])
    {
        $chamados = Chamado::limit($this->items_by_page)
                    ->orderBy($this->order_by, $this->order_dir)
                    ->with([
                        'usuario' => function($query) {
                            $query->select('id','name',);
                        },
                    ]);

        if(in_array('unidade_id', $columns_to_select))
            $chamados = $chamados->with(['unidade' => function($query) {
                $query->select('id','nome',);
            }]);

        $chamados = $chamados->select($this->getSelectItems($columns_to_select, true));

        if($relationships)
            $chamados = $chamados->with($relationships);

        $areas  = $this->getUsuarioAreas();

        if($areas && is_array($areas) && count($areas) > 0)
            $chamados = $chamados->whereRaw('area_id in('. implode(',', $areas) .') or area_id is null');

        return $chamados;
    }

    public function getUsuarioAreas(): Array
    {
        if(!$this->atendente)
            return [];

        $areas = $this->atendente->areas ?? [];

        if(!$areas)
            return [];

        return array_unique(array_values($areas->pluck('id')->toArray()));
    }

    public function getAllAreas(bool $update_cache = false)
    {
        $this->cache_keys['all_areas'] = 'all_areas';

        if($update_cache)
            Cache::forget($this->cache_keys['all_areas']);

        return Cache::remember($this->cache_keys['all_areas'], (5*60) /*secs*/, function () {
            return Area::select('id', 'sigla', 'nome')->get();
        });
    }

    protected function getFilteredChamados(array $columns_to_select = [], array $relationships = [])
    {
        $chamados = $this->getChamados($columns_to_select, $relationships);

        if(!$this->selected_status)
            return $chamados;

        if($this->selected_status && StatusEnum::getState($this->selected_status))
            $chamados->where('status', $this->selected_status);
        else
            $chamados->whereNotIn('status', [
                StatusEnum::PAUSADO,
                StatusEnum::ENCERRADO,
                StatusEnum::EM_ATENDIMENTO,
            ]);

        return $chamados;
    }

    protected function getPausedChamados(array $columns_to_select = [], array $relationships = [])
    {
        return $this->getChamados([
            'unidade_id',
            'observacao',
            'title',
            'paused_at',
        ], $relationships)
        ->where('status', StatusEnum::PAUSADO);
    }

    protected function getUsuario()
    {
        return UsuarioCache::byLoggedUser(['areas', 'roles']);
    }

    protected function getSelectItems(array $select_array_from_param_data = [], bool $return_it = false)
    {
        $required_select_items = [
            'id',
            'problema_id',
            'usuario_id',
            'atendente_id',
            'status',
            'created_at',
            'title',
        ];

        $this->select_items = array_merge($required_select_items, ($select_array_from_param_data ?? []));

        if($return_it)
            return $this->select_items;
    }

    public function changeOrderBy(string $order_by = null)
    {
        //Valida se um campo pelo qual deseja ordenar existe na model
        $model              = new Chamado;
        $dates              = array_merge(array_keys($model->getAttributes()), $model->getDates());
        $accepted_order_by  = array_merge($model->getFillable(), $dates);

        $this->order_by     = in_array($order_by, $accepted_order_by) ? $order_by : 'id';
        $this->order_dir    = $this->order_dir == 'DESC' ? 'ASC' : 'DESC';
    }

    public function changeChamadosAccordionOpenState()
    {
        (new UserPreferencesController)->changeBooleanState('atendente.chamados_a_atender.keep_accordion_open');
        $this->keep_accordion_open  = session()->get('user_preferences.atendente.chamados_a_atender.keep_accordion_open', false);
    }

    public function startEmAtendimento(bool $update_cache = null)
    {
        if(!$this->atendente->id ?? null)
            return;//TODO validar se o usuário é um atendente

        $this->cache_keys['em_atendimento'] = 'em_atendimento_atendente_id_'.$this->atendente->id;

        if($update_cache)
            Cache::forget($this->cache_keys['em_atendimento']);

        $this->em_atendimento = Cache::remember($this->cache_keys['em_atendimento'], (5*60) /*secs*/, function () {
            return Chamado::where('status', StatusEnum::EM_ATENDIMENTO)
                ->with([
                    'unidade' => function($query) {
                        $query->select('id','nome',);
                    },
                    'usuario' => function($query) {
                        $query->select('id','name',);
                    },
                    'atendente' => function($query) {
                        $query->select('id','name',);
                    },
                ])
                ->where('atendente_id', $this->atendente->id)
                ->first();
        });
    }

    public function clearCache($cache_key = null)
    {
        $this->toastIt('Cache limpo com sucesso!', 'success', ['preventDuplicates' => true]);
        $this->cache_keys = session()->get('cache_keys', []);

        if(!$cache_key)
        {
            foreach ($this->cache_keys as $key)
            {
                Cache::forget($key);
                unset($this->cache_keys[$key]);
                session()->forget($key);
            }

            $this->cache_keys = session()->get('cache_keys', []);
        }
        else
            Cache::forget($this->cache_keys[$cache_key] ?? null);
    }

    public function pauseCurrent()
    {
        if(!$this->setCurrentAsPaused())
            return;

        $this->em_atendimento = null;
        $this->log_message    = null;
        $this->startEmAtendimento(true);
    }

    protected function setCurrentAsPaused()
    {
        if(!$this->em_atendimento)
            return;

        if(!$this->em_atendimento instanceof Chamado)
            return;

        $updated = $this->em_atendimento->update([
            'status'    => StatusEnum::PAUSADO,
            'paused_at' => now(),
        ]);

        if($updated)
        {
            $this->toastIt('Chamado #'. $this->em_atendimento->id .' pausado com sucesso!', 'success', ['preventDuplicates' => false]);
            return $updated;
        }

        $this->toastIt('Falha ao pausar o chamado #'. $this->em_atendimento->id .'', 'error', ['preventDuplicates' => false]);
    }

    public function closeCurrent()
    {
        if(!$this->log_message)
        {
            $this->toastIt('Favor colocar um registro do atendimento antes de encerrar. [ln~'.__LINE__.']', 'error', ['preventDuplicates' => true]);
            return;
        }

        if(strlen($this->log_message) < 10)
        {
            $this->toastIt('O registro do atendimento precisa ter no mínimo 10 caracteres. [ln~'.__LINE__.']', 'error', ['preventDuplicates' => true]);
            return;
        }

        if(!$this->setCurrentAsClosed())
            return;

        $this->em_atendimento = null;
        $this->log_message    = null;
        $this->startEmAtendimento(true);
    }

    protected function setCurrentAsClosed()
    {
        if(!$this->em_atendimento)
            return;

        if(!$this->em_atendimento instanceof Chamado)
            return;

        $updated = $this->em_atendimento->update([
            'status'        => StatusEnum::ENCERRADO,
            'conclusion'    => $this->log_message,
            'finished_at'   => now(),
        ]);

        if($updated)
        {
            $this->toastIt('Chamado #'. $this->em_atendimento->id .' encerrado com sucesso!', 'success', ['preventDuplicates' => false]);
            return $updated;
        }

        $this->toastIt('Falha ao encerrar o chamado #'. $this->em_atendimento->id, 'error', ['preventDuplicates' => false]);
    }

    public function atenderChamado($chamado_id)
    {
        if(!$this->atendente->id ?? null)
        {
            //TODO validar se o usuário é um atendente
            $this->toastIt('Usuário atual não é um atendente! [ln~'.__LINE__.']', 'error', ['preventDuplicates' => true]);
            return;
        }

        if($this->hasEmAtendimento())
        {
            $this->toastIt('Já existe um chamado em atendimento! [ln~'.__LINE__.']', 'error', ['preventDuplicates' => true]);
            return;
        }

        if(!is_numeric($chamado_id))
        {
            $this->toastIt('Falha ao selecionar identificador do chamado! [ln~'.__LINE__.']', 'error', ['preventDuplicates' => true]);
            return;
        }

        $chamado = $this->getChamadoById((int) $chamado_id)
            ->whereNotIn('status', [
                StatusEnum::ENCERRADO,
                StatusEnum::EM_ATENDIMENTO,
            ])->first();

        if(!$chamado)
        {
            $this->toastIt('Falha ao abrir o chamado! [ln~'.__LINE__.']', 'error', ['preventDuplicates' => true]);
            return;
        }

        $update = $chamado->update([
            'status'        => StatusEnum::EM_ATENDIMENTO,
            'atendente_id'  => $this->atendente->id,
        ]);

        if(!$update)
        {
            $this->toastIt('Falha ao atualizar o chamado! [ln~'.__LINE__.']', 'error', ['preventDuplicates' => true]);
            return;
        }

        $this->em_atendimento = $this->getChamadoById((int) $chamado_id)
            ->whereNotIn('status', [
                StatusEnum::ENCERRADO,
                StatusEnum::EM_ATENDIMENTO,
            ])->first();

        $this->startEmAtendimento(true);
    }

    protected function getChamadoById(int $chamado_id)
    {
        return Chamado::with([
                'unidade' => function($query) {
                    $query->select('id','nome',);
                },
                'usuario' => function($query) {
                    $query->select('id','name',);
                },
            ])
            ->where('id', $chamado_id);
    }

    public function hasEmAtendimento()
    {
        return Chamado::where('status', StatusEnum::EM_ATENDIMENTO)
            ->where('atendente_id', $this->atendente->id)
            ->exists();
    }

    public function toastIt(string $message, string $toast_type = 'success', array $options = [])
    {
        $accepted_types = [
            'success',
            'info',
            'warning',
            'error',
        ];

        $default_options = [
            "closeButton" => true,
            "debug"       => false,
            "newestOnTop" => true,
            "preventDuplicates" => false,
        ];

        $toast_type = in_array($toast_type, $accepted_types) ? $toast_type : 'success';
        $options    = array_merge($default_options, $options);
        $this->emit('newToastMessage', compact('message', 'toast_type', 'options'));
    }

    public function cantOpenIfStatusIn(array $and_this = [])
    {
        return array_merge([
            StatusEnum::ENCERRADO,
            StatusEnum::EM_ATENDIMENTO,
        ], $and_this);
    }

    public function confirm($message, $callback, ...$argv)
    {
        $this->emit('confirm', compact('message', 'callback', 'argv'));
    }

    public function tranferirChamado()
    {
        if(!$this->em_atendimento ?? null)
            return;

        $this->transferencia_para = null;

        $chamado_id = $this->em_atendimento->id;
        $this->emit('tranferirChamadoEvent', compact('chamado_id'));
    }

    public function transferenciaPor(string $transferencia_para)
    {
        $accept_values = [
            'area'      => [
                'formated_title' => 'Área',
                'formated_label' => 'Selecione uma área para transferir',
                'model'          => \App\Models\Area::class,
            ],
            'atendente' => [
                'formated_title' => 'Atendente',
                'formated_label' => 'Selecione um atendente para transferir',
                'model'          => \App\Models\Atendente::class,
            ],
        ];

        //TODO colocar no foreach do JS optins id=add_area

        if(!in_array($transferencia_para, array_keys($accept_values)))
        {
            $this->emit('closeModalTransferenciaPorEvent');
            return;
        }

        $formated_data = $accept_values[$transferencia_para] ?? [];

        $this->options_data = [
            'title' => $formated_data['formated_title'] ?? "Selecione um $transferencia_para para transferir",
            'label' => $formated_data['formated_label'] ?? "Selecione um $transferencia_para para transferir",
            "options" => [
                ['id' => 1, 'label' => $transferencia_para .' 1'],
                ['id' => 2, 'label' => $transferencia_para .' 2'],
                ['id' => 3, 'label' => $transferencia_para .' 3'],
            ],
        ];

        $options_data = json_encode($this->options_data ?? []);

        $this->transferencia_para = $transferencia_para;
        $this->emit('transferenciaPorEvent', compact('transferencia_para', 'options_data', 'formated_data'));
    }

    public function alterado()
    {
        $this->emit('reOpenModalTransferenciaPorEvent');
        $this->toastIt("alterado() 'transferencia_para_id' ". $this->transferencia_para.' id:'.$this->transferencia_para_id, 'success', ['preventDuplicates' => true]);
    }

    public function concluirTransferencia()
    {
        if($this->transferencia_para || $this->transferencia_para_id)
        {
            $this->toastIt("Dados insuficientes", 'error', ['preventDuplicates' => true]);
            $this->emit('reOpenModalTransferenciaPorEvent');
            return;
        }

        $this->emit('closeModalTransferenciaPorEvent');

        $this->toastIt("concluirTransferencia() 'transferencia_para_id' ". $this->transferencia_para.' id:'.$this->transferencia_para_id, 'success', ['preventDuplicates' => true]);
    }

    public function getOpcoesParaTranferencia(string $transferencia_para = null)
    {
        return $this->options_data ?? [];;
    }
}

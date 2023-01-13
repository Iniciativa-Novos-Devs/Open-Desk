<?php

namespace App\Http\Livewire;

use App\CacheManagers\AreaCache;
use App\CacheManagers\AtendenteCache;
use App\Enums\ChamadoLogTypeEnum;
use App\Enums\StatusEnum;
use App\Http\Controllers\Admin\UserPreferencesController;
use App\Http\Livewire\Traits\LoadSpinner;
use App\Models\Area;
use App\Models\Chamado;
use App\Models\Usuario;
use Arr;
use Auth;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithPagination;
use Str;

class AtendimentosChamadoList extends Component
{
    use WithPagination;
    use LoadSpinner;

    protected $select_items;

    public $order_by = 'id';

    public $order_dir = 'DESC';

    public $items_by_page = 10;

    public $paused_items_by_page = 10;

    public $selected_status = null;

    public $keep_accordion_open = false;

    public $atendente = null;

    public $em_atendimento = null;

    public $cache_keys = [];

    public $log_message = null;

    public $options_data = [];

    public $transferencia_para = null;

    public $transferencia_para_id = null;

    public $transferencia_para_nome = null;

    public function mount(SessionManager $session, array $select = [], int $items_by_page = 10)
    {
        //TODO colocar lógica que permita apenas atenddentes ver essa tela

        $this->select_items = $this->getSelectItems($select, true);
        $this->items_by_page = $items_by_page > 0 && $items_by_page < 200 ? $items_by_page : 10;
        $this->selected_status = StatusEnum::ABERTO;
        $this->keep_accordion_open = session()->get('user_preferences.atendente.chamados_a_atender.keep_accordion_open', false);
        $this->cache_keys = session()->get('cache_keys', []);

        $this->atendente = $this->validateUserPermissions($this->getUsuarioLogado());
        $this->startEmAtendimento();
    }

    protected $listeners = [
        'eventAtenderChamado' => 'atenderChamado',
        'eventFlowTransferirChamado' => 'flowTransferirChamado',
    ];

    public function render()
    {
        return view('livewire.atendimentos-chamado-list', [
            'chamados' => $this->getFilteredChamados([], [
                'atendente' => function ($query) {
                    $query->select('id', 'name', );
                },
            ])
            ->paginate($this->items_by_page),

            'chamados_pausados' => $this->getPausedChamados()
                ->paginate($this->paused_items_by_page),
        ]);
    }

    /**
     * function validateUserPermissions
     *
     * @param  Usuario  $user
     * @return
     */
    protected function validateUserPermissions(Usuario $user)
    {
        $pode_acessar_esta_pagina = $user->hasAnyRole(['atendente']);

        abort_if((! $user || ! $pode_acessar_esta_pagina), 403, 'Permissão insufiente');

        return $user ?? null;
    }

    protected function getChamados(array $columns_to_select = [], array $relationships = [])
    {
        $chamados = Chamado::limit($this->items_by_page)
                    ->orderBy($this->order_by, $this->order_dir)
                    ->with([
                        'usuario' => function ($query) {
                            $query->select('id', 'name', );
                        },
                    ]);

        if (in_array('unidade_id', $columns_to_select)) {
            $chamados = $chamados->with(['unidade' => function ($query) {
                $query->select('id', 'nome', );
            }]);
        }

        $chamados = $chamados->select($this->getSelectItems($columns_to_select, true));

        if ($relationships) {
            $chamados = $chamados->with($relationships);
        }

        $areas = $this->getUsuarioAreas();

        if ($areas && is_array($areas) && count($areas) > 0) {
            $chamados = $chamados->whereRaw('area_id in(' . implode(',', $areas) . ') or area_id is null');
        }

        return $chamados;
    }

    public function getUsuarioAreas(): array
    {
        if (! $this->atendente) {
            return [];
        }

        $areas = $this->atendente->areas ?? [];

        if (! $areas) {
            return [];
        }

        return array_unique(array_values($areas->pluck('id')->toArray()));
    }

    public function getAllAreas(bool $update_cache = false)
    {
        $this->cache_keys['all_areas'] = 'all_areas';

        if ($update_cache) {
            Cache::forget($this->cache_keys['all_areas']);
        }

        return Cache::remember($this->cache_keys['all_areas'], (5 * 60) /*secs*/, fn () => Area::select('id', 'sigla', 'nome')->get());
    }

    protected function getFilteredChamados(array $columns_to_select = [], array $relationships = [])
    {
        $chamados = $this->getChamados($columns_to_select, $relationships);

        if (! $this->selected_status) {
            return $chamados;
        }

        if ($this->selected_status && StatusEnum::getValue($this->selected_status)) {
            $chamados->where('status', $this->selected_status);
        } else {
            $chamados->whereNotIn('status', [
                StatusEnum::PAUSADO,
                StatusEnum::ENCERRADO,
                StatusEnum::EM_ATENDIMENTO,
            ]);
        }

        return $chamados;
    }

    protected function getPausedChamados()
    {
        return Chamado::where('status', StatusEnum::PAUSADO)
        ->select(
            'id',
            'observacao',
            'title',
            'paused_at',
            'tipo_problema_id',
            'problema_id',
            'area_id',
            'usuario_id',
            'atendente_id',
            'unidade_id',
        )
        ->orderBy($this->order_by, $this->order_dir)
        ->with([
            'usuario' => function ($query) {
                $query->select('id', 'name', );
            },
        ])
        ->with(['unidade' => function ($query) {
            $query->select('id', 'nome', );
        }]);
    }

    protected function getUsuarioLogado()
    {
        return Auth::user() ?? null;
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

        if ($return_it) {
            return $this->select_items;
        }
    }

    public function changeOrderBy(?string $order_by = null)
    {
        //Valida se um campo pelo qual deseja ordenar existe na model
        $model = new Chamado();
        $dates = array_merge(array_keys($model->getAttributes()), $model->getDates());
        $accepted_order_by = array_merge($model->getFillable(), $dates);

        $this->order_by = in_array($order_by, $accepted_order_by) ? $order_by : 'id';
        $this->order_dir = $this->order_dir == 'DESC' ? 'ASC' : 'DESC';
    }

    public function changeChamadosAccordionOpenState()
    {
        (new UserPreferencesController())->changeBooleanState('atendente.chamados_a_atender.keep_accordion_open');
        $this->keep_accordion_open = session()->get('user_preferences.atendente.chamados_a_atender.keep_accordion_open', false);
    }

    public function startEmAtendimento(?bool $update_cache = null)
    {
        if (! $this->atendente->id ?? null) {
            $this->closeSpinner();

            return; //TODO validar se o usuário é um atendente
        }

        $this->cache_keys['em_atendimento'] = 'em_atendimento_atendente_id_' . $this->atendente->id;

        if ($update_cache) {
            Cache::forget($this->cache_keys['em_atendimento']);
        }

        $this->em_atendimento = Cache::remember($this->cache_keys['em_atendimento'], (5 * 60) /*secs*/, function () {
            return Chamado::where('status', StatusEnum::EM_ATENDIMENTO)
                ->with([
                    'unidade' => function ($query) {
                        $query->select('id', 'nome', );
                    },
                    'usuario' => function ($query) {
                        $query->select('id', 'name', );
                    },
                    'atendente' => function ($query) {
                        $query->select('id', 'name', );
                    },
                    'logs' => function ($query) {
                        $query->limit(10)
                            ->orderBy('created_at', 'desc')
                            ->with([
                                'usuario' => function ($query) {
                                    $query->select('id', 'name', );
                                },
                            ]);
                    },
                ])
                ->where('atendente_id', $this->atendente->id)
                ->first();
        });

        $this->closeSpinner();
    }

    public function clearCache($cache_key = null)
    {
        $this->toastIt('Cache limpo com sucesso!', 'success', ['preventDuplicates' => true]);
        $this->cache_keys = session()->get('cache_keys', []);

        if ($this->transferencia_para ?? null) {
            self::getOptionsData($this->transferencia_para, true);
        }

        if (! $cache_key) {
            foreach ($this->cache_keys as $key) {
                Cache::forget($key);
                unset($this->cache_keys[$key]);
                session()->forget($key);
            }

            $this->cache_keys = session()->get('cache_keys', []);
        } else {
            Cache::forget($this->cache_keys[$cache_key] ?? null);
        }
    }

    public function pauseCurrent()
    {
        if (! $this->setCurrentAsPaused()) {
            return;
        }

        $this->em_atendimento = null;
        $this->log_message = null;
        $this->startEmAtendimento(true);
    }

    protected function setCurrentAsPaused()
    {
        if (! $this->log_message) {
            $this->toastIt('Favor colocar um registro do atendimento antes de pausar. [ln~' . __LINE__ . ']', 'error', ['preventDuplicates' => true]);

            return;
        }

        if (! $this->minLogChar(10)) {
            return;
        }

        if (! $this->em_atendimento) {
            return;
        }

        if (! $this->em_atendimento instanceof Chamado) {
            return;
        }

        $updated = $this->em_atendimento->update([
            'status' => StatusEnum::PAUSADO,
            'paused_at' => now(),
        ]);

        $this->em_atendimento->logs()->create([
            'content' => $this->log_message ?? 'Pausado',
            'type' => ChamadoLogTypeEnum::PAUSADO,
        ]);

        if ($updated) {
            $this->toastIt('Chamado #' . $this->em_atendimento->id . ' pausado com sucesso!', 'success', ['preventDuplicates' => false]);

            return $updated;
        }

        $this->toastIt('Falha ao pausar o chamado #' . $this->em_atendimento->id . '', 'error', ['preventDuplicates' => false]);
    }

    public function closeCurrent()
    {
        if (! $this->log_message) {
            $this->toastIt('Favor colocar um registro do atendimento antes de encerrar. [ln~' . __LINE__ . ']', 'error', ['preventDuplicates' => true]);

            return;
        }

        if (! $this->minLogChar(10)) {
            return;
        }

        if (! $this->setCurrentAsClosed()) {
            return;
        }

        $this->em_atendimento = null;
        $this->log_message = null;
        $this->startEmAtendimento(true);
    }

    protected function setCurrentAsClosed()
    {
        if (! $this->em_atendimento) {
            return;
        }

        if (! $this->em_atendimento instanceof Chamado) {
            return;
        }

        $updated = $this->em_atendimento->update([
            'status' => StatusEnum::EM_HOMOLOGACAO,
            'conclusion' => $this->log_message,
            'finished_at' => now(),
        ]);

        event(new \App\Events\ChamadoEmHomologacaoEvent($this->em_atendimento));

        if ($updated) {
            $this->em_atendimento->logs()->create([
                'content' => $this->log_message ?? 'Enviado para homologação',
                'type' => ChamadoLogTypeEnum::ENVIADO_PARA_HOMOLOGAÇÃO,
            ]);

            $this->toastIt('Chamado #' . $this->em_atendimento->id . ' encerrado com sucesso!', 'success', ['preventDuplicates' => false]);

            return $updated;
        }

        $this->toastIt('Falha ao encerrar o chamado #' . $this->em_atendimento->id, 'error', ['preventDuplicates' => false]);
    }

    public function atenderChamado($chamado_id)
    {
        if (! $this->atendente->id ?? null) {
            //TODO validar se o usuário é um atendente
            $this->toastIt('Usuário atual não é um atendente! [ln~' . __LINE__ . ']', 'error', ['preventDuplicates' => true]);
            $this->closeSpinner();

            return;
        }

        if ($this->hasEmAtendimento()) {
            $this->toastIt('Já existe um chamado em atendimento! [ln~' . __LINE__ . ']', 'error', ['preventDuplicates' => true]);
            $this->closeSpinner();

            return;
        }

        if (! is_numeric($chamado_id)) {
            $this->toastIt('Falha ao selecionar identificador do chamado! [ln~' . __LINE__ . ']', 'error', ['preventDuplicates' => true]);
            $this->closeSpinner();

            return;
        }

        $chamado = static::getChamadoById((int) $chamado_id)
            ->whereNotIn('status', $this->cantOpenIfStatusIn())->first();

        if (! $chamado) {
            $this->toastIt('Falha ao abrir o chamado! [ln~' . __LINE__ . ']', 'error', ['preventDuplicates' => true]);
            $this->closeSpinner();

            return;
        }

        $update = $chamado->update([
            'status' => StatusEnum::EM_ATENDIMENTO,
            'atendente_id' => $this->atendente->id,
        ]);

        if (! $update) {
            $this->toastIt('Falha ao atualizar o chamado! [ln~' . __LINE__ . ']', 'error', ['preventDuplicates' => true]);
            $this->closeSpinner();

            return;
        }

        $chamado->logs()->create([
            'content' => 'Iniciado atendimento. Atendente: ' . $this->atendente->name ?? null,
            'type' => ChamadoLogTypeEnum::ATENDIMENTO_INICIADO,
        ]);

        $this->startEmAtendimento(true);

        $this->closeSpinner();
    }

    public function cantOpenIfStatusIn(array $and_this = [])
    {
        return array_merge([
            StatusEnum::ENCERRADO,
            StatusEnum::EM_ATENDIMENTO,
            StatusEnum::EM_HOMOLOGACAO,
            StatusEnum::HOMOLOGADO,
        ], $and_this);
    }

    public function chamadoPodeSerAtendido($chamado_status)
    {
        return ! in_array($chamado_status, $this->cantOpenIfStatusIn());
    }

    protected static function getChamadoById(int $chamado_id)
    {
        return Chamado::where('id', $chamado_id)
            ->with([
                'unidade' => function ($query) {
                    $query->select('id', 'nome', );
                },
                'usuario' => function ($query) {
                    $query->select('id', 'name', );
                },
                'logs' => function ($query) {
                    $query->limit(10)
                        ->orderBy('created_at', 'desc')
                        ->with([
                            'usuario' => function ($query) {
                                $query->select('id', 'name', );
                            },
                        ]);
                },
            ]);
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
            'closeButton' => true,
            'debug' => false,
            'newestOnTop' => true,
            'preventDuplicates' => false,
        ];

        $toast_type = in_array($toast_type, $accepted_types) ? $toast_type : 'success';
        $options = array_merge($default_options, $options);
        $this->emit('newToastMessage', compact('message', 'toast_type', 'options'));
    }

    public function confirm($message, $callback, ...$argv)
    {
        $this->emit('confirm', compact('message', 'callback', 'argv'));
    }

    public function tranferirChamado()
    {
        if (! $this->em_atendimento ?? null) {
            $this->closeSpinner();

            return;
        }

        if (! $this->exigeLogMessage(5)) {
            $this->closeSpinner();

            return;
        }

        $chamado_id = $this->em_atendimento->id;
        $this->emit('tranferirChamadoEvent', compact('chamado_id'));
        $this->closeSpinner();
    }

    protected function exigeLogMessage(int $min_chars = 5)
    {
        if (! $this->log_message || ! strlen($this->log_message) >= $min_chars) {
            $this->toastIt("Favor informar um registro de atendimento com no mínimo {$min_chars} caracteres.", 'error', ['preventDuplicates' => true]);
            $this->emit('reOpenModalTransferenciaPorEvent');

            return false;
        }

        return true;
    }

    public function transferenciaPor(string $transferencia_para)
    {
        $this->transferencia_para_id = null;
        $this->transferencia_para_nome = null;

        $accept_values = [
            'area' => [
                'formated_title' => 'Área',
                'formated_label' => 'Selecione uma área para transferir',
            ],
            'atendente' => [
                'formated_title' => 'Atendente',
                'formated_label' => 'Selecione um atendente para transferir',
            ],
        ];

        if (! in_array($transferencia_para, array_keys($accept_values))) {
            $this->emit('closeModalTransferenciaPorEvent');

            return;
        }

        $formated_data = $accept_values[$transferencia_para] ?? [];
        $formated_options = $this->getOptionsData($transferencia_para);

        if (! $formated_options) {
            $this->emit('closeModalTransferenciaPorEvent');
            $this->toastIt("Sem opções disponíveis para '{$transferencia_para}'", 'error', ['preventDuplicates' => true]);

            return;
        }

        $this->options_data = [
            'title' => $formated_data['formated_title'] ?? "Selecione um {$transferencia_para} para transferir",
            'label' => $formated_data['formated_label'] ?? "Selecione um {$transferencia_para} para transferir",
            'options' => $formated_options,
        ];

        $options_data = json_encode($this->options_data ?? []);

        $this->transferencia_para = $transferencia_para;
        $this->emit('transferenciaPorEvent', compact('transferencia_para', 'options_data', 'formated_data'));
    }

    public function alterado()
    {
        $this->emit('reOpenModalTransferenciaPorEvent');

        $this->transferencia_para_nome = $this->transferencia_para_id
                                        ? $this->getSelectedToTransferName($this->transferencia_para_id) : null;

        if ($this->transferencia_para_nome) {
            $this->toastIt(
                'Alterado para: '
                            . $this->transferencia_para_nome
                            . ' (' . $this->transferencia_para . ')',
                'success',
                ['preventDuplicates' => true]
            );
        }
    }

    public function getSelectedToTransferName($transferencia_para_id)
    {
        $options = $this->getOptionsData($this->transferencia_para) ?? [];

        if (! $options || ! $transferencia_para_id) {
            return null;
        }

        $first = Arr::where($options, function ($value, $key) use ($transferencia_para_id) {
            $id = data_get($value, 'id');

            return $id == $transferencia_para_id;
        });

        $label = is_array($first) ? (head($first)['label'] ?? null) : null;

        return $label ?? null;
    }

    public function concluirTransferencia()
    {
        $destinos_validos = in_array($this->transferencia_para, ['area', 'atendente']);

        if (! $destinos_validos || ! $this->em_atendimento || ! $this->transferencia_para || ! $this->transferencia_para_id) {
            $this->toastIt('Dados insuficientes', 'error', ['preventDuplicates' => true]);
            $this->emit('reOpenModalTransferenciaPorEvent');
            $this->closeSpinner();

            return;
        }

        if (! $this->exigeLogMessage(5)) {
            $this->closeSpinner();

            return;
        }

        if ($this->transferencia_para == 'area') {
            $updated = $this->em_atendimento->update([
                'status' => StatusEnum::TRANSFERIDO,
                'area_id' => $this->transferencia_para_id,
                'atendente_id' => null,
            ]);
        }

        if ($this->transferencia_para == 'atendente') {
            $updated = $this->em_atendimento->update([
                'status' => StatusEnum::TRANSFERIDO,
                'area_id' => null,
                'atendente_id' => $this->transferencia_para_id,
            ]);
        }

        if ($updated ?? null) {
            $this->toastIt(
                "concluirTransferencia() 'transferencia_para_id' "
                            . $this->transferencia_para . ' id:'
                            . $this->transferencia_para_id,
                'success',
                ['preventDuplicates' => true]
            );

            $this->emit('closeModalTransferenciaPorEvent');

            $this->em_atendimento = null;
            $this->log_message = null;
            $this->limpaValoresDasPropriedades();
            $this->startEmAtendimento(true);

            $this->closeSpinner();

            return;
        }

        $this->em_atendimento->logs()->create([
            'content' => $this->log_message ?? 'Transferido',
            'type' => ChamadoLogTypeEnum::TRANSFERIDO,
        ]);

        $this->closeSpinner();
        $this->toastIt('Falha ao transferir chamado', 'error', ['preventDuplicates' => true]);
    }

    protected function limpaValoresDasPropriedades()
    {
        //Transferencia
        $this->transferencia_para = null;
        $this->transferencia_para_id = null;
        $this->transferencia_para_nome = null;
    }

    public function getOpcoesParaTranferencia(?string $transferencia_para = null)
    {
        return $this->options_data ?? [];
    }

    public function cancelaTranferencia($limpa_valores = null)
    {
        $this->emit('closeModalTransferenciaPorEvent');

        if ($limpa_valores) {
            $this->limpaValoresDasPropriedades();
        }

        $this->closeSpinner();
    }

    protected function getOptionsData(string $transferencia_para, bool $clear_cache = false)
    {
        $accept_values = ['area', 'atendente'];

        if (! in_array($transferencia_para, $accept_values)) {
            return [];
        }

        $cache_key = Str::slug(Arr::query(['methd' => 'getOptionsData', 'transferencia_para' => $transferencia_para]));

        if ($clear_cache) {
            Cache::forget($cache_key);
        }

        if ($transferencia_para == 'area') {
            return Cache::remember($cache_key, (30 * 60/*secs*/), function () {
                $areas = AreaCache::allWhithoutRelationships(['id', 'sigla', 'nome']);

                $data = [];
                foreach ($areas as $area) {
                    $data[] = ['id' => $area->id, 'label' => '#' . $area->id . ' - ' . $area->sigla . ' - ' . $area->nome];
                }

                return $data ?? [];
            });
        }

        if ($transferencia_para == 'atendente') {
            return Cache::remember($cache_key, (30 * 60/*secs*/), function () {
                $atendentes = AtendenteCache::all(['id', 'name']);

                $data = [];
                foreach ($atendentes as $atendente) {
                    $data[] = ['id' => $atendente->id, 'label' => '#' . $atendente->id . ' - ' . $atendente->name];
                }

                return $data ?? [];
            });
        }

        return [];
    }

    public function flowTransferirChamado($chamado_id)
    {
        if (! $chamado_id || ! is_numeric($chamado_id)) {
            return;
        }

        if ($this->hasEmAtendimento()) {
            $this->toastIt('Já existe um chamado em atendimento! [ln~' . __LINE__ . ']', 'error', ['preventDuplicates' => true]);

            return;
        }

        if (! $this->em_atendimento) {
            $this->atenderChamado($chamado_id);
        }

        $this->startEmAtendimento(true);

        if ($this->em_atendimento->id ?? null == $chamado_id) {
            $this->log_message = 'Transferência direta de chamado';
            $this->tranferirChamado();
        }
    }

    /**
     * function minLogChar
     *
     * @param  int  $min_chars
     * @return
     */
    public function minLogChar(int $min_chars = 10)
    {
        if (strlen($this->log_message) < $min_chars) {
            $this->toastIt('O registro do atendimento precisa ter no mínimo 10 caracteres. [ln~' . __LINE__ . ']', 'error', ['preventDuplicates' => true]);

            return false;
        }

        return true;
    }
}

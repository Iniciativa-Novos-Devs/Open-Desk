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

    public function mount(SessionManager $session, array $select = [], int $items_by_page = 10)
    {
        //TODO colocar lógica que permita apenas atenddentes ver essa tela

        $this->select_items         = $this->getSelectItems($select, true);
        $this->items_by_page        = $items_by_page > 0 && $items_by_page < 200 ? $items_by_page : 10;
        $this->selected_status      = null;
        $this->keep_accordion_open  = session()->get('user_preferences.atendente.chamados_a_atender.keep_accordion_open', false);
        $this->cache_keys           = session()->get('cache_keys', []);
        $this->atendente            = $this->getUsuario();
        $this->startEmAtendimento();
    }

    public function render()
    {
        return view('livewire.atendimentos-chamado-list', [
            'chamados' => $this->getChamados()
                ->whereNotIn('status', [
                    StatusEnum::PAUSADO,
                    StatusEnum::FECHADO,
                    StatusEnum::EM_ATENDIMENTO,
                ])
                ->paginate($this->items_by_page),

            'chamados_pausados' => $this->getChamados([
                    'unidade_id',
                    'observacao',
                    'title',
                    'paused_at',
                ])
                ->where('status', StatusEnum::PAUSADO)
                ->paginate($this->paused_items_by_page),
        ]);
    }

    protected function getChamados(array $columns_to_select = [])
    {
        $chamados = Chamado::limit($this->items_by_page)
                    ->orderBy($this->order_by, $this->order_dir)
                    ->with(['usuario' => function($query) {
                        $query->select('id','name',);
                    }]);

        if(in_array('unidade_id', $columns_to_select))
            $chamados = $chamados->with(['unidade' => function($query) {
                $query->select('id','nome',);
            }]);

        $chamados = $chamados->select($this->getSelectItems($columns_to_select, true));

        if($this->selected_status && StatusEnum::getState($this->selected_status))
            $chamados->where('status', $this->selected_status);

        return $chamados;
    }

    protected function getUsuario()
    {
        return UsuarioCache::byLoggedUser();
    }

    protected function getSelectItems(array $select_array_from_param_data = [], bool $return_it = false)
    {
        $required_select_items = [
            'id',
            'problema_id',
            'usuario_id',
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
                ])
                ->where('atendente_id', $this->atendente->id)
                ->first();
        });
    }

    public function clearCache($cache_key = null)
    {
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
}

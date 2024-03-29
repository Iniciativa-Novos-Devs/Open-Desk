<?php

namespace App\Http\Livewire;

use App\Enums\StatusEnum;
use App\Http\Controllers\Admin\UserPreferencesController;
use App\Http\Livewire\Traits\LoadSpinner;
use App\Models\Chamado;
use Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ChamadoList extends Component
{
    use WithPagination;
    use LoadSpinner;

    protected $select_items;

    public $order_by = 'id';

    public $order_dir = 'DESC';

    public $items_by_page = 10;

    public $show_action_buttons = false;

    public $keep_accordion_open = true;

    public $usuario = null;

    public $selected_status;

    public bool $apenas_chamados_do_usuario = false;

    public function mount(array $select = [], int $items_by_page = 10, bool $show_action_buttons = false, bool $apenas_chamados_do_usuario = false)
    {
        $this->select_items = $this->getSelectItems($select, true);
        $this->items_by_page = $items_by_page > 0 && $items_by_page < 200 ? $items_by_page : 10;
        $this->selected_status = StatusEnum::ABERTO;
        $this->show_action_buttons = $show_action_buttons;
        $this->usuario = $this->getUsuarioLogado();
        $this->keep_accordion_open = session()->get('user_preferences.atendente.chamados_a_atender.keep_accordion_open', true);
    }

    public function render()
    {
        return view('livewire.chamado-list', [
            'chamados' => $this->getFilteredChamados(
                [
                    'homologado_em',
                    'atendente_id',
                ],
                [
                    'atendente' => function ($query) {
                        $query->select('id', 'name', );
                    },
                ]
            )
            ->paginate($this->items_by_page),
        ]);
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

    protected function getChamados(array $columns_to_select = [], array $relationships = [])
    {
        $chamados = Chamado::limit($this->items_by_page)
                    ->orderBy($this->order_by, $this->order_dir)
                    ->with([
                        'usuario' => function ($query) {
                            $query->select('id', 'name', );
                        },
                        'atendente' => function ($query) {
                            $query->select('id', 'name', );
                        },
                    ]);

        if ($this->apenas_chamados_do_usuario) {
            $chamados->where('usuario_id', $this->usuario->id);
        }

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

    protected function getUsuarioLogado()
    {
        return Auth::user();
    }

    protected function getSelectItems(array $select_array_from_param_data = [], bool $return_it = false)
    {
        $required_select_items = [
            'id',
            'status',
            'created_at',
            'title',
            'tipo_problema_id',
            'problema_id',
            'area_id',
            'usuario_id',
            'homologado_por',
            'atendente_id',
            'unidade_id',
            'homologacao_observacao_back',
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

    public function changeChamadosAccordionOpenState()
    {
        (new UserPreferencesController())->changeBooleanState('atendente.chamados_a_atender.keep_accordion_open');
        $this->keep_accordion_open = session()->get('user_preferences.atendente.chamados_a_atender.keep_accordion_open', false);
    }

    public function getUsuarioAreas(): array
    {
        if (! $this->usuario) {
            return [];
        }

        $areas = $this->usuario->areas ?? [];

        if (! $areas) {
            return [];
        }

        return array_unique(array_values($areas->pluck('id')->toArray()));
    }

    public function emmitAtenderChamado($chamado_id)
    {
        $this->openSpinner();

        if (! $chamado_id || ! is_numeric($chamado_id)) {
            $this->closeSpinner();

            return;
        }

        // $this->emitTo('atendimentos-chamado-list', 'eventAtenderChamado', ['chamado' => $chamado_id]);
        if ((bool) $this->show_action_buttons) {
            $this->emitUp('eventAtenderChamado', $chamado_id);
        }
    }

    public function emmitFlowTransferirChamado($chamado_id)
    {
        if (! $chamado_id || ! is_numeric($chamado_id)) {
            return;
        }

        if ((bool) $this->show_action_buttons) {
            $this->emitUp('eventFlowTransferirChamado', $chamado_id);
        }
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Chamado;
use App\Models\Usuario;
use Livewire\Component;
use App\Enums\StatusEnum;

class AtendimentosChamadoList extends Component
{
    protected $select_items;

    public $order_by      = 'id';
    public $order_dir     = 'DESC';
    public $items_by_page = 10;
    public $selected_status;

    public function mount(array $select = [], int $items_by_page = 10)
    {
        // dd($items_by_page);
        $this->select_items     = $this->getSelectItems($select, true);
        $this->items_by_page  = $items_by_page > 0 && $items_by_page < 200 ? $items_by_page : 10;
        $this->selected_status  = null;
    }

    public function render()
    {
        return view('livewire.atendimentos-chamado-list', [
            'chamados' => $this->getChamados()->paginate($this->items_by_page),
        ]);
    }

    protected function getChamados()
    {
        $chamados = Chamado::limit($this->items_by_page)
                    ->orderBy($this->order_by, $this->order_dir)
                    ->with(['usuario' => function($query) {
                        $query->select('id','name',);
                    }]);

        $chamados = $chamados->select($this->getSelectItems([], true));

        $usuario = $this->getUsuario();

        if($this->selected_status && StatusEnum::getState($this->selected_status))
            $chamados->where('status', $this->selected_status);

        if($usuario)
            $chamados->where('usuario_id', $usuario->id);

        return $chamados;
    }

    protected function getUsuario()
    {
        //TODO fazer buscar o usuario logado
        return Usuario::first();
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
}

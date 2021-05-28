<?php

namespace App\Http\Livewire;

use App\Models\Chamado;
use App\Models\Usuario;
use Livewire\Component;
use App\Enums\StatusEnum;

class ChamadoList extends Component
{
    protected $select_items;
    public $max_limit_start;
    public $selected_status;

    public function mount(array $select = [], int $max_limit_start = 10)
    {
        $this->select_items     = $this->getSelectItems($select, true);
        $this->max_limit_start  = $max_limit_start > 0 && $max_limit_start < 200 ? $max_limit_start : 10;
        $this->selected_status  = null;
    }

    public function render()
    {
        return view('livewire.chamado-list', [
            'chamados' => $this->getChamados()->paginate(10),
        ]);
    }

    protected function getChamados()
    {
        $chamados = Chamado::limit($this->max_limit_start);
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
            'observacao',
            'created_at',
        ];

        $this->select_items = array_merge($required_select_items, ($select_array_from_param_data ?? []));

        if($return_it)
            return $this->select_items;
    }
}

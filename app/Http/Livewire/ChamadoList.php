<?php

namespace App\Http\Livewire;

use App\Models\Chamado;
use App\Models\Usuario;
use Livewire\Component;

class ChamadoList extends Component
{
    protected $select_items;
    public $max_limit_start;

    public function mount(array $select = [], int $max_limit_start = 10)
    {
        $this->select_items    = $this->getSelectItems($select);
        $this->max_limit_start = $max_limit_start > 0 && $max_limit_start < 200 ? $max_limit_start : 10;
    }

    public function render()
    {
        return view('livewire.chamado-list', [
            'chamados' => $this->getChamados()->get(),
        ]);
    }

    public function getChamados()
    {
        $chamados = Chamado::limit($this->max_limit_start);
        $chamados = $chamados->select($this->select_items);

        $usuario = $this->getUsuario();

        if($usuario)
            $chamados->where('usuario_id', $usuario->id);

        return $chamados;
    }

    protected function getUsuario()
    {
        //TODO fazer buscar o usuario logado
        return Usuario::first();
    }

    protected function getSelectItems(array $select_array_from_param_data = [])
    {
        $required_select_items = [
            'id',
            'problema_id',
            'usuario_id',
            'status',
            'observacao',
            'created_at',
        ];

        $select_items = array_merge($required_select_items, ($select_array_from_param_data ?? []));

        return $select_items;
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Chamado;
use Livewire\Component;
use Livewire\WithPagination;
use Auth;

class HomologacaoIndex extends Component
{
    use WithPagination;

    public $order_by      = 'finished_at';
    public $order_dir     = 'DESC';
    public $items_by_page = 10;
    public $usuario       = null;
    public $filtro        = null;
    public $filtro_input  = null;

    public function mount()
    {
        $this->usuario     = Auth::user();
        if(!$this->usuario)
            return redirect()->route('dashboard')->with('error', 'Usuario não autenticado');

        $this->filtro  = $filtro_input = request()->input('filtro') ?? null;
    }

    public function render()
    {
        return view('livewire.homologacao-index', [
            'chamados' => $this->getChamados()
                ->paginate($this->items_by_page),
        ]);
    }

    public function getChamados()
    {
        $chamados   = Chamado::where('usuario_id', $this->usuario->id);

        $chamados->with([
            'atendente' => function($query) {
                $query->select('id','name',);
            },
        ])
        ->orderBy($this->order_by, $this->order_dir);

        if($this->filtro == 'pendentes')
            $chamados = $chamados->whereNull('homologado_em');

        if($this->filtro == 'homologados')
            $chamados = $chamados->whereNotNull('homologado_em');

        return $chamados;
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

    public function getFiltros()
    {
        return [
            'pendentes',
            'homologados',
        ];
    }
}

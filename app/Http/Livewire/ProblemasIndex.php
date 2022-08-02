<?php

namespace App\Http\Livewire;

use App\Models\Atividade;
use App\Models\Problema;
use Livewire\Component;
use Livewire\WithPagination;

class ProblemasIndex extends Component
{
    use WithPagination;

    public $order_by = 'id';

    public $order_dir = 'DESC';

    public $items_by_page = 10;

    public $atividade_atual = null;

    public $atividades = null;

    public function mount($atividade_id = null)
    {
        $this->atividades = Atividade::orderBy('id', 'asc')->get();
        $this->atividade_atual = $atividade_id ?? request()->input('atividade') ?? null;
    }

    public function render()
    {
        return view('livewire.problemas-index', [
            'problemas' => $this->setProblemas()->paginate($this->items_by_page),
        ]);
    }

    public function setProblemas()
    {
        $problemas = Problema::with('atividade')->orderBy($this->order_by, $this->order_dir);

        if ($this->atividade_atual) {
            $problemas = $problemas->where('atividade_area_id', $this->atividade_atual);
        }

        return $problemas;
    }

    public function changeOrderBy(string $order_by = null)
    {
        //Valida se um campo pelo qual deseja ordenar existe na model
        $model = new Problema();
        $dates = array_merge(array_keys($model->getAttributes()), $model->getDates());
        $accepted_order_by = array_merge($model->getFillable(), $dates);

        $this->order_by = in_array($order_by, $accepted_order_by) ? $order_by : 'id';
        $this->order_dir = $this->order_dir == 'DESC' ? 'ASC' : 'DESC';
    }

    public function changeAtividadeAtual($atividade_atual)
    {
        if (! is_numeric($atividade_atual)) {
            return;
        }

        $this->atividade_atual = (int) $atividade_atual;
    }
}

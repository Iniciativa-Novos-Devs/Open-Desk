<?php

namespace App\Http\Livewire;

use App\Models\Area;
use App\Models\Atividade;
use Livewire\Component;
use Livewire\WithPagination;

class AtividadesIndex extends Component
{
    use WithPagination;

    public $order_by = 'id';

    public $order_dir = 'DESC';

    public $items_by_page = 10;

    public $area_atual = null;

    public $areas = null;

    public function mount()
    {
        $this->areas = Area::all();
        $this->area_atual = request()->input('area') ?? null;
    }

    public function render()
    {
        return view('livewire.atividades-index', [
            'atividades' => $this->setAtividades()->paginate($this->items_by_page),
        ]);
    }

    public function setAtividades()
    {
        $atividades = Atividade::with('area')->orderBy($this->order_by, $this->order_dir);

        if ($this->area_atual) {
            $atividades = $atividades->where('area_id', $this->area_atual);
        }

        return $atividades;
    }

    public function changeOrderBy(?string $order_by = null)
    {
        //Valida se um campo pelo qual deseja ordenar existe na model
        $model = new Atividade();
        $dates = array_merge(array_keys($model->getAttributes()), $model->getDates());
        $accepted_order_by = array_merge($model->getFillable(), $dates);

        $this->order_by = in_array($order_by, $accepted_order_by) ? $order_by : 'id';
        $this->order_dir = $this->order_dir == 'DESC' ? 'ASC' : 'DESC';
    }
}

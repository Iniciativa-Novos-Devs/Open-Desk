<?php

namespace App\Http\Livewire;

use App\Models\Atividade;
use App\Models\Problema;
use Livewire\Component;

class ChamadoProblemaAreaSelect extends Component
{
    public $atividades_area;
    public $atividade_id = null;

    public function mount()
    {
        $this->atividades_area  = Atividade::select('id', 'nome', 'area_id')->get();
    }

    public function render()
    {
        return view('livewire.chamado-problema-area-select', [
            'problemas' => $this->getProblemas()->get(),
        ]);
    }

    private function getProblemas()
    {
        if ($this->atividade_id && is_numeric($this->atividade_id))
            return Problema::where('atividade_area_id', $this->atividade_id)->select('id', 'descricao');
        else
            return Problema::select('id', 'descricao');
    }
}

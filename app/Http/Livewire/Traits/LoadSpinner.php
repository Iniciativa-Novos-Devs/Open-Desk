<?php

namespace App\Http\Livewire\Traits;

use Livewire\Component;

trait LoadSpinner
{
    public function openSpinner()
    {
        $this->emit('openSpinner');
    }

    public function closeSpinner()
    {
        $this->emit('closeSpinner');
    }
}

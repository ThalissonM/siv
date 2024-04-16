<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ModelosVeiculos;

class SelectModeloVeiculo extends Component
{

    public $selectedModelo;

    public function render()
    {
        $modelos = ModelosVeiculos::all();

        return view('livewire.select-modelo-veiculo', [
            'modelos' => $modelos,
        ]);
    }
}

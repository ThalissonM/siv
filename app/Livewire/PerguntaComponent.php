<?php

namespace App\Livewire;

use App\Models\Perguntas;
use Livewire\Component;

class PerguntaComponent extends Component
{
    public $modelo_veiculo_id;
    public $pergunta;

    public function render()
    {
        $perguntas = Perguntas::where('modelo_veiculo_id', $this->modelo_veiculo_id)->get();

        return view('livewire.pergunta-component', compact('perguntas'));
    }

    public function addPergunta()
    {
        // dd($this->modelo_veiculo_id);
        // dd($this->pergunta);
        Perguntas::create([
            'modelo_veiculo_id' => $this->modelo_veiculo_id,
            'pergunta' => $this->pergunta,
        ]);

        $this->reset(['pergunta']); // Reset the input field after adding a question
    }

    public function deletePergunta($perguntaId)
    {
        Perguntas::find($perguntaId)->delete();
    }
}

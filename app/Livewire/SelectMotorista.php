<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Motoristas;
class SelectMotorista extends Component
{

    public $i          = 1;
    public $motoristas  = [];
    
        public $inputsearchmotorista = '';
    public $motorista_id;
    
    public function selectmotorista($motorista_id, $terms)
    {
    
        $this->motorista_id = $motorista_id;
        $this->terms = $terms;
        $this->inputsearchmotorista='';
    }
     public function render()
        {
    
            $searchmotoristas = [];
    
            if(strlen($this->inputsearchmotorista)>=2){
                $searchmotoristas = Motoristas::where('nome', 'LIKE' , '%'.$this->inputsearchmotorista.'%')
                                            ->orWhere('documento', 'LIKE' , '%'.$this->inputsearchmotorista.'%')
                                            ->get();
            }
        
            
            return view('livewire.select-motorista')->with(['searchmotoristas' => $searchmotoristas]);
          
        }

    
}

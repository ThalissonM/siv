<?php

namespace App\Http\Controllers;

use App\Models\Inspecoes;
use App\Models\ModelosVeiculos;
use App\Models\Veiculos;
use Illuminate\Http\Request;

class VeiculosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('veiculos.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $modelos =ModelosVeiculos::all();
        return view('veiculos.new',['modelos'=>$modelos]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        //
        // dd($request);
        $validate = $request->validate(
            [
                'id'=>'int',
                'modelo_veiculo_id'=>'int',
                'placa'=>'required|min:3|max:40',
                'prefixo'=>'max:40', // 'required|min:3|max:40
                'condicao'=>'max:40',
                'horas'=>'integer',
                'km'=>'integer',
                'image'=>'image'
            ]
        );
        // dd($validate);
        $veiculo = new Veiculos;

        if(isset($validate['id']))
        {
            $veiculo=Veiculos::find($validate['id']);
        }

        if(isset($validate['modelo_veiculo_id']))
        {
            $veiculo->modelo_veiculo_id=$validate['modelo_veiculo_id'];
        }
        if(isset($validate['placa']))
        {
            $veiculo->placa=$validate['placa'];
        }
        if(isset($validate['prefixo']))
        {
            $veiculo->prefixo=$validate['prefixo'];
        }
        if(isset($validate['condicao']))
        {
            $veiculo->condicao=$validate['condicao'];
        }
        if(isset($validate['horas']))
        {
            $veiculo->horas=$validate['horas'];
        }
        if(isset($validate['km']))
        {
            $veiculo->km=$validate['km'];
        }

        // $veiculo->modelo_veiculo_id=$validate['modelo_veiculo_id'];
        // $veiculo->placa=$validate['placa'];
        // $veiculo->condicao=$validate['condicao'];
        // $veiculo->horas=$validate['horas'];
        // $veiculo->km=$validate['km'];
        
        
        if(isset($validate['image']))//$request->has('image'))
        {
            // $filepath = $request->file('image')->store('modelos','public');
            // $validate['image']=$filepath;
            if($veiculo->image!=null)
            {
                $this->deleteImage($veiculo->image);
            }
            $veiculo->image=$validate['image'];
            $file = $request->file('image');

            // Generate a unique filename or use the original name
            $filename = uniqid() . '_' . $file->getClientOriginalName();


            
            $file->move(public_path('/modelos/'), $filename);
            

            $veiculo->image='/modelos/'.$filename;

        }


        
        $veiculo->save();
        return redirect('veiculos/edit/'.$veiculo->id);
    }


    /**
     * Display the specified resource.
     */
    public function show(Veiculos $veiculos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Veiculos $veiculo)
    {
        //
        return view('veiculos.edit',['veiculo'=>$veiculo]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Veiculos $veiculos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Veiculos $veiculos)
    {
        //
                //
        // dd(auth()->user()->role);
        $inspecoes = Inspecoes::where('veiculo_id',$veiculos->id)->count();
        if($inspecoes)
        {
            session()->flash('flash.banner', 'Eixtem veículos vinculados a este modelo');
            session()->flash('flash.bannerStyle', 'danger');
            return redirect()->back();
        }
        // dd($veiculos);
        session()->flash('flash.banner', 'Removido!');
        session()->flash('flash.bannerStyle', 'success');
        $veiculos->delete();
        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Inspecoes;
use App\Models\Motoristas;
use Illuminate\Http\Request;

class MotoristasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('motoristas.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('motoristas.new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        //
        // dd($request->all());
        $validate = $request->validate(
            [
                'id'=>'int',
                'nome'=>'required|min:3|max:40',
                'documento'=>'required|min:3|max:40',
                'ativo' => 'nullable',
                'image'=>'image'
            ]
        );
        // dd($validate);
        $motorista = new Motoristas;

        if(isset($validate['id']))
        {
            $motorista=Motoristas::find($validate['id']);
        }

        $motorista->nome=$validate['nome'];
        $motorista->documento=$validate['documento'];
        if(isset($validate['ativo']))
        {
            $motorista->ativo=true;
        }
        else
        {
            $motorista->ativo=false;
        }
        // $motorista->ativo=$validate['ativo'];

        
        
        if(isset($validate['image']))//$request->has('image'))
        {
            // $filepath = $request->file('image')->store('modelos','public');
            // $validate['image']=$filepath;
            if($motorista->image!=null)
            {
                $this->deleteImage($motorista->image);
            }
            $motorista->image=$validate['image'];
            $file = $request->file('image');

            // Generate a unique filename or use the original name
            $filename = uniqid() . '_' . $file->getClientOriginalName();


            
            $file->move(public_path('/motorist/'), $filename);
            

            $motorista->image='/motorist/'.$filename;

        }


        
        $motorista->save();
        return redirect('motoristas/edit/'.$motorista->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Motoristas $motoristas)
    {
        //
        return view('motoristas.view',$motoristas);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Motoristas $motorista)
    {
        //
        return view('motoristas.edit',['motorista'=>$motorista]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Motoristas $motoristas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Motoristas $motoristas)
    {
        //

        if(auth()->user()->role!='admin')
        {
            session()->flash('flash.banner', 'Sem Autorização');
            session()->flash('flash.bannerStyle', 'danger');
            return redirect()->back();
        }
        $veiculos = Inspecoes::where('motorista_id',$motoristas->id)->count();
        if($veiculos)
        {
            session()->flash('flash.banner', 'Eixtem veículos vinculados a este modelo');
            session()->flash('flash.bannerStyle', 'danger');
            return redirect()->back();
        }
        // dd($veiculos);
        session()->flash('flash.banner', 'Removido!');
        session()->flash('flash.bannerStyle', 'success');
        $motoristas->delete();
        return redirect()->back();
    }

    public function getData(Request $request)
    {
        $data=Motoristas::where('nome','like','%'.$request->searchItem.'%')
        ->orWhere('documento','like','%'.$request->searchItem.'%');
        return $data->paginate(10,['*'],'page',$request->page);
    }
}

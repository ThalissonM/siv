<?php

namespace App\Http\Controllers;

use App\Models\ModelosVeiculos;
use App\Models\Veiculos;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ModelosVeiculosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('modelos_veiculos.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('modelos_veiculos.new');
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
                'modelo'=>'required|min:3|max:40',
                'image'=>'image'
            ]
        );
        // dd($validate);
        $modelo = new ModelosVeiculos;

        if(isset($validate['id']))
        {
            $modelo=ModelosVeiculos::find($validate['id']);
        }

        $modelo->modelo=$validate['modelo'];
        
        if(isset($validate['image']))//$request->has('image'))
        {
            // $filepath = $request->file('image')->store('modelos','public');
            // $validate['image']=$filepath;
            if($modelo->image!=null)
            {
                $this->deleteImage($modelo->image);
            }
            $modelo->image=$validate['image'];
            $file = $request->file('image');

            // Generate a unique filename or use the original name
            $filename = uniqid() . '_' . $file->getClientOriginalName();


            
            $file->move(public_path('/modelos/'), $filename);
            

            $modelo->image='/modelos/'.$filename;

        }


        
        $modelo->save();
        return redirect('modelos_veiculos/edit/'.$modelo->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(ModelosVeiculos $modelosVeiculos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ModelosVeiculos $modelosVeiculo)
    {
        //
        // dd($modelosVeiculo);
        
        return view('modelos_veiculos.edit',['modelo'=>$modelosVeiculo]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ModelosVeiculos $modelosVeiculos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ModelosVeiculos $modelosVeiculos)
    {
        //
        // dd(auth()->user()->role);
        if(auth()->user()->role!='admin')
        {
            session()->flash('flash.banner', 'Sem Autorização');
            session()->flash('flash.bannerStyle', 'danger');
            return redirect()->back();
        }
        $veiculos = Veiculos::where('modelo_veiculo_id',$modelosVeiculos->id)->count();
        if($veiculos)
        {
            session()->flash('flash.banner', 'Eixtem veículos vinculados a este modelo');
            session()->flash('flash.bannerStyle', 'danger');
            return redirect()->back();
        }
        // dd($veiculos);
        session()->flash('flash.banner', 'Removido!');
        session()->flash('flash.bannerStyle', 'success');
        $modelosVeiculos->delete();
        return redirect()->back();

    }

    public function deleteImage($filename)
{
    $filePath = public_path($filename);

    if (File::exists($filePath)) {
        File::delete($filePath);
        return true;
    } else {
        return false;
    }
}
}

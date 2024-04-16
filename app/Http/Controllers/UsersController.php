<?php

namespace App\Http\Controllers;

use App\Models\Inspecoes;
use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        if(auth()->user()->role!='admin')
        {
            session()->flash('flash.banner', 'Sem Autorização');
            session()->flash('flash.bannerStyle', 'danger');
            return redirect('dashboard');
        }

        return view('users.index');
    }
    public function create()
    {
        //
        if(auth()->user()->role!='admin')
        {
            session()->flash('flash.banner', 'Sem Autorização');
            session()->flash('flash.bannerStyle', 'danger');
            return redirect('dashboard');
        }
        return view('users.new');
    }



    public function store(Request $request)
    {
        if(auth()->user()->role!='admin')
        {
            session()->flash('flash.banner', 'Sem Autorização');
            session()->flash('flash.bannerStyle', 'danger');
            return redirect('dashboard');
        }
        
        //
        // dd($request);


        $validate = $request->validate(
            [
                'id'=>'int',
                'name'=>'required|min:3|max:40',
                'email'=>'required|min:3|max:40',
                'password'=>'required|min:3|max:40',
                'passwordverify'=>'required|min:3|max:40',
                'role'=>'required|min:3|max:40',
                'active'=>'boolean',
            ]
        );

        if($validate['password']!=$validate['passwordverify'])
        {
            session()->flash('flash.banner', 'As senhas não são iguais');
            session()->flash('flash.bannerStyle', 'danger');
            return redirect()->back();
        }
        // dd($validate);
        $user = new User;

        if(isset($validate['id']))
        {
            $user=User::find($validate['id']);
        }

        $user->name=$validate['name'];
        $user->email=$validate['email'];
        $user->password=Hash::make($validate['password']);
        $user->role=$validate['role'];
        if(isset($validate['active']))
        {
            $user->active=true;
        }
        else{
            $user->active=false;
        }
        if(!isset($validate['id']))
        {
            $user->active=true;
        }



        
        $user->save();
        return redirect('usuarios/edit/'.$user->id);
    }
    public function edit(User $user)
    {
        if(auth()->user()->role!='admin')
        {
            session()->flash('flash.banner', 'Sem Autorização');
            session()->flash('flash.bannerStyle', 'danger');
            return redirect('dashboard');
        }
        return view('users.edit',['usuario'=>$user]);

        // return view('users.edit',$user);
    }

    public function destroy(User $user)
    {
        //
        // dd(auth()->user()->role);
        if(auth()->user()->role!='admin')
        {
            session()->flash('flash.banner', 'Sem Autorização');
            session()->flash('flash.bannerStyle', 'danger');
            return redirect()->back();
        }
        $inspecoes = Inspecoes::where('user_id',$user->id)->count();
        if($inspecoes)
        {
            session()->flash('flash.banner', 'Exitem inspecoes vinculadas a este usuário desative o usuário no painel de edição');
            session()->flash('flash.bannerStyle', 'danger');
            return redirect()->back();
        }
        // dd($veiculos);
        session()->flash('flash.banner', 'Removido!');
        session()->flash('flash.bannerStyle', 'success');
        $user->delete();
        return redirect()->back();

    }

    
}

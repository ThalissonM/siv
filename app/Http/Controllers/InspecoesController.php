<?php

namespace App\Http\Controllers;

use App\Models\Inspecoes;
use App\Models\ModelosVeiculos;
use App\Models\Motoristas;
use App\Models\Perguntas;
use App\Models\Respostas;
use App\Models\Veiculos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class InspecoesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('inspecoes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        if($request->input('modelo'))
        {
            
            $modelo = ModelosVeiculos::find($request->input('modelo'));
            $motoristas = Motoristas::where('ativo',1)->get();
            $veiculos = Veiculos::where('modelo_veiculo_id',$request->input('modelo'))->get();
            $perguntas = Perguntas::where('modelo_veiculo_id',$request->input('modelo'))->get();
            return view('inspecoes.form',['motoristas'=>$motoristas,'veiculos'=>$veiculos,'modelo'=>$modelo,'perguntas'=>$perguntas]);
            // dd($modelo);
        }
        return view('inspecoes.new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $rules = [];
        $rules['id']='int';
        
        $rules['motorista_id']='required|int';
        // $rules['user_id']='required|int';
        $rules['veiculo_id']='required|int';
        $rules['modelo_veiculo_id']='required|int';
        $rules['motorista_id']='required|int';
        $rules['uvs']='string|max:255';
        $rules['horimetro']='string|max:255';
        $rules['km']='string|max:255';
        $rules['data']='date';
        $rules['horario']='date_format:H:i';
        $rules['turno']='string|max:255';
        $rules['observacao']='string|max:4000';
        $rules['image']='image';
    
        foreach ($request->input('pergunta') as $key => $value) {
            $rules["pergunta.{$key}.radio"] = 'required';  // Add your radio validation rules here
            $rules["pergunta.{$key}.justificativa"] = 'nullable|string|max:255';  // Add your text validation rules here
        }



        $validate=$request->validate($rules);

        
        // dd($validate);
        $inspecao = new Inspecoes;

        if(isset($validate['id']))
        {
            $inspecao=Inspecoes::find($validate['id']);
        }

        $veiculo = Veiculos::find($validate['veiculo_id']);

        if($veiculo->horas<$validate['horimetro'])
        {
            $veiculo->horas=$validate['horimetro'];
        }
        if($veiculo->km<$validate['km'])
        {
            $veiculo->km=$validate['km'];
        }
        $veiculo->save();

        

        // dd($validate);
        //opcionais
        if(isset($validate['uvs']))
        {
            $inspecao->uvs = $validate['uvs'];
        }
        if(isset($validate['horimetro']))
        {
            $inspecao->horimetro=$validate['horimetro'];
        }
        if(isset($validate['km']))
        {
            $inspecao->km=$validate['km'];
        }
        if(isset($validate['data']) and isset($validate['horario']))
        {
            $mysqlDatetime = Carbon::createFromFormat('Y-m-d H:i', $validate['data'] . ' ' . $validate['horario'])->toDateTimeString();
            $inspecao->data=$mysqlDatetime;
        }
        if(isset($validate['turno']))
        {
            $inspecao->turno= $validate['turno'];
        }
        if(isset($validate['observacao']))
        {
            $inspecao->observacao=$validate['observacao'];
        }

        //obrigatorios
        $inspecao->veiculo_id=$validate['veiculo_id'];
        $inspecao->motorista_id=$validate['motorista_id'];
        $inspecao->modelo_veiculo_id=$validate['modelo_veiculo_id'];
        $inspecao->user_id=auth()->user()->id;
        
        if(isset($validate['image']))//$request->has('image'))
        {
            // $filepath = $request->file('image')->store('modelos','public');
            // $validate['image']=$filepath;
            if($inspecao->image!=null)
            {
                $this->deleteImage($inspecao->image);
            }
            $inspecao->image=$validate['image'];
            $file = $request->file('image');

            // Generate a unique filename or use the original name
            $filename = uniqid() . '_' . $file->getClientOriginalName();


            
            $file->move(public_path('/inspec/'), $filename);
            

            $inspecao->image='/inspec/'.$filename;

        }


        
        $inspecao->save();

                //respostas
                foreach ($request->input('pergunta') as $key => $value) {
                    $resposta = new Respostas;
                    if(isset($validate['id']))
                    {
                        $resposta=Respostas::where('inspecao_id',$validate['id'])->where('pergunta_id',$key)->first();
                    }
                    // $respostabd = Respostas::where('inspecao_id',$validate['id'])->where('pergunta_id',$key)->first();
                    // if($respostabd!=null)
                    // {
                    //     $resposta=$respostabd;
                    // }
                    $resposta->inspecao_id=$inspecao->id;
                    $resposta->pergunta_id=$key;
                    $resposta->resposta=$value['radio'];
                    $resposta->justificativa=$value['justificativa'];
                    $resposta->save();
                }
                
                //fim respostas

        return redirect('inspecoes/view/'.$inspecao->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Inspecoes $inspecoes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inspecoes $inspecoes)
    {
        //
        if(auth()->user()->role!='admin')
        {
            session()->flash('flash.banner', 'Sem Autorização');
            session()->flash('flash.bannerStyle', 'danger');
            return redirect('dashboard');
        }
        $veiculos = Veiculos::where('modelo_veiculo_id',$inspecoes->modelo_veiculo_id)->get();
        $motoristas = Motoristas::all();
        $perguntas = Perguntas::where('modelo_veiculo_id',$inspecoes->modelo_veiculo_id)->get();
        foreach ($perguntas as $key => $pergunta) {
            $resposta = Respostas::where('inspecao_id',$inspecoes->id)->where('pergunta_id',$pergunta->id)->first();
            // dd($resposta,$inspecoes->id,$pergunta->id);
            if($resposta!=null)
            {
                $pergunta->resposta=$resposta->resposta;
                $pergunta->justificativa=$resposta->justificativa;
            }
        }
        $modelo=ModelosVeiculos::find($inspecoes->modelo_veiculo_id);
        // $respostas = Respostas::where('inspecao_id',$inspecoes->id)->get();
        return view('inspecoes.form',['inspecao'=>$inspecoes,'motoristas'=>$motoristas,'veiculos'=>$veiculos,'perguntas'=>$perguntas,'modelo'=>$modelo]);
    }

    public function view(Inspecoes $inspecoes)
    {
        //

        $veiculos = Veiculos::where('modelo_veiculo_id',$inspecoes->modelo_veiculo_id)->get();
        $motoristas = Motoristas::all();
        $perguntas = Perguntas::where('modelo_veiculo_id',$inspecoes->modelo_veiculo_id)->get();
        foreach ($perguntas as $key => $pergunta) {
            $resposta = Respostas::where('inspecao_id',$inspecoes->id)->where('pergunta_id',$pergunta->id)->first();
            // dd($resposta,$inspecoes->id,$pergunta->id);
            if($resposta!=null)
            {
                $pergunta->resposta=$resposta->resposta;
                $pergunta->justificativa=$resposta->justificativa;
            }
        }
        $modelo=ModelosVeiculos::find($inspecoes->modelo_veiculo_id);
        // $respostas = Respostas::where('inspecao_id',$inspecoes->id)->get();
        return view('inspecoes.view',['inspecao'=>$inspecoes,'motoristas'=>$motoristas,'veiculos'=>$veiculos,'perguntas'=>$perguntas,'modelo'=>$modelo]);
    }

    public function pdf(Inspecoes $inspecoes)
    {
        //

        $veiculos = Veiculos::where('modelo_veiculo_id',$inspecoes->modelo_veiculo_id)->get();
        $motoristas = Motoristas::all();
        $perguntas = Perguntas::where('modelo_veiculo_id',$inspecoes->modelo_veiculo_id)->get();
        foreach ($perguntas as $key => $pergunta) {
            $resposta = Respostas::where('inspecao_id',$inspecoes->id)->where('pergunta_id',$pergunta->id)->first();
            // dd($resposta,$inspecoes->id,$pergunta->id);
            if($resposta!=null)
            {
                $pergunta->resposta=$resposta->resposta;
                $pergunta->justificativa=$resposta->justificativa;
            }
        }
        $modelo=ModelosVeiculos::find($inspecoes->modelo_veiculo_id);
        // $respostas = Respostas::where('inspecao_id',$inspecoes->id)->get();
        return view('inspecoes.pdf',['inspecao'=>$inspecoes,'motoristas'=>$motoristas,'veiculos'=>$veiculos,'perguntas'=>$perguntas,'modelo'=>$modelo]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inspecoes $inspecoes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inspecoes $inspecoes)
    {
        //
        if(auth()->user()->role!='admin')
        {
            session()->flash('flash.banner', 'Sem Autorização');
            session()->flash('flash.bannerStyle', 'danger');
            return redirect()->back();
        }

        // dd($veiculos);
        session()->flash('flash.banner', 'Removido!');
        session()->flash('flash.bannerStyle', 'success');
        $inspecoes->delete();
        return redirect()->back();
    }

    public function downloadcsv(Request $request)
    {
        $inicio = Carbon::parse($request->input('inicio'))->format('Y-m-d H:i:s');
$fim = Carbon::parse($request->input('fim'))->format('Y-m-d H:i:s');
        // dd($inicio,$fim);
        $veiculo = $request->input('veiculo');
        $inspecoes = Inspecoes::where('veiculo_id',$veiculo)->get();
        $veiculo = Veiculos::find($veiculo);
        $modelo_veiculo = ModelosVeiculos::find($veiculo->modelo_veiculo_id);
        $motoristas = Motoristas::all();
        $filename = "inspecoes".date('dmY_Hi').".csv";

        $perguntas = Perguntas::where('modelo_veiculo_id',$modelo_veiculo->id)->get();
        foreach ($inspecoes as $inspecao) {
            $inspecao->perguntas=$perguntas;
            $inspecao->modelo_veiculo = $modelo_veiculo->nome;
            $inspecao->placa_veiculo = $veiculo->placa;
            $inspecao->prefixo_veiculo = $veiculo->prefixo;
            foreach ($inspecao->perguntas as $key => $pergunta) {
                $resposta = Respostas::where('inspecao_id',$inspecao->id)->where('pergunta_id',$pergunta->id)->first();
                // dd($resposta,$inspecoes->id,$pergunta->id);
                if($resposta!=null)
                {
                    $inspecao->perguntas[$key]->resposta=$resposta->resposta;
                    $inspecao->perguntas[$key]->justificativa=$resposta->justificativa;
                }
            }
            foreach ($motoristas as $key => $motorista) {
                if($motorista->id==$inspecao->motorista_id)
                {
                    $inspecao->motorista=$motorista->nome.' '.$motorista->documento;
                    break;
                }
            }
            
        }

        

        //remover o aninhamento de perguntas da inspecao
        $inspecoes = $inspecoes->toArray();
        foreach ($inspecoes as $key => $inspecao) {
            foreach ($inspecao['perguntas'] as $key2 => $pergunta) {
                $inspecoes[$key]['pergunta_'.$pergunta['pergunta'].'_resposta']=$pergunta->resposta;
                $inspecoes[$key]['pergunta_'.$pergunta['pergunta'].'_justificativa']=$pergunta->justificativa;
            }
            unset($inspecoes[$key]['perguntas']);
        }

        dd($inspecoes); 

        $handle = fopen($filename, 'w+');
        $arraycampos = [];
        foreach ($inspecoes as $key => $value) {
            $arraycampos[]=$key;
        }
        fputcsv($handle, $arraycampos);
        foreach($inspecoes as $row) {
            fputcsv($handle, $row);
        }
        fclose($handle);
        $headers = array(
            'Content-Type' => 'text/csv',
        );
        return response()->download($filename, 'inspecoes.csv', $headers);
    }

    public function downloadcsvinspecao(Inspecoes $inspecoes)
    {
        // dd($inspecoes);
        $veiculo = Veiculos::find($inspecoes->veiculo_id);
        $motorista = Motoristas::find($inspecoes->motorista_id);
        $perguntas = Perguntas::where('modelo_veiculo_id',$inspecoes->modelo_veiculo_id)->get();
        foreach ($perguntas as $key => $pergunta) {
            $resposta = Respostas::where('inspecao_id',$inspecoes->id)->where('pergunta_id',$pergunta->id)->first();
            // dd($resposta,$inspecoes->id,$pergunta->id);
            if($resposta!=null)
            {
                $pergunta->resposta=$resposta->resposta;
                $pergunta->justificativa=$resposta->justificativa;
            }
        }
        $modelo=ModelosVeiculos::find($inspecoes->modelo_veiculo_id);

        // $inspecoes->perguntas=$perguntas;
        $inspecoes->modelo_veiculo = $modelo->modelo;
        // dd($veiculo);
        $inspecoes->placa_veiculo = $veiculo->placa;
        $inspecoes->prefixo_veiculo = $veiculo->prefixo;
        $inspecoes->motorista = $motorista->nome.' '.$motorista->documento;



        $inspecoes = $inspecoes->toArray();
        //adicionar perguntas a inspecao
        foreach ($perguntas as $key => $pergunta) {
            $inspecoes['pergunta_'.$pergunta->pergunta.'resposta']=$pergunta->resposta;
            $inspecoes['pergunta_'.$pergunta->pergunta.'justificativa']=$pergunta->justificativa;
        }

        
        $arraycampos = [];
        foreach ($inspecoes as $key => $value) {
            $arraycampos[]=$key;
        }

        $filename = "inspecao".date('dmY_Hi').".csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, $arraycampos);
        fputcsv($handle, $inspecoes);
        
        fclose($handle);
        $headers = array(
            'Content-Type' => 'text/csv',
        );
        return response()->download($filename, $filename, $headers);

        

    }

    public function downloadxlsinspecao(Inspecoes $inspecoes)
    {

        $veiculo = Veiculos::find($inspecoes->veiculo_id);
        $motorista = Motoristas::find($inspecoes->motorista_id);
        $perguntas = Perguntas::where('modelo_veiculo_id',$inspecoes->modelo_veiculo_id)->get();
        foreach ($perguntas as $key => $pergunta) {
            $resposta = Respostas::where('inspecao_id',$inspecoes->id)->where('pergunta_id',$pergunta->id)->first();
            // dd($resposta,$inspecoes->id,$pergunta->id);
            if($resposta!=null)
            {
                $pergunta->resposta=$resposta->resposta;
                $pergunta->justificativa=$resposta->justificativa;
            }
        }
        $modelo=ModelosVeiculos::find($inspecoes->modelo_veiculo_id);

        // $inspecoes->perguntas=$perguntas;
        $inspecoes->modelo_veiculo = $modelo->modelo;
        // dd($veiculo);
        $inspecoes->placa_veiculo = $veiculo->placa;
        $inspecoes->prefixo_veiculo = $veiculo->prefixo;
        $inspecoes->motorista = $motorista->nome.' '.$motorista->documento;



        $inspecoes = $inspecoes->toArray();

        $inspecoes['criado_em']=Carbon::parse($inspecoes['created_at'])->format('d/m/Y H:i');
        unset($inspecoes['created_at']);
        unset($inspecoes['updated_at']);
        unset($inspecoes['user_id']);
        unset($inspecoes['veiculo_id']);
        unset($inspecoes['modelo_veiculo_id']);
        unset($inspecoes['motorista_id']);
        $inspecoes['data']=Carbon::parse($inspecoes['data'])->format('d/m/Y H:i');

        //adicionar perguntas a inspecao
        foreach ($perguntas as $key => $pergunta) {
            $inspecoes[$pergunta->id.'_resposta'.$pergunta->pergunta]=$pergunta->resposta;
            $inspecoes[$pergunta->id.'_justificativa'.$pergunta->pergunta]=$pergunta->justificativa;
        }



        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        //passar para um arquivo xls

        $rowIndex=1;
        foreach ($inspecoes as $key=>$value) {
            $sheet->setCellValue('B'.$rowIndex, $key);
            $sheet->setCellValue('C'.$rowIndex, $value);
            $rowIndex++;
        }
        
        $filename = "inspecao".date('dmY_Hi').".xlsx";
        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);
        
        $headers = array(
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        );
        return response()->download($filename, $filename, $headers);
        
    }

}

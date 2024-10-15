<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\CommonMark\Normalizer\SlugNormalizer;
use App\Models\ModelosVeiculos;
use App\Models\Veiculos;
use App\Models\Motoristas;

class Relatorios extends Controller
{
    //
    public function index()
    {
        
        $modelos = $modelo = ModelosVeiculos::all();
        $veiculos = Veiculos::all();
        $motoristas = Motoristas::all();
        return view('relatorios.index', ['modelos' => $modelos, 'veiculos' => $veiculos, 'motoristas' => $motoristas]);
    }

    public function relatorio_veiculo(Request $request)
    {
        // buscar parametros no get laravel
        $id_veiculo = $request->input('id_veiculo');
        $data_inicial = $request->input('data_inicial'); 
        $data_final = $request->input('data_final');

        $inspecoesModel = new \App\Models\Inspecoes();
        $inspecoes = $inspecoesModel->where('veiculo_id', $id_veiculo)->where('created_at', '>=', $data_inicial)->where('created_at', '<=', $data_final)->get();

        $motoristasModel = new \App\Models\Motoristas();
        $veiculosModel = new \App\Models\Veiculos();
        $veiculo = $veiculosModel->find($id_veiculo);
        $modelosVeiculosModel = new \App\Models\ModelosVeiculos();
        $modelo = $modelosVeiculosModel->find($veiculo->modelo_veiculo_id);
        $perguntasModel = new \App\Models\Perguntas();
        $perguntas = $perguntasModel->where('modelo_veiculo_id', $veiculo->modelo_veiculo_id)->get();
        $respostasModel = new \App\Models\Respostas();
        $slugnormaliser = new SlugNormalizer();
        // dd($inspecoes);

        $csvbase = [
            "id" => 5,
            "veiculo" => "4545654-ABC1234",
            "motorista" => "João da Silva",
            "doc_motorista" => "123456789",
            "modelo_veiculo" => "Modelo do veiculo",
            "uvs" => "Viasolo Montes Claros",
            "horimetro" => 5863,
            "km" => 0,
            "data" => "14/02/2024",
            "turno" => "Escolha um dos turnos",
            "observacao" => null,
            "criado em" => "14/02/2024",

        ];
        $csvData = [];
        foreach ($inspecoes as $inspecao) {
            $motorista = $motoristasModel->find($inspecao->motorista_id);
            $csvbuf = [
                "id" => $inspecao->id,
                "veiculo" => $veiculo->prefixo . '-' . $veiculo->placa,
                "motorista" => $motorista->nome,
                "doc_motorista" => $motorista->documento,
                "modelo_veiculo" => $modelo->modelo,
                "uvs" => $inspecao->uvs,
                "horimetro" => $inspecao->horimetro,
                "km" => $inspecao->km,
                "data" => date_format(date_create($inspecao->data), 'd/m/Y H:i'),
                "turno" => $inspecao->turno,
                "observacao" => $inspecao->observacao,
                "criado em" => date_format(date_create($inspecao->created_at), 'd/m/Y H:i'),

            ];

            $respostas = $respostasModel->where('inspecao_id', $inspecao->id)->get();
            foreach ($perguntas as $pergunta) {
                foreach ($respostas as $resposta) {
                    if ($pergunta->id == $resposta->pergunta_id) {
                        $pertext = $pergunta->pergunta;
                        $csvbuf[$pertext] = $resposta->resposta;

                        $perobservacao = $pergunta->pergunta . '-observacao';
                        $csvbuf[$perobservacao] = $resposta->observacao;
                    }
                }
            }
            $csvData[] = $csvbuf;

        }
        // enviar para download
        $filename = 'inspecoes_veiculo_' . $veiculo->prefixo . '-' . $veiculo->placa . '_' . date('d-m-Y') . '.csv';
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        );
        $callback = function () use ($csvData) {
            $file = fopen('php://output', 'w');
            fputcsv($file, array_keys($csvData[0]),';');
            foreach ($csvData as $row) {
                fputcsv($file, $row,';');
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function relatorio_modelo_veiculo(Request $request)
    {
        $id_modelo_veiculo = $request->input('id_modelo_veiculo');
        $data_inicial = $request->input('data_inicial');
        $data_final = $request->input('data_final');
        $inspecoesModel = new \App\Models\Inspecoes();
        $inspecoes = $inspecoesModel->where('modelo_veiculo_id', $id_modelo_veiculo)->where('created_at', '>=', $data_inicial)->where('created_at', '<=', $data_final)->get();

        $motoristasModel = new \App\Models\Motoristas();
        $veiculosModel = new \App\Models\Veiculos();
        $modelosVeiculosModel = new \App\Models\ModelosVeiculos();
        $modelo = $modelosVeiculosModel->find($id_modelo_veiculo);
        $perguntasModel = new \App\Models\Perguntas();
        $perguntas = $perguntasModel->where('modelo_veiculo_id', $id_modelo_veiculo)->get();
        $respostasModel = new \App\Models\Respostas();
        $slugnormaliser = new SlugNormalizer();
        // dd($inspecoes);

        $csvbase = [
            "id" => 5,
            "veiculo" => "4545654-ABC1234",
            "motorista" => "João da Silva",
            "doc_motorista" => "123456789",
            "modelo_veiculo" => "Modelo do veiculo",
            "uvs" => "Viasolo Montes Claros",
            "horimetro" => 5863,
            "km" => 0,
            "data" => "14/02/2024",
            "turno" => "Escolha um dos turnos",
            "observacao" => null,
            "criado em" => "14/02/2024",

        ];
        $csvData = [];
        foreach ($inspecoes as $inspecao) {
            $motorista = $motoristasModel->find($inspecao->motorista_id);
            $veiculo = $veiculosModel->find($inspecao->veiculo_id);
            $csvbuf = [
                "id" => $inspecao->id,
                "veiculo" => $veiculo->prefixo . '-' . $veiculo->placa,
                "motorista" => $motorista->nome,
                "doc_motorista" => $motorista->documento,
                "modelo_veiculo" => $modelo->modelo,
                "uvs" => $inspecao->uvs,
                "horimetro" => $inspecao->horimetro,
                "km" => $inspecao->km,
                "data" => date_format(date_create($inspecao->data), 'd/m/Y H:i'),
                "turno" => $inspecao->turno,
                "observacao" => $inspecao->observacao,
                "criado em" => date_format(date_create($inspecao->created_at), 'd/m/Y H:i'),

            ];

            $respostas = $respostasModel->where('inspecao_id', $inspecao->id)->get();
            foreach ($perguntas as $pergunta) {
                foreach ($respostas as $resposta) {
                    if ($pergunta->id == $resposta->pergunta_id) {
                        $pertext = $pergunta->pergunta;
                        $csvbuf[$pertext] = $resposta->resposta;

                        $perobservacao = $pergunta->pergunta . '-observacao';
                        $csvbuf[$perobservacao] = $resposta->observacao;
                    }
                }
            }
            $csvData[] = $csvbuf;

        }
        // enviar para download
        $filename = 'inspecoes_veiculo_' . $modelo->modelo . '_' . date('d-m-Y') . '.csv';
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        );
        $callback = function () use ($csvData) {
            $file = fopen('php://output', 'w');
            fputcsv($file, array_keys($csvData[0]),';');
            foreach ($csvData as $row) {
                fputcsv($file, $row,';');
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function relatorio_veiculo_motorista(Request $request)
    {
        $id_veiculo = $request->input('id_veiculo');
        $id_motorista = $request->input('id_motorista');
        $data_inicial = $request->input('data_inicial');
        $data_final = $request->input('data_final');
        
        $inspecoesModel = new \App\Models\Inspecoes();
        $inspecoes = $inspecoesModel->where('veiculo_id', $id_veiculo)->where('motorista_id',$id_motorista)->where('created_at', '>=', $data_inicial)->where('created_at', '<=', $data_final)->get();
        $motoristasModel = new \App\Models\Motoristas();
        $motorista = $motoristasModel->find($id_motorista);
        $veiculosModel = new \App\Models\Veiculos();
        $veiculo = $veiculosModel->find($id_veiculo);
        $modelosVeiculosModel = new \App\Models\ModelosVeiculos();
        $modelo = $modelosVeiculosModel->find($veiculo->modelo_veiculo_id);
        $perguntasModel = new \App\Models\Perguntas();
        $perguntas = $perguntasModel->where('modelo_veiculo_id', $veiculo->modelo_veiculo_id)->get();
        $respostasModel = new \App\Models\Respostas();
        $slugnormaliser = new SlugNormalizer();
        // dd($inspecoes);

        $csvData = [];
        foreach ($inspecoes as $inspecao) {
            
            $csvbuf = [
                "id" => $inspecao->id,
                "veiculo" => $veiculo->prefixo . '-' . $veiculo->placa,
                "motorista" => $motorista->nome,
                "doc_motorista" => $motorista->documento,
                "modelo_veiculo" => $modelo->modelo,
                "uvs" => $inspecao->uvs,
                "horimetro" => $inspecao->horimetro,
                "km" => $inspecao->km,
                "data" => date_format(date_create($inspecao->data), 'd/m/Y H:i'),
                "turno" => $inspecao->turno,
                "observacao" => $inspecao->observacao,
                "criado em" => date_format(date_create($inspecao->created_at), 'd/m/Y H:i'),

            ];

            $respostas = $respostasModel->where('inspecao_id', $inspecao->id)->get();
            foreach ($perguntas as $pergunta) {
                foreach ($respostas as $resposta) {
                    if ($pergunta->id == $resposta->pergunta_id) {
                        $pertext = $pergunta->pergunta;
                        $csvbuf[$pertext] = $resposta->resposta;

                        $perobservacao = $pergunta->pergunta . '-observacao';
                        $csvbuf[$perobservacao] = $resposta->observacao;
                    }
                }
            }
            $csvData[] = $csvbuf;

        }
        // enviar para download
        $filename = 'inspecoes_veiculo_' . $veiculo->prefixo . '-' . $veiculo->placa . '_motorista_'.$motorista->documento . date('d-m-Y') . '.csv';
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        );
        $callback = function () use ($csvData) {
            $file = fopen('php://output', 'w');
            fputcsv($file, array_keys($csvData[0]),';');
            foreach ($csvData as $row) {
                fputcsv($file, $row,';');
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }


}

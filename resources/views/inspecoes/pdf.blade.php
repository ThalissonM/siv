<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inspeção do {{$modelo->modelo}}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 210mm;
            height: 297mm;
            padding: 20mm;
            box-sizing: border-box;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .content {
            width: 100%;
        }
        .alert {
            color: red;
        }
        .grid {
            display: grid;
            gap: 1rem;
        }
        .figure {
            text-align: center;
        }
        .figure img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Inspeção do {{$modelo->modelo}}
            </h2>
        </div>

        <div class="content">
            {{-- adicionar aqui a foto do modelo do veículo --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('inspecoes/store') }}" enctype="multipart/form-data" method="POST" class="form">
                <div class="grid">
                    @if(isset($inspecao->id))
                        <input disabled type="hidden" value="{{$inspecao->id}}" id="id" name="id">
                    @endif
                    <input disabled type="hidden" value="{{$modelo->id}}" id="modelo_veiculo_id" name="modelo_veiculo_id">

                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <th style="border: 1px solid #000; padding: 8px;">Veículo ou Maquinário</th>
                            <td style="border: 1px solid #000; padding: 8px;">
                                @if(!isset($veiculos))
                                    Escolha um dos veículos
                                @else
                                    @foreach ($veiculos as $key => $veiculo)
                                        @if($key == 0 || (isset($inspecao) && $inspecao->veiculo_id == $veiculo->id))
                                            {{ $veiculo->placa }} {{ $veiculo->prefixo }}
                                        @endif
                                    @endforeach
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid #000; padding: 8px;">Motorista</th>
                            <td style="border: 1px solid #000; padding: 8px;">
                                @if(!isset($motoristas))
                                    selecione um motorista
                                @else
                                    @foreach ($motoristas as $motorista)
                                        @if(isset($inspecao) && $inspecao->motorista_id == $motorista->id)
                                            {{ $motorista->nome }} {{ $motorista->documento }}
                                        @endif
                                    @endforeach
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid #000; padding: 8px;">UVS</th>
                            <td style="border: 1px solid #000; padding: 8px;">
                                {{ isset($inspecao) ? $inspecao->uvs : 'Viasolo Montes Claros' }}
                            </td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid #000; padding: 8px;">Horimetro</th>
                            <td style="border: 1px solid #000; padding: 8px;">
                                {{ isset($inspecao) ? $inspecao->horimetro : '' }}
                            </td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid #000; padding: 8px;">Quilometragem</th>
                            <td style="border: 1px solid #000; padding: 8px;">
                                {{ isset($inspecao) ? $inspecao->km : '' }}
                            </td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid #000; padding: 8px;">Data</th>
                            <td style="border: 1px solid #000; padding: 8px;">
                                {{ isset($inspecao) ? \Carbon\Carbon::parse($inspecao->data)->format('d/m/Y') : date('d/m/Y') }}
                            </td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid #000; padding: 8px;">Hora</th>
                            <td style="border: 1px solid #000; padding: 8px;">
                                {{ isset($inspecao) ? \Carbon\Carbon::parse($inspecao->data)->format('H:i') : date('H:i') }}
                            </td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid #000; padding: 8px;">Turno</th>
                            <td style="border: 1px solid #000; padding: 8px;">
                                @if(isset($inspecao))
                                    @if($inspecao->turno == 'manha')
                                        Manhã
                                    @elseif($inspecao->turno == 'tarde')
                                        Tarde
                                    @elseif($inspecao->turno == 'noite')
                                        Noite
                                    @else
                                        Escolha um dos turnos
                                    @endif
                                @else
                                    Escolha um dos turnos
                                @endif
                            </td>
                        </tr>
                    </table>

                    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                        @foreach ($perguntas as $key => $pergunta)
                            <tr>
                                <th style="border: 1px solid #000; padding: 8px; width: 30%;">{{ $pergunta->pergunta }}</th>
                                <td style="border: 1px solid #000; padding: 8px; width: 70%;">
                                    @if(isset($pergunta->resposta))
                                        @if($pergunta->resposta == 'sim')
                                            OK
                                        @elseif($pergunta->resposta == 'nao')
                                            Não OK
                                        @elseif($pergunta->resposta == 'na')
                                            N.A.
                                        @endif
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th style="border: 1px solid #000; padding: 8px; width: 30%;">Justificativa</th>
                                <td style="border: 1px solid #000; padding: 8px; width: 70%; word-wrap: break-word;">
                                    {{ isset($pergunta->justificativa) ? $pergunta->justificativa : '' }}
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                        <tr>
                            <th style="border: 1px solid #000; padding: 8px;">Observação</th>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000; padding: 8px;">
                                {{ isset($inspecao) ? $inspecao->km : '' }}
                            </td>
                        </tr>
                    </table>

                    @if(isset($inspecao->image))
                        <figure class="figure">
                            <img src="{{asset($inspecao->image)}}" alt="Imagem">
                            <figcaption>Veículo</figcaption>
                        </figure>
                    @endif
                </div>
            </form>
        </div>
    </div>
</body>
<script>
    window.onload = function() {
        window.print();
    };
</script>
</html>
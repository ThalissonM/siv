<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Inspeção do {{$modelo->modelo}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" bg-white overflow-hidden shadow-xl sm:rounded-lg">

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
            


            <div class="grid gap-1 mb-1 md:grid-cols-1 w-full">
                <figure class="max-w-lg mx-auto text-center"> <!-- Added mx-auto and text-center classes -->
                    <img class="h-auto max-w-full rounded-lg" src="{{ url($modelo->image) }}" alt="Imagem">
                    <figcaption class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">{{$modelo->modelo}}</figcaption>
                </figure>
            </div>

            
                <form action="{{ url('inspecoes/store') }}" enctype="multipart/form-data" method="POST" class="bg-white rounded px-8 pt-6 pb-8 mb-4 flex items-center" style="padding:10px;">
                    <div class="grid gap-6 mb-6 md:grid-cols-1 w-full">

                        @if(isset($inspecao->id))
                        <input disabled type="hidden" value="{{$inspecao->id}}" id="id" name="id">
                        @endif
                        <input disabled type="hidden" value="{{$modelo->id}}" id="modelo_veiculo_id" name="modelo_veiculo_id">



                        
                        <label for="veiculo_id" class="block mb-2 text-sm font-medium text-gray-900">Veículo ou Maquinário</label>
                        <select disabled id="veiculo_id" name="veiculo_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            @if(!isset($veiculos))
                            <option selected>Escolha um dos veículos</option>
                            @endif
                            
                            @foreach ($veiculos as $key => $veiculo)
                                <option value="{{ $veiculo->id }}" {{ ($key == 0 || (isset($inspecao) && $inspecao->veiculo_id == $veiculo->id)) ? 'selected' : '' }}>{{ $veiculo->placa }} {{ $veiculo->prefixo }}</option>
                            @endforeach
                        </select>






                        <label for="motorista" class="block mb-2 text-sm font-medium text-gray-900 ">Motorista</label>
                            <select disabled id="motorista_id" name="motorista_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option selected>selecione um motorista</option>
                            @foreach ($motoristas as $motorista)
                                <option value="{{ $motorista->id }}" {{ isset($inspecao) && $inspecao->motorista_id == $motorista->id ? 'selected' : '' }}>{{ $motorista->nome }} {{ $motorista->documento }}</option>
                            @endforeach

                        </select>
                        <div class="grid gap-6 mb-6 md:grid-cols-3">
                        
                        <div>
                            <label for="uvs" class="block mb-2 text-sm font-medium text-gray-900 ">UVS</label>
                            <input disabled type="text" id="uvs" name="uvs" value="{{ isset($inspecao) ? $inspecao->uvs : 'Viasolo Montes Claros' }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="uvs" required>
                        </div>
                        <div>
                            <label for="horimetro" class="block mb-2 text-sm font-medium text-gray-900 ">Horimetro</label>
                            <input disabled type="number" value="{{ isset($inspecao) ? $inspecao->horimetro : '' }}" id="horimetro" name="horimetro" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="10" required>
                        </div>
                        <div>
                            <label for="km" class="block mb-2 text-sm font-medium text-gray-900">Quilometragem</label>
                            <input disabled type="number" value="{{ isset($inspecao) ? $inspecao->km : '' }}" id="km" name="km" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="50" required>
                        </div>
                        <div>
                            <label for="data" class="block mb-2 text-sm font-medium text-gray-900 ">Data</label>
                            <input disabled type="date" id="data" name="data" value="{{ isset($inspecao) ? \Carbon\Carbon::parse($inspecao->data)->format('Y-m-d') : date('Y-m-d') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " required>
                        </div>
                        <div>
                            <label for="horario" class="block mb-2 text-sm font-medium text-gray-900 ">Hora</label>
                            <input disabled type="time" id="horario" name="horario" value="{{ isset($inspecao) ? \Carbon\Carbon::parse($inspecao->data)->format('H:i') : date('H:i') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " required>
                        </div>
                        <div>
                            <label for="turno" class="block mb-2 text-sm font-medium text-gray-900">Turno</label>
                            <select disabled id="turno" name="turno" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option selected>Escolha um dos turnos</option>
                            
                                <option value="manha" {{ isset($inspecao) && $inspecao->turno == 'manha' ? 'selected' : '' }}>Manhã</option>
                                <option value="tarde" {{ isset($inspecao) && $inspecao->turno == 'tarde' ? 'selected' : '' }}>Tarde</option>
                                <option value="noite" {{ isset($inspecao) && $inspecao->turno == 'noite' ? 'selected' : '' }}>Noite</option>
                        </select>
                        </div>
                        </div>

                        <div class="grid gap-6 mb-6 md:grid-cols-1">
                        
                            @foreach ($perguntas as $key => $pergunta)
                                <h3 class="mb-4 font-semibold text-gray-900">{{ $pergunta->pergunta }}</h3>
                                <ul class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex">
                                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r">
                                        <div class="flex items-center ps-3">
                                            <input disabled id="pergunta-{{ $pergunta->id }}-sim" type="radio" value="sim" name="pergunta[{{ $pergunta->id }}][radio]" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500"  {{ isset($pergunta->resposta) && $pergunta->resposta == 'sim' ? 'checked' : '' }}>
                                            <label for="pergunta-{{ $pergunta->id }}-sim" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">OK</label>
                                        </div>
                                    </li>
                                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r">
                                        <div class="flex items-center ps-3">
                                            <input disabled id="pergunta-{{ $pergunta->id }}-nao" type="radio" value="nao" name="pergunta[{{ $pergunta->id }}][radio]" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500" {{ isset($pergunta->resposta) && $pergunta->resposta == 'nao' ? 'checked' : '' }}>
                                            <label for="pergunta-{{ $pergunta->id }}-nao" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">Não OK</label>
                                        </div>
                                    </li>
                                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r">
                                        <div class="flex items-center ps-3">
                                            <input disabled id="pergunta-{{ $pergunta->id }}-na" type="radio" value="na" name="pergunta[{{ $pergunta->id }}][radio]" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500" {{ isset($pergunta->resposta) && $pergunta->resposta == 'na' ? 'checked' : '' }}>
                                            <label for="pergunta-{{ $pergunta->id }}-na" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">N.A.</label>
                                        </div>
                                    </li>
                                </ul>

                                <div>
                                    <label for="justificativa-{{ $pergunta->id }}" class="block mb-2 text-sm font-medium text-gray-900">Justificativa</label>
                                    <input disabled type="text" id="justificativa-{{ $pergunta->id }}" name="pergunta[{{ $pergunta->id }}][justificativa]" value="{{ isset($pergunta->justificativa) ? $pergunta->justificativa : '' }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="especificar caso não ok">
                                </div>
                            @endforeach
                            
                            


                        
                        </div>

                        <div class="grid gap-6 mb-6 md:grid-cols-1">

                        <div>
                                <label for="observacao" class="block mb-2 text-sm font-medium text-gray-900 ">Observação</label>
                                <textarea id="observacao" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 " placeholder="Detalhe aqui observações sobre a vistoria">{{ isset($inspecao) ? $inspecao->km : '' }}</textarea>
                        </div>

                        @if(isset($inspecao->image))
                        <figure class="max-w-lg mx-auto text-center"> <!-- Added mx-auto and text-center classes -->
                            <img class="h-auto max-w-full rounded-lg" src="{{asset($inspecao->image)}}" alt="Imagem">
                            <figcaption class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">Veículo</figcaption>
                        </figure>
                        @endif


                        </div>
                    </div>
                    
                        

                    
                </form>
            
            </div>
        </div>
    </div>
</x-app-layout>

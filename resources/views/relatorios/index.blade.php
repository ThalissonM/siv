<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Relatórios
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" bg-white overflow-hidden shadow-xl sm:rounded-lg">
            {{-- adicionar aqui a foto do modelo do veículo --}}
            
                <form action="{{ url('relatorios/relatorio_veiculo') }}" method="GET" class="bg-white rounded px-8 pt-6 pb-8 mb-4 flex items-center" style="padding:10px;">
                    <div class="grid gap-6 mb-6 md:grid-cols-1 w-full">
                    @csrf
                        <div>
                            <label for="id_veiculo" class="block mb-2 text-sm font-medium text-gray-900">Veículo ou Maquinário</label>
                            <select id="id_veiculo" name="id_veiculo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                @if(!isset($veiculos))
                                <option selected>Escolha um dos veículos</option>
                                @endif
                                
                                @foreach ($veiculos as $key => $veiculo)
                                    <option value="{{ $veiculo->id }}">{{ $veiculo->placa }} {{ $veiculo->prefixo }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="data_inicial" class="block mb-2 text-sm font-medium text-gray-900">Data Inicial</label>
                            <input type="date" id="data_inicial" name="data_inicial" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        </div>
                        <div>
                            <label for="data_final" class="block mb-2 text-sm font-medium text-gray-900">Data Final</label>
                            <input type="date" id="data_final" name="data_final" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        </div>

                        <div>
                            <button type="submit" class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Buscar</button>
                        </div>
                    </div>
                    
                        
                    
                </form>
            
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" bg-white overflow-hidden shadow-xl sm:rounded-lg">
            {{-- adicionar aqui a foto do modelo do veículo --}}
            
                <form action="{{ url('relatorios/relatorio_modelo_veiculo') }}" method="GET" class="bg-white rounded px-8 pt-6 pb-8 mb-4 flex items-center" style="padding:10px;">
                    <div class="grid gap-6 mb-6 md:grid-cols-1 w-full">
                    @csrf
                        <div>
                            <label for="id_modelo_veiculo" class="block mb-2 text-sm font-medium text-gray-900">Modelo de Veículo ou Maquinário</label>
                            <select id="id_modelo_veiculo" name="id_modelo_veiculo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                @if(!isset($modelos))
                                <option selected>Escolha um dos Modelos de Veículo/Maquinário</option>
                                @endif
                                
                                @foreach ($modelos as $key => $modelo)
                                    <option value="{{ $modelo->id }}">{{ $modelo->modelo }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="data_inicial" class="block mb-2 text-sm font-medium text-gray-900">Data Inicial</label>
                            <input type="date" id="data_inicial" name="data_inicial" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        </div>
                        <div>
                            <label for="data_final" class="block mb-2 text-sm font-medium text-gray-900">Data Final</label>
                            <input type="date" id="data_final" name="data_final" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        </div>

                        <div>
                            <button type="submit" class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Buscar</button>
                        </div>
                    </div>
                    
                        
                    
                </form>
            
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" bg-white overflow-hidden shadow-xl sm:rounded-lg">
            {{-- adicionar aqui a foto do modelo do veículo --}}
            
                <form action="{{ url('relatorios/relatorio_veiculo_motorista') }}" method="GET" class="bg-white rounded px-8 pt-6 pb-8 mb-4 flex items-center" style="padding:10px;">
                    <div class="grid gap-6 mb-6 md:grid-cols-1 w-full">
                    @csrf
                        <div>
                            <label for="id_veiculo" class="block mb-2 text-sm font-medium text-gray-900">Veículo ou Maquinário</label>
                            <select id="id_veiculo" name="id_veiculo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                @if(!isset($veiculos))
                                <option selected>Escolha um dos veículos</option>
                                @endif
                                
                                @foreach ($veiculos as $key => $veiculo)
                                    <option value="{{ $veiculo->id }}">{{ $veiculo->placa }} {{ $veiculo->prefixo }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="id_motorista" class="block mb-2 text-sm font-medium text-gray-900">Motorista</label>
                            <select id="id_motorista" name="id_motorista" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                @if(!isset($motoristas))
                                <option selected>Escolha um dos Motoristass</option>
                                @endif
                                
                                @foreach ($motoristas as $key => $motorista)
                                    <option value="{{ $motorista->id }}">{{ $motorista->nome }} {{ $motorista->documento }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="data_inicial" class="block mb-2 text-sm font-medium text-gray-900">Data Inicial</label>
                            <input type="date" id="data_inicial" name="data_inicial" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        </div>
                        <div>
                            <label for="data_final" class="block mb-2 text-sm font-medium text-gray-900">Data Final</label>
                            <input type="date" id="data_final" name="data_final" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        </div>

                        <div>
                            <button type="submit" class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Buscar</button>
                        </div>
                    </div>
                    
                        
                    
                </form>
            
            </div>
        </div>
    </div>


</x-app-layout>

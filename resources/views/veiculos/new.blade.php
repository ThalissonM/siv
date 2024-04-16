<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Adicionar veículo
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" bg-white overflow-hidden shadow-xl sm:rounded-lg">
            {{-- adicionar aqui a foto do modelo do veículo --}}
            
                <form action="{{ url('veiculos/store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded px-8 pt-6 pb-8 mb-4 flex items-center" style="padding:10px;">
                    <div class="grid gap-6 mb-6 md:grid-cols-1 w-full">
                    @csrf
                        <div>
                            <label for="modelo_veiculo_id" class="block mb-2 text-sm font-medium text-gray-900">Selecione um Modelo:</label>
                            <select id="modelo_veiculo_id" name="modelo_veiculo_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 form-select">
                                <option value="">selecionar...</option>
                                @foreach ($modelos as $modelo)
                                    <option value="{{ $modelo->id }}">{{ $modelo->modelo }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="placa" class="block mb-2 text-sm font-medium text-gray-900 ">Placa</label>
                            <input type="text" id="placa" name="placa" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="gbx-8698" required>
                        </div>
                        <div>
                            <label for="prefixo" class="block mb-2 text-sm font-medium text-gray-900 ">Prefixo</label>
                            <input type="text" id="prefixo" name="prefixo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="gbx-8698" required>
                        </div>

                        <div>
                            <label for="condicao" class="block mb-2 text-sm font-medium text-gray-900 ">Condição</label>
                            <input type="text" id="condicao" name="condicao" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="novo" required>
                        </div>
                        <div>
                            <label for="km" class="block mb-2 text-sm font-medium text-gray-900 ">Quilometragem</label>
                            <input type="number" id="km" name="km" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="72000" required>
                        </div>
                        <div>
                            <label for="horas" class="block mb-2 text-sm font-medium text-gray-900 ">Horimetro</label>
                            <input type="number" id="horas" name="horas" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="223" required>
                        </div>
                        
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 " for="file_input">Enviar arquivo</label>
                            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" aria-describedby="file_input_help" id="image" name="image" type="file">
                            <p class="mt-1 text-sm text-gray-500" id="file_input_help">Envie aqui uma imagem que auxilie na vistoria do veículo.</p>
                        </div>
                        <div>
                            <button type="submit" class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Salvar</button>
                        </div>
                    </div>
                    
                        
                    
                </form>
            
            </div>
        </div>
    </div>
</x-app-layout>

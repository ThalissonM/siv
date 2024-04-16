<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Adicionar modelo de veículo
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" bg-white overflow-hidden shadow-xl sm:rounded-lg">
            {{-- adicionar aqui a foto do modelo do veículo --}}
            
                <form action="{{ url('modelos_veiculos/store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded px-8 pt-6 pb-8 mb-4 flex items-center" style="padding:10px;">
                    <div class="grid gap-6 mb-6 md:grid-cols-1 w-full">
                    @csrf
                        <div>
                            <label for="modelo" class="block mb-2 text-sm font-medium text-gray-900 ">Modelo</label>
                            <input type="text" id="modelo" name="modelo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="uvs" required>
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

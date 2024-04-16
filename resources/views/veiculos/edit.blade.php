<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar {{$veiculo->placa}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" bg-white overflow-hidden shadow-xl sm:rounded-lg">
            {{-- adicionar aqui a foto do modelo do veículo --}}
            
                <form action="{{ url('veiculos/store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded px-8 pt-6 pb-8 mb-4 flex items-center" style="padding:10px;">
                    @csrf
                    <input type="hidden" value="{{$veiculo->id}}" id="id" name="id">
                    <div class="grid gap-6 mb-6 md:grid-cols-1 w-full">
                        @if($veiculo->image)
                        <figure class="max-w-lg mx-auto text-center"> <!-- Added mx-auto and text-center classes -->
                            <img class="h-auto max-w-full rounded-lg" src="{{asset($veiculo->image)}}" alt="Imagem">
                            <figcaption class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">Image caption</figcaption>
                        </figure>
                        @endif
                        

                        <div>
                            <label for="placa" class="block mb-2 text-sm font-medium text-gray-900 ">Placa</label>
                            <input type="text" id="placa" name="placa" value="{{$veiculo->placa}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="uvs" required>
                        </div>

                        <div>
                            <label for="prefixo" class="block mb-2 text-sm font-medium text-gray-900 ">Prefixo</label>
                            <input type="text" id="prefixo" name="prefixo" value="{{$veiculo->prefixo}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="uvs" required>
                        </div>

                        <div>
                            <label for="condicao" class="block mb-2 text-sm font-medium text-gray-900 ">Condição</label>
                            <input type="text" id="condicao" name="condicao" value="{{$veiculo->condicao}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="uvs" required>
                        </div>

                        <div>
                            <label for="km" class="block mb-2 text-sm font-medium text-gray-900 ">Qulometragem</label>
                            <input type="number" id="km" name="km" value="{{$veiculo->km}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="uvs" required>
                        </div>

                        <div>
                            <label for="horimetro" class="block mb-2 text-sm font-medium text-gray-900 ">Horimetro</label>
                            <input type="number" id="horimetro" name="horimetro" value="{{$veiculo->horas}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="uvs" required>
                        </div>


                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 " for="file_input">Alterar a imagem</label>
                            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" aria-describedby="file_input_help" id="image" name="image" type="file">
                            <p class="mt-1 text-sm text-gray-500" id="file_input_help">Envie aqui uma imagem do veiculo atual.</p>
                        </div>
                        <div>
                            <button type="submit" class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Salvar</button>
                        </div>
                    </div>
                    
                        
                    
                </form>

            </div>
            <!-- resources/views/pagina.blade.php -->

            


        </div>
    </div>
</x-app-layout>





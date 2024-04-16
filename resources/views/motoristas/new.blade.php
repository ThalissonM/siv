<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Adicionar Motorista
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
                <form action="{{ url('motoristas/store') }}" method="POST" enctype="multipart/form-data"
                    class="bg-white rounded px-8 pt-6 pb-8 mb-4 flex items-center" style="padding:10px;">
                    <div class="grid gap-6 mb-6 md:grid-cols-1 w-full">
                        @csrf
                        <div>
                            <label for="nome" class="block mb-2 text-sm font-medium text-gray-900 ">Nome</label>
                            <input type="text" id="nome" name="nome"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                placeholder="João Paulo" required>
                        </div>
                        <div>
                            <label for="documento"
                                class="block mb-2 text-sm font-medium text-gray-900 ">Documento</label>
                            <input type="text" id="documento" name="documento"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                placeholder="19326598" required>
                        </div>
                        <div class="flex items-center mb-4">
                            <input id="ativo" name="ativo" type="checkbox"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2"
                                checked>
                            <label for="ativo" class="ms-2 text-sm font-medium text-gray-900">Ativo</label>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 " for="file_input">Enviar
                                arquivo</label>
                            <input
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50"
                                aria-describedby="file_input_help" id="image" name="image" type="file">
                            <p class="mt-1 text-sm text-gray-500" id="file_input_help">Envie aqui uma foto do motorista
                                ou do documento.</p>
                        </div>
                        <div>
                            <button type="submit"
                                class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Salvar</button>
                        </div>
                    </div>



                </form>

            </div>
        </div>
    </div>
</x-app-layout>
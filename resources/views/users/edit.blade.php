<div>
    <!-- Waste no more time arguing what a good man should be, be one. - Marcus Aurelius -->
</div>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Adicionar Usuário
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
                <form action="{{ url('usuarios/store') }}" method="POST" enctype="multipart/form-data"

                    class="bg-white rounded px-8 pt-6 pb-8 mb-4 flex items-center" style="padding:10px;">
                    <div class="grid gap-6 mb-6 md:grid-cols-1 w-full">
                        @csrf
                        <input type="hidden" value="{{$usuario->id}}" id="id" name="id">
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">Nome</label>
                            <input type="text" id="name" name="name" value="{{$usuario->name}}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                placeholder="João Paulo" required>
                        </div>
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 ">Email</label>
                            <input type="email" id="email" name="email" value="{{$usuario->email}}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="example@example.com" required>
                        </div>

                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 ">Senha (obrigatório)</label>
                            <input type="password" id="password" name="password" 
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                placeholder="Password" required>
                        </div>

                        <div>
                            <label for="passwordverify" class="block mb-2 text-sm font-medium text-gray-900 ">Confirmar
                                Senha (obrigatório)</label>
                            <input type="password" id="passwordverify" name="passwordverify"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                placeholder="Confirm Password" required>
                        </div>

                        <script>
                            const passwordInput = document.getElementById('password');
                            const passwordVerifyInput = document.getElementById('passwordverify');

                            passwordVerifyInput.addEventListener('input', () => {
                                if (passwordVerifyInput.value !== passwordInput.value) {
                                    passwordVerifyInput.setCustomValidity('Passwords do not match');
                                } else {
                                    passwordVerifyInput.setCustomValidity('');
                                }
                            });
                        </script>

                        <label for="role"
                            class="block mb-2 text-sm font-medium text-gray-900">Tipo de usuário</label>
                        <select id="role" name="role"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                            <option value="user" selected>Usuário Comum</option>
                            <option value="admin">Administrador</option>
                        </select>

                        <div class="flex items-center mb-4">
                            <input id="active" name="active" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2" {{ $usuario->active ? 'checked' : '' }}>
                            <label for="active" class="ms-2 text-sm font-medium text-gray-900">Ativo</label>
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
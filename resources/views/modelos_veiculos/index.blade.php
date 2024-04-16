<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex justify-between">
                Modelos de veiculos 
                <a href="/modelos_veiculos/new" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Novo Modelo
                </a>
            </h2>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <livewire:modelos-veiculos-table/>
            </div>
        </div>
    </div>
</x-app-layout>

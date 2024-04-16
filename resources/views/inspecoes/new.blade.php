<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            
                <form action="{{ url('inspecoes/create') }}" method="GET" class="bg-white rounded px-8 pt-6 pb-8 mb-4 flex items-center">
                    <div class="grid gap-6 mb-6 md:grid-cols-1 w-full">
                    <livewire:select-modelo-veiculo/>
                    <div>
                    <button type="submit" class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Iniciar</button>
                    </div>
                    </div>
                </form>
            
            </div>
        </div>
    </div>
</x-app-layout>

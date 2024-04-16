<!-- resources/views/livewire/pergunta-component.blade.php -->

<div style="padding:10px;">
    <!-- Input Form -->
    <form wire:submit.prevent="addPergunta">
        <div class="grid gap-6 mb-6 md:grid-cols-1">
        <div>
        <label for="pergunta" class="block mb-2 text-sm font-medium text-gray-900">Adicionar Pergunta (perguntas são os campos em que é possivel escolher Sim, Não, N.A e Justificativa)</label>
        <input type="text" wire:model="pergunta" id="pergunta" placeholder="Contem arranhados?" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
        </div>
        <button type="submit" class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" >Adicionar</button>
        </div>
    </form>

    <!-- Display Existing Perguntas -->
    <div class="grid gap-6 mb-6 md:grid-cols-1">
        @foreach ($perguntas as $pergunta)
            <li>
                {{ $pergunta->pergunta }} 
                <button wire:click="deletePergunta({{ $pergunta->id }})" class="ml-4 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Remover</button>            
            </li>
        @endforeach
    <div class="grid gap-6 mb-6 md:grid-cols-1">
</div>

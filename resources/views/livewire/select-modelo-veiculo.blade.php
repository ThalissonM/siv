<!-- resources/views/livewire/select-modelo-veiculo.blade.php -->

<div style="padding:10px;">
    <label for="modelo" class="block mb-2 text-sm font-medium text-gray-900">Selecione um Modelo:</label>

    <select wire:model="selectedModelo" id="modelo" name="modelo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 form-select">
        <option value="">selecionar...</option>
        @foreach ($modelos as $modelo)
            <option value="{{ $modelo->id }}">{{ $modelo->modelo }}</option>
        @endforeach
    </select>
</div>

<?php

namespace App\Livewire;

use App\Models\Inspecoes;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class InspecoesTable extends PowerGridComponent
{
    use WithExport;

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput()->showToggleColumns(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Inspecoes::query()
            ->join('motoristas', function ($motoristas) {
                $motoristas->on('inspecoes.motorista_id', '=', 'motoristas.id');
            })
            ->join('users', function ($users) {
                $users->on('inspecoes.user_id', '=', 'users.id');
            })
            ->join('veiculos', function ($veiculos) {
                $veiculos->on('inspecoes.veiculo_id', '=', 'veiculos.id');
            })
            ->join('modelos_veiculos', function ($modelos_veiculos) {
                $modelos_veiculos->on('inspecoes.modelo_veiculo_id', '=', 'modelos_veiculos.id');
            })
            ->select([
                'inspecoes.id',
                'inspecoes.created_at',
                'motoristas.nome as nome_motorista',
                'users.name as nome_usuario',
                'veiculos.placa as placa_veiculo',
                'modelos_veiculos.modelo as modelo_veiculo',
            ]);
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('created_at_formatted', fn(Inspecoes $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }

    public function columns(): array
    {

        return [
            Column::make('Id', 'id'),
            Column::make('Motorista', 'nome_motorista')
                ->sortable()
                ->searchable(),
            Column::make('Criado Por', 'nome_usuario')
                ->sortable()
                ->searchable(),
            Column::make('Placa', 'placa_veiculo')
                ->sortable()
                ->searchable(),
            Column::make('Modelo', 'modelo_veiculo')
                ->sortable()
                ->searchable(),
            Column::make('Criado Em', 'created_at_formatted', 'created_at')
                ->sortable()
                ->searchable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::datetimepicker('created_at'),
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert(' . $rowId . ')');
    }

    public function actions(\App\Models\Inspecoes $row): array
    {
        if (auth()->user()->role != 'admin') {
            return [
                Button::add('view')
                    ->slot('Ver')
                    ->class('bg-indigo-500 rounded-md cursor-pointer text-white px-3 py-2 m-1 text-sm')
                    ->route('inspecoes/view', ['id' => $row->id])
            ];
            // return redirect('dashboard');
        }
        return [
            Button::add('view')
                ->slot('.xlsx')
                ->class('bg-green-500 rounded-md cursor-pointer text-white px-3 py-2 m-1 text-sm')
                ->route('inspecoes/downloadxlsinspecao', ['id' => $row->id]),
            Button::add('view')
                ->slot('Ver')
                ->class('bg-indigo-500 rounded-md cursor-pointer text-white px-3 py-2 m-1 text-sm')
                ->route('inspecoes/edit', ['id' => $row->id]),
            Button::add('edit')
                ->slot('Editar')
                ->class('bg-indigo-500 rounded-md cursor-pointer text-white px-3 py-2 m-1 text-sm')
                ->route('inspecoes/edit', ['id' => $row->id]),
            Button::add('delete')
                ->slot('Remover')
                ->class('bg-red-500 rounded-md cursor-pointer text-white px-3 py-2 m-1 text-sm')
                ->route('inspecoes/delete', ['id' => $row->id])
        ];
    }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}

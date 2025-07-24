<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class TenantsTable extends PowerGridComponent
{
    public string $tableName = 'tenants-table-223sc3-table';

    public function setUp(): array
    {

        return [];
    }

    public function datasource(): Builder
    {
        return User::query()
            ->where('role', 'tenant');
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('identification_number')
            ->add('name')
            ->add('phone')
            ->add('status', function($row) {
                return view('components.status-badge', ['status' => $row->status]);
            })
            ->add('payment_status', function($row) {
                return view('components.payment-status-badge', ['status' => $row->payment_status]);
            })
            ->add('created_at_formatted', fn (User $model) =>  Carbon::parse($model->created_at)->locale('es')->isoFormat('D [de] MMMM [de] YYYY'));
    }

    public function columns(): array
    {
        return [
            Column::make('Identificación', 'identification_number')
                ->bodyAttribute('text-xs font-medium text-gray-900 dark:text-white ')
                ->sortable()
                ->searchable(),

            Column::make('Nombre Completo', 'name')
                ->bodyAttribute('text-xs font-medium text-gray-900 dark:text-white ')
                ->sortable()
                ->searchable(),

            Column::make('Teléfono', 'phone')
                ->bodyAttribute('text-xs font-medium text-gray-900 dark:text-white ')
                ->sortable()
                ->searchable(),

            Column::make('Estado', 'status')
                ->bodyAttribute('text-xs font-medium text-gray-900 dark:text-white ')
                ->sortable()
                ->searchable(),

            Column::make('Estado de Pago', 'payment_status')
                ->bodyAttribute('text-xs font-medium text-gray-900 dark:text-white ')
                ->sortable()
                ->searchable(),

            Column::make('Fecha de Registro', 'created_at_formatted', 'created_at')
                ->bodyAttribute('text-xs font-medium text-gray-900 dark:text-white ')
                ->sortable()
        ];
    }
    

    // public function actions(\App\Models\User $row): array
    // {
    //     return [
    //         Button::add('edit')
    //             ->slot('Editar')
    //             ->id()
    //             ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
    //             ->dispatch('edit', ['rowId' => $row->id])
    //     ];
    // }
} 
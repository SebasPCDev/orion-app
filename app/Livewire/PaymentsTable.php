<?php

namespace App\Livewire;

use App\Models\Payment;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class PaymentsTable extends PowerGridComponent
{
    public string $tableName = 'payments-table-223sc3-table';


    public function setUp(): array
    {

        return [];
    }

    public function datasource(): Builder
    {
        return Payment::query()
            ->join('apartments', 'payments.apartment_id', '=', 'apartments.id')
            ->join('users', 'payments.user_id', '=', 'users.id')
            ->select('payments.*', 'apartments.name as apartment_name', 'users.name as user_name')
            ->orderBy('payments.created_at', 'desc');
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('apartment_name', fn (Payment $model) => str_replace('Apto ', '', $model->apartment_name))
            ->add('user_name')
            ->add('amount', fn (Payment $model) => '$' . number_format($model->amount, 0, ',', '.'))
            ->add('payment_date_formatted', fn (Payment $model) => Carbon::parse($model->payment_date)->locale('es')->isoFormat('D [de] MMMM [de] YYYY'))
            ->add('month')
            ->add('status')
            ->add('description');
    }

    public function columns(): array
    {
        return [
            Column::make('Apto/Casa', 'apartment_name')
            ->bodyAttribute('text-xs font-medium text-gray-900 dark:text-white '),
            Column::make('Inquilino', 'user_name')
            ->bodyAttribute('text-xs font-medium text-gray-900 dark:text-white '),
            Column::make('Monto', 'amount')
                ->sortable()
                ->bodyAttribute('text-xs font-medium text-gray-900 dark:text-white ')
                ->searchable(),

            Column::make('Fecha Pago', 'payment_date_formatted', 'payment_date')
                ->sortable()
                ->bodyAttribute('text-xs font-medium text-gray-900 dark:text-white '),

            Column::make('Mes', 'month')
                ->sortable()
                ->searchable()
                ->bodyAttribute('text-xs font-medium text-gray-900 dark:text-white '),

            Column::make('Estado', 'status')    
                ->sortable()
                ->searchable()
                ->bodyAttribute('text-xs font-medium text-gray-900 dark:text-white '),

            Column::make('Descripción', 'description')
                ->sortable()
                ->searchable()
                ->bodyAttribute('text-xs font-medium text-gray-900 dark:text-white '),

                
        ];
    }

    // public function filters(): array
    // {
    //     return [
    //         Filter::datepicker('payment_date'),
    //     ];
    // }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    }

    // public function actions(Payment $row): array
    // {
    //     return [
    //         Button::add('edit')
    //             ->slot('Edit: '.$row->id)
    //             ->id()
    //             ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
    //             ->dispatch('edit', ['rowId' => $row->id])
    //     ];
    // }

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

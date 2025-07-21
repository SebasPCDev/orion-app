<div class="grid auto-rows-min gap-4 md:grid-cols-3">
    <!-- Total Revenue vs Annual Goal -->
    <div class="relative flex flex-col gap-2 rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
        <div class="flex items-center gap-2">
            <div class="text-xl font-semibold">
                Ingresos Totales
            </div>
        </div>
        <div class="text-3xl font-bold">
            ${{ number_format($totalRevenue, 0, ',', '.') }}
        </div>
        <div class="text-sm text-neutral-500 dark:text-neutral-400">
            Meta Anual: ${{ number_format($annualGoal, 0, ',', '.') }}
        </div>
    </div>

    <!-- Total Payments -->
    <div class="relative flex flex-col gap-2 rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
        <div class="flex items-center gap-2">
            <div class="text-xl font-semibold">
                Pagos Recibidos (Año)
            </div>
        </div>
        <div class="text-3xl font-bold">
            {{ $totalPayments }}
        </div>
        <div class="text-sm text-neutral-500 dark:text-neutral-400">
            Total de transacciones en 2025
        </div>
    </div>

    <!-- Current Month Payments -->
    <div class="relative flex flex-col gap-2 rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
        <div class="flex items-center gap-2">
            <div class="text-xl font-semibold">
                Pagos de {{ $currentMonth }}
            </div>
        </div>
        @if($currentMonthPayments > 0)
            <div class="text-3xl font-bold">
                ${{ number_format($currentMonthPayments, 0, ',', '.') }}
            </div>
            <div class="text-sm text-neutral-500 dark:text-neutral-400">
                Ingresos recibidos en {{ $currentMonth }}
            </div>
        @else
            <div class="text-2xl font-semibold text-neutral-500 dark:text-neutral-400">
                No hay pagos este mes.
            </div>
        @endif
    </div>
</div>

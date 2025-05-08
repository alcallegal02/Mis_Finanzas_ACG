<x-app-layout> {{-- Esto asume que estás usando el layout de Breeze que suele ser app-layout --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Dashboard de Finanzas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Mensajes de Sesión (éxito, error) --}}
            @if (session('success'))
                <div class="p-4 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-100 rounded-lg shadow-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="p-4 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-100 rounded-lg shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Saludo al usuario --}}
            <div class="p-4 sm:p-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <p class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __("¡Hola, ") }} {{ $userName }}!
                </p>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                    {{ __("Este es tu resumen financiero.") }}
                </p>
            </div>

            {{-- Tarjeta de Resumen General --}}
            <div class="p-4 sm:p-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-gray-100">
                    {{ __('Resumen General') }}
                </h3>
                <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Ingresos Totales:') }}</p>
                        <p class="mt-1 text-2xl font-semibold text-green-600 dark:text-green-400">${{ number_format($totalIncome, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Gastos Totales:') }}</p>
                        <p class="mt-1 text-2xl font-semibold text-red-600 dark:text-red-400">${{ number_format($totalExpense, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Balance:') }}</p>
                        <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-gray-100">${{ number_format($balance, 2) }}</p>
                    </div>
                </div>
            </div>

            {{-- Tarjeta de Últimas Transacciones --}}
            <div class="p-4 sm:p-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-gray-100">
                        {{ __('Últimas Transacciones') }}
                    </h3>
                    <a href="{{ route('web.transactions.create') }}" class="mt-3 sm:mt-0 inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        {{ __('Añadir Transacción') }}
                    </a>
                </div>

                @if($transactions->count())
                    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700"> {{-- Ajustado el fondo del thead para modo oscuro --}}
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">{{ __('Fecha') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">{{ __('Descripción') }}</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">{{ __('Tipo') }}</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">{{ __('Monto') }}</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">{{ __('Acciones') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($transactions as $index => $transaction)
                                    <tr class="{{ $index % 2 == 0 ? 'bg-white dark:bg-gray-800' : 'bg-gray-50 dark:bg-gray-750' }}">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                            {{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $transaction->description }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                            @if($transaction->type == 'income')
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                                    {{ __('Ingreso') }}
                                                </span>
                                            @else
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100">
                                                    {{ __('Gasto') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200 text-right font-medium">
                                            ${{ number_format($transaction->amount, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-medium">
                                            <a href="{{ route('web.transactions.edit', $transaction->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3">
                                                {{ __('Editar') }}
                                            </a>
                                            <form action="{{ route('web.transactions.destroy', $transaction->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta transacción?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                    {{ __('Eliminar') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $transactions->links() }}
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="mt-3 text-sm font-medium text-gray-900 dark:text-gray-100">{{ __("No tienes transacciones registradas.") }}</p>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __("Comienza añadiendo una nueva transacción.") }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
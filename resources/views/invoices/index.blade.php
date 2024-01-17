<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Invoices') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="relative overflow-x-auto">
                    <form method="get" action="{{ route('invoices.index') }}" class="pb-4 space-x-2">
                        <input type="date" value="{{ $dateFrom }}" name="date_from" class="rounded">
                        <input type="date" value="{{ $dateTo }}" name="date_to" class="rounded">
                        <button class="border border-blue-500 p-2 text-sm rounded">Apply</button>
                        <a href="{{ route('invoices.index') }}" class="border border-red-500 p-2 text-sm rounded">Reset</a>
                    </form>

                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-700 uppercase">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Order ID
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Date
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invoices as $invoice)
                            <tr class="bg-white border-b">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $invoice->order->id }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $invoice->status }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $invoice->created_at }}
                                </td>
                                <td class="px-6 py-4 space-x-4">
                                    <a href="{{ route('invoices.downloadPdf', $invoice->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Download PDF</a>
                                    <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $invoices->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

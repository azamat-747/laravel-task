<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="p-4">
                    <a href="{{ route('orders.downloadPdf', $order->id) }}" class="border p-2 border-blue-500 rounded">Download as PDF</a>
                </div>
                <div class="p-4">
                    <h1 class="text-2xl font-semibold text-gray-900">Order ID: {{ $order->id }}</h1>
                    <h1 class="text-2xl font-semibold text-gray-900">User: {{ $order->user->fullName }}</h1>
                    <h1 class="text-2xl font-semibold text-gray-900">Amount: {{ $order->amountFormatted }}</h1>
                </div>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-700 uppercase">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Product
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Quantity
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Price
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Total
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->orderDetails as $detail)
                            <tr class="bg-white border-b">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $detail->product->title }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $detail->quantity }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $detail->priceFormatted }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $detail->totalFormatted }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

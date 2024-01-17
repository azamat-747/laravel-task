<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsUpdateRequest;
use App\Models\Invoice;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrdersController extends Controller
{
    public function index(Request $request) {
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        $orders = Order::query()
            ->filter($dateFrom, $dateTo)
            ->latest()
            ->paginate(12);
        return view('orders.index', compact('orders', 'dateFrom', 'dateTo'));
    }

    public function edit($id) {
        $order = Order::query()->select('id', 'status')->findOrFail($id);
        return view('orders.edit', compact('order'));
    }

    public function update(ProductsUpdateRequest $request, $id) {
        $order = Order::findOrFail($id);
        $order->update($request->validated());
        return to_route('orders.index');
    }

    public function getPdf($id)
    {
        $order = Order::query()
            ->with('orderDetails.product', 'user')
            ->findOrFail($id);
        return view('orders.pdf', compact('order'));
    }

    public function downloadPdf($id)
    {
        $order = Order::findOrFail($id);

        $invoice = Invoice::query()->select('file')->where('order_id', $order->id)->first();
        if ($invoice) {
            return Storage::download($invoice->file, 'invoice.pdf');
        } else {
            $order->load('orderDetails.product', 'user');
            $pdf = Pdf::loadView('orders.pdfTemplate', compact('order'));
            return $pdf->download('invoice.pdf');
        }
    }
}

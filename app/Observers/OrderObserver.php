<?php

namespace App\Observers;

use App\Models\Invoice;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class OrderObserver
{
    public function updated(Order $order)
    {
        if ($order->status == 3) {
            $order->load('orderDetails.product', 'user');
            $pdf = PDF::loadView('orders.pdfTemplate', compact('order'));
            $file = 'invoices/' . uniqid() . '.pdf';

            Storage::put($file, $pdf->output());

            Invoice::create([
                'order_id' => $order->id,
                'file' => $file,
            ]);
        }
    }
}

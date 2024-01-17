<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoicesController extends Controller
{
    public function index(Request $request) {
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        $invoices = Invoice::query()
            ->with('order')
            ->filter($dateFrom, $dateTo)
            ->latest()
            ->paginate(12);
        return view('invoices.index', compact('invoices', 'dateFrom', 'dateTo'));
    }

    public function downloadPdf($id)
    {
        $invoice = Invoice::query()->select('file')->findOrFail($id);
        if (Storage::fileExists($invoice->file)) {
            return Storage::download($invoice->file, 'invoice.pdf');
        } else {
            abort(404);
        }
    }

    public function destroy($id) {
        $invoice = Invoice::findOrFail($id);
        if (Storage::fileExists($invoice->file)) {
            Storage::delete($invoice->file);
        }
        $invoice->delete();
        return to_route('invoices.index');
    }
}

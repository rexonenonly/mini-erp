<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\PurchaseOrder;
use Illuminate\Http\Response;

class PdfController extends Controller
{
    public function invoicePdf(Invoice $invoice): Response
    {
        $invoice->load(['customer', 'lines.product']);
        $html = view('pdf.invoice', compact('invoice'))->render();
        return $this->pdf($html, 'invoice-' . $invoice->number . '.pdf');
    }

    public function purchaseOrderPdf(PurchaseOrder $po): Response
    {
        $po->load(['supplier', 'warehouse', 'lines.product']);
        $html = view('pdf.purchase-order', compact('po'))->render();
        return $this->pdf($html, 'po-' . $po->number . '.pdf');
    }

    private function pdf(string $html, string $filename): Response
    {
        // ponytail: if dompdf not installed, serves HTML with print CSS; install barryvdh/laravel-dompdf to get real PDF bytes
        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);
            return response($pdf->output(), 200, [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filename . '"',
            ]);
        }

        // Fallback: browser print-to-PDF
        return response($html, 200, ['Content-Type' => 'text/html']);
    }
}

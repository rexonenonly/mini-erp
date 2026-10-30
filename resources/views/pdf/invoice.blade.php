<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->number }}</title>
    <style>
        @page { margin: 2cm; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 11pt; line-height: 1.4; }
        .header { margin-bottom: 20px; }
        .header h1 { font-size: 18pt; margin-bottom: 5px; }
        .header p { font-size: 10pt; color: #666; }
        .info { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .info div { width: 48%; }
        .info h3 { font-size: 11pt; margin-bottom: 5px; border-bottom: 1px solid #000; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f5f5f5; font-weight: 600; }
        .right { text-align: right; }
        .total { font-weight: bold; font-size: 12pt; border-top: 2px solid #000; }
        @media print { body { margin: 0; } }
    </style>
</head>
<body>
    <div class="header">
        <h1>INVOICE</h1>
        <p>{{ $invoice->number }} | {{ $invoice->invoice_date->format('d M Y') }}</p>
    </div>

    <div class="info">
        <div>
            <h3>Bill To</h3>
            <p><strong>{{ $invoice->customer->name }}</strong></p>
            <p>{{ $invoice->customer->address ?? '' }}</p>
        </div>
        <div>
            <h3>Payment Terms</h3>
            <p>Due Date: <strong>{{ $invoice->due_date->format('d M Y') }}</strong></p>
            <p>Status: {{ $invoice->status }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>SKU</th>
                <th>Description</th>
                <th class="right">Qty</th>
                <th class="right">Unit Price</th>
                <th class="right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->lines as $line)
            <tr>
                <td>{{ $line->product->sku ?? '' }}</td>
                <td>{{ $line->description ?? $line->product->name }}</td>
                <td class="right">{{ number_format($line->qty, 2) }}</td>
                <td class="right">{{ number_format($line->unit_price, 2) }}</td>
                <td class="right">{{ number_format($line->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total">
                <td colspan="4">TOTAL</td>
                <td class="right">{{ number_format($invoice->total_amount, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    @if($invoice->notes)
    <p><strong>Notes:</strong> {{ $invoice->notes }}</p>
    @endif
</body>
</html>

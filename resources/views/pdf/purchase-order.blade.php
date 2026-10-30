<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Purchase Order {{ $po->number }}</title>
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
        <h1>PURCHASE ORDER</h1>
        <p>{{ $po->number }} | {{ $po->order_date->format('d M Y') }}</p>
    </div>

    <div class="info">
        <div>
            <h3>Supplier</h3>
            <p><strong>{{ $po->supplier->name }}</strong></p>
            <p>{{ $po->supplier->address ?? '' }}</p>
        </div>
        <div>
            <h3>Delivery</h3>
            <p>Warehouse: <strong>{{ $po->warehouse->name ?? '' }}</strong></p>
            <p>Status: {{ $po->status }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>SKU</th>
                <th>Description</th>
                <th class="right">Qty Ordered</th>
                <th class="right">Unit</th>
                <th class="right">Unit Price</th>
                <th class="right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($po->lines as $line)
            <tr>
                <td>{{ $line->product->sku ?? '' }}</td>
                <td>{{ $line->product->name ?? '' }}</td>
                <td class="right">{{ number_format($line->qty_ordered, 2) }}</td>
                <td>{{ $line->unit ?? '' }}</td>
                <td class="right">{{ number_format($line->unit_price, 2) }}</td>
                <td class="right">{{ number_format($line->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total">
                <td colspan="5">TOTAL</td>
                <td class="right">{{ number_format($po->total_amount, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    @if($po->notes)
    <p><strong>Notes:</strong> {{ $po->notes }}</p>
    @endif
</body>
</html>

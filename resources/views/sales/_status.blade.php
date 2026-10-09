@php
$map = [
    'draft'     => ['bg-slate-50',    'text-slate-700',   'border-slate-200',  'Draft'],
    'confirmed' => ['bg-blue-50',     'text-blue-700',    'border-blue-200',   'Dikonfirmasi'],
    'partial'   => ['bg-amber-50',    'text-amber-700',   'border-amber-200',  'Parsial'],
    'completed' => ['bg-emerald-50',  'text-emerald-700', 'border-emerald-200','Selesai'],
    'cancelled' => ['bg-rose-50',     'text-rose-700',    'border-rose-200',   'Dibatalkan'],
    'posted'    => ['bg-emerald-50',  'text-emerald-700', 'border-emerald-200','Diposting'],
    'reversed'  => ['bg-rose-50',     'text-rose-700',    'border-rose-200',   'Dibalik'],
    'open'      => ['bg-blue-50',     'text-blue-700',    'border-blue-200',   'Terbuka'],
    'paid'      => ['bg-emerald-50',  'text-emerald-700', 'border-emerald-200','Lunas'],
    'overdue'   => ['bg-rose-50',     'text-rose-700',    'border-rose-200',   'Jatuh Tempo'],
];
[$bg, $text, $border, $label] = $map[$status] ?? ['bg-slate-50', 'text-slate-700', 'border-slate-200', ucfirst($status)];
@endphp
<span class="inline-flex px-2 py-0.5 rounded text-xs {{ $bg }} {{ $text }} border {{ $border }}">{{ $label }}</span>

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['sku' => 'SKU-ELC-091', 'name' => 'Kabel NYM 3x2.5mm (100m)', 'unit' => 'Roll', 'purchase_price' => 675000, 'sale_price' => 760000, 'min_stock' => 30, 'is_active' => true],
            ['sku' => 'SKU-ELC-003', 'name' => 'MCB 1P 16A Schneider', 'unit' => 'Pcs', 'purchase_price' => 51500, 'sale_price' => 62000, 'min_stock' => 10, 'is_active' => true],
            ['sku' => 'SKU-ELC-007', 'name' => 'Sakelar Tukar Schneider', 'unit' => 'Pcs', 'purchase_price' => 18500, 'sale_price' => 24000, 'min_stock' => 8, 'is_active' => true],
            ['sku' => 'SKU-MEC-014', 'name' => 'Bearing Ball Industrial 6205', 'unit' => 'Pcs', 'purchase_price' => 145000, 'sale_price' => 178000, 'min_stock' => 10, 'is_active' => true],
            ['sku' => 'SKU-LUB-082', 'name' => 'Oli Pelumas Industri ISO-VG46', 'unit' => 'Pail', 'purchase_price' => 1150000, 'sale_price' => 1320000, 'min_stock' => 10, 'is_active' => true],
            ['sku' => 'SKU-PNE-301', 'name' => 'Konektor Pneumatik 1/4 inch', 'unit' => 'Pcs', 'purchase_price' => 48000, 'sale_price' => 59000, 'min_stock' => 15, 'is_active' => true],
            ['sku' => 'SKU-BLD-002', 'name' => 'Semen Mortar Skimcoat 40kg', 'unit' => 'Sak', 'purchase_price' => 78500, 'sale_price' => 92000, 'min_stock' => 100, 'is_active' => true],
            ['sku' => 'SKU-ELC-015', 'name' => 'Kabel NYA 1x1.5mm (100m)', 'unit' => 'Roll', 'purchase_price' => 410000, 'sale_price' => 480000, 'min_stock' => 20, 'is_active' => false],
        ] as $r) DB::table('products')->updateOrInsert(['sku' => $r['sku']], $r);

        foreach ([
            ['code' => 'WH-001', 'name' => 'Gudang Pusat Jakarta', 'address' => 'Jl. Sudirman No.10, Jakarta', 'phone' => '021-1110001'],
            ['code' => 'WH-002', 'name' => 'Gudang Surabaya', 'address' => 'Jl. Tunjungan No.25, Surabaya', 'phone' => '031-2220002'],
            ['code' => 'WH-003', 'name' => 'Gudang Bandung', 'address' => 'Jl. Braga No.8, Bandung', 'phone' => '022-3330003'],
            ['code' => 'WH-004', 'name' => 'Gudang Medan', 'address' => 'Jl. Gatot Subroto No.12, Medan', 'phone' => '061-4440004'],
            ['code' => 'WH-005', 'name' => 'Gudang Makassar', 'address' => 'Jl. Pettarani No.5, Makassar', 'phone' => '0411-5550005'],
        ] as $r) DB::table('warehouses')->updateOrInsert(['code' => $r['code']], $r + ['is_active' => true]);

        foreach ([
            ['code' => 'CUST-001', 'name' => 'PT Maju Jaya', 'type' => 'customer', 'contact_person' => 'Budi', 'phone' => '081111111001', 'email' => 'budi@majujaya.id', 'address' => 'Jakarta'],
            ['code' => 'SUPP-001', 'name' => 'CV Sumber Makmur', 'type' => 'supplier', 'contact_person' => 'Siti', 'phone' => '081222222002', 'email' => 'siti@sumbermakmur.id', 'address' => 'Surabaya'],
            ['code' => 'BOTH-001', 'name' => 'PT Dua Arah', 'type' => 'both', 'contact_person' => 'Andi', 'phone' => '081333333003', 'email' => 'andi@duaarah.id', 'address' => 'Bandung'],
            ['code' => 'CUST-002', 'name' => 'Toko Berkah Abadi', 'type' => 'customer', 'contact_person' => 'Rina', 'phone' => '081444444004', 'email' => 'rina@berkah.id', 'address' => 'Medan'],
            ['code' => 'SUPP-002', 'name' => 'PT Global Supply', 'type' => 'supplier', 'contact_person' => 'Joko', 'phone' => '081555555005', 'email' => 'joko@globalsupply.id', 'address' => 'Semarang'],
        ] as $r) DB::table('partners')->updateOrInsert(['code' => $r['code']], $r + ['is_active' => true]);

        foreach ([
            ['code' => '1101', 'name' => 'Kas', 'type' => 'asset', 'balance' => 500000000],
            ['code' => '1102', 'name' => 'Bank BCA', 'type' => 'asset', 'balance' => 1200000000],
            ['code' => '2101', 'name' => 'Utang Usaha', 'type' => 'liability', 'balance' => 300000000],
            ['code' => '4101', 'name' => 'Pendapatan Penjualan', 'type' => 'revenue', 'balance' => 0],
            ['code' => '5101', 'name' => 'Beban Operasional', 'type' => 'expense', 'balance' => 0],
        ] as $r) DB::table('accounts')->updateOrInsert(['code' => $r['code']], $r + ['is_active' => true]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public const SEEDED_ROLES = ['Owner', 'Staf Gudang', 'Staf Penjualan', 'Staf Pembelian', 'Akuntan'];

    public static function allPermissions(): array
    {
        $perms = [];
        foreach (config('permissions.groups', []) as $group => $resources) {
            foreach ($resources as $resource => $meta) {
                foreach ($meta['actions'] as $action) {
                    $perms[] = "$resource.$action";
                }
            }
        }
        return $perms;
    }

    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // sync permissions
        foreach (self::allPermissions() as $name) {
            Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
        }

        $all = self::allPermissions();

        // view-only helper
        $viewOnly = array_values(array_filter($all, fn($p) => str_ends_with($p, '.view')));

        $roles = [
            'Owner' => $all,
            'Staf Gudang' => [
                'products.view', 'warehouses.view', 'partners.view',
                'stock.view',
                'stock-opnames.view', 'stock-opnames.create', 'stock-opnames.update', 'stock-opnames.post',
                'stock-transfers.view', 'stock-transfers.create', 'stock-transfers.update', 'stock-transfers.post',
                'purchase-orders.view',
                'goods-receipts.view', 'goods-receipts.create', 'goods-receipts.update', 'goods-receipts.post',
                'sales-orders.view',
                'deliveries.view', 'deliveries.create', 'deliveries.update', 'deliveries.post',
                'inventory-valuation.view',
            ],
            'Staf Penjualan' => [
                'products.view', 'warehouses.view',
                'partners.view', 'partners.create', 'partners.update',
                'stock.view',
                'sales-orders.view', 'sales-orders.create', 'sales-orders.update', 'sales-orders.confirm', 'sales-orders.cancel',
                'deliveries.view',
                'invoices.view', 'invoices.create', 'invoices.update', 'invoices.post',
                'customer-payments.view', 'customer-payments.create',
                'aging-receivable.view',
            ],
            'Staf Pembelian' => [
                'products.view', 'warehouses.view',
                'partners.view', 'partners.create', 'partners.update',
                'stock.view',
                'purchase-orders.view', 'purchase-orders.create', 'purchase-orders.update', 'purchase-orders.confirm', 'purchase-orders.cancel',
                'goods-receipts.view',
                'vendor-bills.view', 'vendor-bills.create', 'vendor-bills.update', 'vendor-bills.post',
                'supplier-payments.view', 'supplier-payments.create',
                'aging-payable.view',
            ],
            'Akuntan' => array_values(array_unique(array_merge(
                // every view except users, roles, system-health
                array_values(array_filter($viewOnly, fn($p) => ! in_array(explode('.', $p)[0], ['users', 'roles', 'system-health']))),
                ['accounts.create', 'accounts.update', 'journals.create', 'periods.close'],
                // every reverse
                array_values(array_filter($all, fn($p) => str_ends_with($p, '.reverse'))),
                // audit-logs.view already in viewOnly; ensure
                ['audit-logs.view']
            ))),
        ];

        foreach ($roles as $name => $perms) {
            $role = Role::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
            $role->syncPermissions($perms);
        }

        // ensure Owner always has ALL
        if ($owner = Role::where('name', 'Owner')->first()) {
            $owner->syncPermissions($all);
        }

        // clean stale permissions not in config (keep DB tidy)
        Permission::whereNotIn('name', $all)->delete();

        // seed demo users
        $password = env('DEMO_USER_PASSWORD', 'password');
        $users = [
            ['name' => 'Rex Pradana', 'email' => 'owner@minierp.test', 'role' => 'Owner'],
            ['name' => 'Budi', 'email' => 'pembelian@minierp.test', 'role' => 'Staf Pembelian'],
            ['name' => 'Hasan', 'email' => 'gudang@minierp.test', 'role' => 'Staf Gudang'],
            ['name' => 'Rina', 'email' => 'penjualan@minierp.test', 'role' => 'Staf Penjualan'],
            ['name' => 'Dewi', 'email' => 'akuntan@minierp.test', 'role' => 'Akuntan'],
        ];
        foreach ($users as $u) {
            $user = User::firstOrCreate(['email' => $u['email']], [
                'name' => $u['name'],
                'password' => Hash::make($password),
                'is_active' => true,
            ]);
            // idempotent role assignment (single role)
            $user->syncRoles([$u['role']]);
            // ensure active
            if (! $user->is_active) {
                $user->update(['is_active' => true]);
            }
        }

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}

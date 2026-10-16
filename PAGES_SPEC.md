# Mini-ERP System Specification

**Status**: Active Development  
**Framework**: Laravel 10  
**Database**: MySQL-compatible  
**Auth**: Laravel built-in + Spatie Permission  
**Last Updated**: 2026-10-15

## Overview

Mini-ERP dengan 4 modul inti: Master Data, Inventory, Purchasing, Sales, plus Accounting & Reports. Semua dokumen transaksional (PO, GR, SO, DO, Invoice) support line items dengan auto-numbering.

## Database Schema

### Master Data Tables

#### `products`
- `id`, `sku` (unique), `name`, `unit`, `purchase_price`, `sale_price`, `min_stock`, `is_active`
- Timestamps

#### `warehouses`
- `id`, `code` (unique), `name`, `address`, `phone`, `is_active`
- Timestamps

#### `partners`
- `id`, `code` (unique), `name`, `type` (customer/supplier/both), `contact_person`, `phone`, `email`, `address`, `is_active`
- Timestamps

#### `accounts`
- `id`, `code` (unique), `name`, `type` (asset/liability/equity/revenue/expense), `balance`, `is_active`
- Timestamps

### Inventory Tables

#### `stock_balances`
- `id`, `product_id`, `warehouse_id`, `on_hand`, `reserved`, `unit_cost`
- Unique: `[product_id, warehouse_id]`
- Calculated: `available = on_hand - reserved`

#### `stock_opnames`
- `id`, `number` (unique), `opname_date`, `warehouse_id`, `notes`, `status` (draft/posted/reversed), `created_by`, `posted_at`
- Soft deletes, timestamps

#### `stock_opname_items`
- `id`, `opname_id` (cascade), `product_id`, `system_qty`, `physical_qty`, `difference` (computed), `unit_cost`

#### `stock_transfers`
- `id`, `number` (unique), `transfer_date`, `from_warehouse_id`, `to_warehouse_id`, `notes`, `status` (draft/posted/reversed), `created_by`, `posted_at`
- Soft deletes, timestamps

#### `stock_transfer_items`
- `id`, `transfer_id` (cascade), `product_id`, `qty`, `unit_cost`

### Purchasing Tables

#### `purchase_orders`
- `id`, `number` (unique), `order_date`, `supplier_id`, `warehouse_id`, `total_amount`, `status` (draft/confirmed/partial/completed/cancelled), `notes`, `created_by`, `confirmed_at`
- Soft deletes, timestamps

#### `purchase_order_lines`
- `id`, `purchase_order_id` (cascade), `product_id`, `qty`, `unit`, `unit_price`, `subtotal`, `notes`
- Index: `[purchase_order_id, product_id]`

#### `goods_receipts`
- `id`, `number` (unique), `receipt_date`, `purchase_order_id` (nullable), `supplier_id`, `warehouse_id`, `total_value`, `status` (draft/posted/reversed), `notes`, `created_by`, `posted_at`
- Soft deletes, timestamps

#### `goods_receipt_lines`
- `id`, `goods_receipt_id` (cascade), `product_id`, `qty`, `unit`, `unit_cost`, `subtotal`, `notes`
- Index: `[goods_receipt_id, product_id]`

#### `vendor_bills`
- `id`, `number` (unique), `bill_date`, `due_date`, `receipt_id` (nullable), `supplier_id`, `total_amount`, `paid_amount`, `status` (open/partial/paid/reversed), `notes`
- Soft deletes, timestamps

#### `vendor_bill_lines`
- `id`, `vendor_bill_id` (cascade), `product_id` (nullable), `description`, `amount`

#### `supplier_payments`
- `id`, `number` (unique), `payment_date`, `bill_id` (nullable), `supplier_id`, `amount`, `method` (transfer/cash/check), `status` (draft/posted/reversed), `notes`, `created_by`
- Soft deletes, timestamps

### Sales Tables

#### `sales_orders`
- `id`, `number` (unique), `order_date`, `customer_id`, `warehouse_id`, `total_amount`, `status` (draft/confirmed/partial/completed/cancelled), `notes`, `created_by`, `confirmed_at`
- Soft deletes, timestamps

#### `sales_order_lines`
- `id`, `sales_order_id` (cascade), `product_id`, `qty`, `unit`, `unit_price`, `subtotal`, `notes`
- Index: `[sales_order_id, product_id]`

#### `deliveries`
- `id`, `number` (unique), `delivery_date`, `sales_order_id` (nullable), `customer_id`, `warehouse_id`, `total_value`, `status` (draft/posted/reversed), `notes`, `created_by`, `posted_at`
- Soft deletes, timestamps

#### `delivery_lines`
- `id`, `delivery_id` (cascade), `product_id`, `qty`, `unit`, `unit_cost`, `subtotal`, `notes`
- Index: `[delivery_id, product_id]`

#### `invoices`
- `id`, `number` (unique), `invoice_date`, `due_date`, `delivery_id` (nullable), `customer_id`, `total_amount`, `paid_amount`, `status` (open/partial/paid/overdue/reversed), `notes`
- Soft deletes, timestamps

#### `invoice_lines`
- `id`, `invoice_id` (cascade), `product_id` (nullable), `description`, `qty`, `unit_price`, `subtotal`

#### `customer_payments`
- `id`, `number` (unique), `payment_date`, `invoice_id` (nullable), `customer_id`, `amount`, `method` (transfer/cash/check), `status` (draft/posted/reversed), `notes`, `created_by`
- Soft deletes, timestamps

### Accounting Tables

#### `journal_entries`
- `id`, `number` (unique), `entry_date`, `source_type`, `source_id`, `description`, `status` (draft/posted/reversed), `created_by`, `posted_at`
- Index: `[source_type, source_id]`
- Soft deletes, timestamps

#### `journal_lines`
- `id`, `journal_entry_id` (cascade), `account_id`, `debit`, `credit`, `memo`

## Routes & Endpoints

### Authentication
- `GET /login` → login form
- `POST /login` → authenticate
- `POST /logout` → logout (auth)

### Dashboard
- `GET /dashboard` → dashboard (auth)

### Master Data
- `GET /master-data/{resource}` → index (products, warehouses, partners, accounts)
- `POST /master-data/{resource}` → store
- `GET /master-data/{resource}/{id}` → show
- `PUT /master-data/{resource}/{id}` → update
- `DELETE /master-data/{resource}/{id}` → destroy

### Inventory
- `GET /inventory/stock` → stock balances index (permission: stock.view)
- `GET /inventory/stock/{balance}` → show stock balance (permission: stock.view)
- `POST /inventory/stock` → create stock balance (permission: stock.create)
- `PUT /inventory/stock/{balance}` → update stock balance (permission: stock.update)
- `DELETE /inventory/stock/{balance}` → delete stock balance (permission: stock.delete)
- `GET /inventory/opname` → stock opname index (stock-opnames resource, permission: stock-opnames.view)
- `GET /inventory/transfers` → stock transfers index (stock-transfers resource, permission: stock-transfers.view)

### Purchasing
- `GET /purchasing/orders` → purchase orders (resource: purchase-orders)
- `GET /purchasing/receipts` → goods receipts (resource: goods-receipts)
- `GET /purchasing/bills` → vendor bills (resource: vendor-bills)
- `GET /purchasing/payments` → supplier payments (resource: supplier-payments)
- `POST /purchasing/{resource}` → store (purchase-orders, goods-receipts, vendor-bills, supplier-payments)
- `GET /purchasing/{resource}/{id}` → show
- `PUT /purchasing/{resource}/{id}` → update
- `DELETE /purchasing/{resource}/{id}` → destroy

### Sales
- `GET /sales/orders` → sales orders (resource: sales-orders)
- `GET /sales/deliveries` → deliveries
- `GET /sales/invoices` → invoices
- `GET /sales/payments` → customer payments (resource: customer-payments)
- `POST /sales/{resource}` → store (sales-orders, deliveries, invoices, customer-payments)
- `GET /sales/{resource}/{id}` → show
- `PUT /sales/{resource}/{id}` → update
- `DELETE /sales/{resource}/{id}` → destroy

### Accounting
- `GET /accounting/journals` → journal entries (permission: journals.view)
- `GET /accounting/ledger` → ledger (permission: ledger.view)
- `GET /accounting/periods` → periods (permission: periods.view)

### Reports
- `GET /reports/trial-balance` → trial balance (permission: trial-balance.view)
- `GET /reports/income-statement` → income statement (permission: income-statement.view)
- `GET /reports/aging` → aging report (permission: reports.aging.view)
- `GET /reports/inventory-valuation` → inventory valuation (permission: inventory-valuation.view)

### System
- `GET /system/users` → users index (permission: users.view)
- `GET /system/users/create` → create form (permission: users.create)
- `POST /system/users` → store user (permission: users.create)
- `GET /system/users/{user}/edit` → edit form (permission: users.update)
- `PUT /system/users/{user}` → update user (permission: users.update)
- `PATCH /system/users/{user}/status` → toggle active status (permission: users.update)
- `GET /system/roles` → roles index (permission: roles.view)
- `GET /system/roles/create` → create form (permission: roles.create)
- `POST /system/roles` → store role (permission: roles.create)
- `GET /system/roles/{role}/edit` → edit form (permission: roles.update)
- `PUT /system/roles/{role}` → update role (permission: roles.update)
- `DELETE /system/roles/{role}` → destroy role (permission: roles.update)

## Business Logic

### Controllers

#### `PurchasingController`
- Unified resource controller for purchase-orders, goods-receipts, vendor-bills, supplier-payments
- Authorization via `authorize()` with dynamic permission names (`{resource}.{action}`)
- Auto-numbering: `PO-YYYY-MM-####`, `GR-YYYY-MM-####`, `BILL-YYYY-MM-####`, `PAY-S-YYYY-MM-####`
- Transaction support for lines (purchase-orders, goods-receipts, vendor-bills)
- Line items: create calculates `subtotal = qty * unit_price` (or `amount` for vendor-bills)
- Update: deletes old lines, creates fresh set, recalculates `total_amount` from `lines.sum('subtotal')`
- Eager loading: `with()` includes supplier, warehouse, creator, lines.product for relevant resources

#### `SalesController`
- Unified resource controller for sales-orders, deliveries, invoices, customer-payments
- Authorization via `authorize()` with dynamic permission names
- Auto-numbering: `SO-YYYY-MM-####`, `DO-YYYY-MM-####`, `INV-YYYY-MM-####`, `PAY-C-YYYY-MM-####`
- Transaction support for lines (sales-orders, deliveries, invoices)
- Line items: create calculates `subtotal = qty * unit_price` (or `qty * unit_cost` for deliveries)
- Update: deletes old lines, creates fresh set, recalculates `total_amount` or `total_value` from `lines.sum('subtotal')`
- Eager loading: `with()` includes customer, warehouse, creator, lines.product for relevant resources

#### `MasterDataController`
- Generic resource controller for products, warehouses, partners, accounts, stock-opnames, stock-transfers
- Returns unified index view with `resource` variable for modal wiring

#### `StockBalanceController`
- Dedicated CRUD for stock_balances
- Permission-gated: stock.view, stock.create, stock.update, stock.delete

### Validation Rules

#### Purchase Orders
- `number`: nullable (auto-generated), string, max 40, unique
- `order_date`: required, date
- `supplier_id`: required, exists:partners
- `warehouse_id`: required, exists:warehouses
- `total_amount`: required, numeric, min:0
- `status`: required, in:draft,confirmed,partial,completed,cancelled
- `lines`: required, array, min:1
- `lines.*.product_id`: required, exists:products
- `lines.*.qty`: required, numeric, min:0.001
- `lines.*.unit`: required, string, max:20
- `lines.*.unit_price`: required, numeric, min:0

#### Goods Receipts
- Similar to PO, `total_value` instead of `total_amount`, `lines.*.unit_cost` instead of `unit_price`
- `status`: draft/posted/reversed

#### Vendor Bills
- `lines.*.product_id`: nullable
- `lines.*.description`: required, string
- `lines.*.amount`: required, numeric, min:0
- No qty/unit fields

#### Sales Orders
- Same structure as Purchase Orders, `customer_id` instead of `supplier_id`

#### Deliveries
- Same structure as Goods Receipts, `customer_id` + `sales_order_id` (nullable)

#### Invoices
- `lines.*.product_id`: nullable
- `lines.*.description`: required
- `lines.*.qty`: required, numeric, min:0.001
- `lines.*.unit_price`: required, numeric, min:0
- `status`: open/partial/paid/overdue/reversed

#### Payments (Supplier/Customer)
- No lines
- `method`: transfer/cash/check
- `status`: draft/posted/reversed

### Transactions

All document creation/updates with lines wrapped in `DB::transaction()`:
1. Create/update header record
2. For create: insert lines via `$item->lines()->create($line)`
3. For update: delete old lines (`$item->lines()->delete()`), insert fresh set
4. Recalculate header total: `$item->update(['total_amount' => $item->lines()->sum('subtotal')])`

### Auto-numbering Algorithm

```
PREFIX-YYYY-MM-####
```

Logic (per resource):
1. Query `whereYear(created_at, $year)->whereMonth(created_at, $month)->orderBy('id', 'desc')->value('number')`
2. Extract last sequence via regex `/-(\\d+)$/`
3. Increment sequence (default 1 if no match)
4. Return `sprintf('%s-%s-%s-%04d', $prefix, $year, $month, $seq)`

## Features Status

### ✅ Implemented

- **Master Data CRUD**: Products, Warehouses, Partners, Accounts
- **Stock Balances**: Full CRUD with permissions
- **Stock Opname**: Resource wired, modal CRUD via MasterDataController
- **Stock Transfers**: Resource wired, modal CRUD via MasterDataController
- **Purchase Orders**: Full CRUD with lines, auto-numbering, validation, transaction support
- **Goods Receipts**: Full CRUD with lines, auto-numbering, validation, transaction support
- **Vendor Bills**: Full CRUD with description lines (no qty/unit), auto-numbering
- **Supplier Payments**: Full CRUD, auto-numbering
- **Sales Orders**: Full CRUD with lines, auto-numbering, validation, transaction support
- **Deliveries**: Full CRUD with lines, auto-numbering, validation, transaction support
- **Invoices**: Full CRUD with lines (description + qty + unit_price), auto-numbering
- **Customer Payments**: Full CRUD, auto-numbering
- **Authentication**: Login/logout
- **Authorization**: Spatie Permission integration, permission gates on routes
- **User Management**: CRUD for users with role assignment
- **Role Management**: CRUD for roles with permission assignment
- **Dashboard**: Basic landing page

### 🚧 Pending Implementation

- **Accounting Module UI**: Journal entries, ledger, periods (routes exist, views stubbed)
- **Reports UI**: Trial balance, income statement, aging, inventory valuation (routes exist, views stubbed)
- **Dashboard Analytics**: Charts, KPIs (page exists but minimal content)
- **Stock Movement Posting**: Opname/transfer posting logic (status transitions exist but no inventory impact)
- **Journal Entry Auto-creation**: Link purchasing/sales documents to journal entries
- **Document Status Transitions**: Confirm PO → posted GR → open Bill → posted Payment workflows
- **Invoice Due Date Tracking**: Overdue status automation
- **Partial Status Logic**: PO partial vs completed based on GR, SO partial vs completed based on DO

## UI Patterns

### Layout
- `resources/views/layouts/app.blade.php`: Collapsible sidebar, top navbar with user menu
- Sidebar: grouped by module (Master Data, Inventory, Purchasing, Sales, Accounting, Reports, System)
- Tailwind CSS via CDN, Boxicons for icons

### CRUD Modals
- Shared modal component pattern in each resource view
- Modal script: `openModal(mode, item)` (mode: 'create' or 'edit')
- Form: `getFormFields(resource, item)` generates modal HTML
- Submit: `submitForm()` collects data, calls appropriate endpoint (POST or PUT)
- Table: actions column with view/edit/delete buttons
- Pagination via Laravel `{{ $items->links() }}`

### Lines Editor (Documents)
- Product lines: table with columns `[Product Select, Qty, Unit, Unit Price, Subtotal, Delete]`
- Description lines (vendor bills, invoices): `[Description (colspan), Amount, Delete]`
- `addLine()`: appends row to tbody
- `calcSubtotal(row)`: recalculates `qty * price` per row
- `updateTotal()`: sums all subtotals, updates header total display
- `submitForm()`: collects lines as array, sends to controller

### Auto-numbering UX
- Number field: optional input (auto-generated if left blank)
- On submit: server generates if `empty($validated['number'])`
- Response: returns full item with generated number

### Status Badges
- Draft: gray
- Confirmed/Posted: green
- Partial: yellow
- Completed/Paid: blue
- Cancelled/Reversed: red
- Overdue: orange

### Permissions
- Resource-based: `{resource}.{action}` (view, create, update, delete)
- Middleware: `->middleware('can:{permission}')`
- Blade: `@can('{permission}')` for conditional rendering

## Technical Notes

### Foreign Key Constraints
- Cascade on delete for line items: `->constrained()->cascadeOnDelete()`
- Null on delete for optional parent refs: `->constrained()->nullOnDelete()`
- Standard constrain for master data refs: `->constrained('{table}')`

### Soft Deletes
- All document headers use `softDeletes()` (PO, GR, Bills, SO, DO, Invoices, Payments, Opnames, Transfers, Journal Entries)
- Line items: hard delete (cascade handles cleanup)

### Eager Loading
- `with()` method in controllers loads related models to avoid N+1
- Format: `'supplier:id,code,name'` for partial column selection
- Nested: `'lines.product:id,sku,name'` for line items with product details

### Date Handling
- All date fields: `'required|date'` validation, stored as `DATE` type
- Timestamp fields: `posted_at`, `confirmed_at` (nullable, updated on status transitions)

### Decimal Precision
- Amounts: `decimal(15, 2)` (currency)
- Quantities: `decimal(15, 3)` (supports fractional units)

### Unique Constraints
- Document numbers: unique per table
- Master data codes: unique per table
- Stock balance: composite unique `[product_id, warehouse_id]`

## File Structure

```
app/
├── Http/Controllers/
│   ├── AuthController.php
│   ├── MasterDataController.php
│   ├── PurchasingController.php
│   ├── SalesController.php
│   ├── StockBalanceController.php
│   └── System/
│       ├── UserController.php
│       └── RoleController.php
├── Models/
│   ├── Product.php, Warehouse.php, Partner.php, Account.php
│   ├── StockBalance.php, StockOpname.php, StockOpnameItem.php
│   ├── StockTransfer.php, StockTransferItem.php
│   ├── PurchaseOrder.php, PurchaseOrderLine.php
│   ├── GoodsReceipt.php, GoodsReceiptLine.php
│   ├── VendorBill.php, VendorBillLine.php
│   ├── SupplierPayment.php
│   ├── SalesOrder.php, SalesOrderLine.php
│   ├── Delivery.php, DeliveryLine.php
│   ├── Invoice.php, InvoiceLine.php
│   ├── CustomerPayment.php
│   ├── JournalEntry.php, JournalLine.php
│   └── User.php
database/migrations/
├── 2026_10_08_102849_create_master_data_tables.php
├── 2026_10_08_120000_create_inventory_tables.php
├── 2026_10_08_130000_create_purchasing_tables.php
├── 2026_10_08_140000_create_sales_tables.php
├── 2026_10_09_155821_create_journal_tables.php
└── 2026_10_10_000001_create_document_lines_tables.php
resources/views/
├── layouts/app.blade.php
├── dashboard/index.blade.php
├── master-data/
│   ├── products.blade.php
│   ├── warehouses.blade.php
│   ├── partners.blade.php
│   └── accounts.blade.php
├── inventory/
│   ├── stock.blade.php
│   ├── opname.blade.php
│   └── transfers.blade.php
├── purchasing/
│   ├── orders.blade.php
│   ├── receipts.blade.php
│   ├── bills.blade.php
│   └── payments.blade.php
├── sales/
│   ├── orders.blade.php
│   ├── deliveries.blade.php
│   ├── invoices.blade.php
│   └── payments.blade.php
├── accounting/
│   ├── journals.blade.php
│   ├── ledger.blade.php
│   └── periods.blade.php
├── reports/
│   ├── trial-balance.blade.php
│   ├── income-statement.blade.php
│   ├── aging.blade.php
│   └── inventory-valuation.blade.php
└── system/
    ├── users/
    │   ├── index.blade.php
    │   └── form.blade.php
    └── roles/
        ├── index.blade.php
        └── form.blade.php
routes/web.php
```

## Known Issues / Tech Debt

None blocking. System operational for basic ERP workflows (create master data, create PO with lines, receive goods, create bills, make payments, same for sales cycle).

Accounting & reports views are stubbed (routes exist, no UI implementation yet).

## Next Phase Recommendations

1. **Dashboard Analytics**: Real KPIs (total PO value, pending receipts, unpaid invoices, low stock alerts)
2. **Accounting Wiring**: Auto-create journal entries on document posting (GR → inventory debit + AP credit, DO → COGS debit + inventory credit, etc.)
3. **Status Transition Logic**: Implement partial/completed calculation based on child documents
4. **Stock Posting**: Opname/transfer posting updates stock_balances
5. **Report Queries**: Implement actual SQL queries for trial balance, income statement, aging, inventory valuation
6. **Invoice Overdue Automation**: Cron job or query-time logic for overdue status
7. **Document Linking UI**: Dropdown to select parent document (create GR from PO, create Bill from GR, etc.)
8. **Audit Log**: Track who changed what when (separate audit_logs table or use Laravel Auditing package)

---

**End of Specification**

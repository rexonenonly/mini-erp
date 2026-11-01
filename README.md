# Mini ERP

Lightweight ERP for small businesses. Sales, Purchasing, Inventory, Accounting. Built with Laravel 13.

## Stack

- **Backend**: Laravel 13, PHP 8.3
- **Frontend**: Blade, Tailwind CSS, Boxicons, Chart.js
- **Testing**: Pest

## Quick Start

### Docker

```bash
git clone https://github.com/rexonenonly/mini-erp.git
cd mini-erp
docker-compose up -d
docker-compose exec app php artisan migrate --seed
```

Access: http://localhost:8080

### Local Dev

Requirements: PHP 8.3+, Composer

```bash
git clone https://github.com/rexonenonly/mini-erp.git
cd mini-erp
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

## Modules

- **Sales** — Orders → Invoices → Deliveries → Payments
- **Purchasing** — POs → Goods Receipts → Bills → Payments
- **Inventory** — Stock Balances, Movements, Transfers, Opname
- **Accounting** — Chart of Accounts, Journal Entries, Trial Balance, General Ledger, PDF Export
- **Master Data** — Customers, Suppliers, Products, Warehouses

## Testing

```bash
vendor/bin/pest
```

## Status

- ✅ Phase 1: Accounting, Ledger, Trial Balance, PDF Export
- 🚧 Phase 2+: Feature expansion & UI refinement

## License

MIT

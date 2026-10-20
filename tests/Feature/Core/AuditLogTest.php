<?php

use App\Domain\Core\Traits\Auditable;
use App\Models\AuditLog;
use App\Models\Partner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\QueryException;

uses(RefreshDatabase::class);

test('auditable model records create and update changes', function () {
    $partner = Partner::create([
        'code' => 'AUD-1', 'name' => 'Before', 'type' => 'customer', 'email' => 'a@example.com',
    ]);

    $created = AuditLog::where('auditable_type', Partner::class)
        ->where('auditable_id', $partner->id)->where('event', 'created')->firstOrFail();
    expect($created->new_values['name'])->toBe('Before');

    $partner->update(['name' => 'After']);
    $updated = AuditLog::where('auditable_type', Partner::class)
        ->where('auditable_id', $partner->id)->where('event', 'updated')->firstOrFail();
    expect($updated->old_values['name'])->toBe('Before')
        ->and($updated->new_values['name'])->toBe('After');
});

test('audit_logs rejects update and delete', function () {
    $partner = Partner::create([
        'code' => 'AUD-2', 'name' => 'Immutable', 'type' => 'customer', 'email' => 'b@example.com',
    ]);
    $log = AuditLog::where('auditable_id', $partner->id)->firstOrFail();

    expect(fn () => DB::table('audit_logs')->where('id', $log->id)->update(['event' => 'tampered']))
        ->toThrow(QueryException::class);
    expect(fn () => DB::table('audit_logs')->where('id', $log->id)->delete())
        ->toThrow(QueryException::class);
});

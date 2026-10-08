<?php
namespace Tests\Feature\Auth;
use Tests\TestCase;
class SeederTest extends TestCase
{
    public function test_seeder_is_idempotent(): void
    {
        $this->artisan('db:seed', ['--class'=>'Database\Seeders\RolePermissionSeeder'])->assertSuccessful();
        $count1 = \Spatie\Permission\Models\Permission::count();
        $this->artisan('db:seed', ['--class'=>'Database\Seeders\RolePermissionSeeder'])->assertSuccessful();
        $count2 = \Spatie\Permission\Models\Permission::count();
        $this->assertSame($count1, $count2);
    }
}

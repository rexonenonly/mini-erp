<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/**
 * Feature test case: uses real PostgreSQL DB.
 * Unit tests use the default SQLite in-memory.
 */
abstract class FeatureTestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Use pgsql for feature tests (triggers require it)
        config(['database.default' => 'pgsql']);
    }
}

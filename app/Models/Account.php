<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = ['code', 'name', 'type', 'balance', 'is_active'];
    protected $casts = ['is_active' => 'boolean', 'balance' => 'decimal:2'];
}

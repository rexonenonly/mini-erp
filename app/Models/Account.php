<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = ['code', 'name', 'type', 'normal_balance', 'system_key', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];
}

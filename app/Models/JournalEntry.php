<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JournalEntry extends Model
{
    use SoftDeletes;

    protected $fillable = ['number', 'entry_date', 'source_type', 'source_id', 'description', 'status', 'created_by', 'posted_at'];

    protected $casts = ['entry_date' => 'date', 'posted_at' => 'datetime'];

    public function lines() { return $this->hasMany(JournalLine::class); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
}

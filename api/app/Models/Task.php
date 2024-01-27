<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    public $guarded = [];

    public function scopeStatus($query, $value)
    {
        $query->where('status', $value);
    }

}

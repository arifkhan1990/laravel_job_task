<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'category', 'due_date'
    ];

    protected $casts = [
        'is_done' => 'boolean',
        'due_date' => 'date'
    ];

    protected $hidden = [
        'updated_at'
    ];
}

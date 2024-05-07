<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'category', 'due_date', 'created_by', 'is_done'
    ];

    protected $casts = [
        'is_done' => 'boolean',
        'due_date' => 'date'
    ];

    protected $hidden = [
        'updated_at'
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public static function booted(): void
    {
        static::addGlobalScope('creator', function (Builder $builder) {
            $builder->where('created_by', Auth::id());
        });
    }
}

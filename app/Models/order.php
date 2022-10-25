<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'table_id',
        'menu_id',
        'item_id',
        'price',
        'quantity',
        'total',
        'status',
        'description',
        'discount',
        'user_id'
    ];

    public function Item(): BelongsTo
    {
        return $this->belongsTo(item::class);
    }

    // over riding orm to insert user id by default
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->user_id = auth()->id();
        });
    }
}

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
        'user_id',
        'token',
        'rcv_amount',
        'refund',
        'paid_at',
        'paid_amount'
    ];

    public function Item(): BelongsTo
    {
        return $this->belongsTo(item::class);
    }

    public function Table(): BelongsTo
    {
        return $this->belongsTo(table::class);
    }

    public function Menu(): BelongsTo
    {
        return $this->belongsTo(menu::class);
    }

    // over riding orm to insert user id by default
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->user_id = auth()->id();
            $model->paid_at = now();
        });
    }
}

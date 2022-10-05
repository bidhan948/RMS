<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class item extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['menu_id', 'name', 'discount', 'price', 'user_id', 'status','description'];

    public function Menu(): BelongsTo
    {
        return $this->belongsTo(menu::class);
    }

    // over riding orm to insert user id by default
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->user_id = auth()->id();
        });
    }
}

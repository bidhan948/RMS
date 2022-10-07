<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class discount extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['menu_id', 'discount', 'is_flat', 'description','d_from','d_to'];

    public function Menu(): BelongsTo
    {
        return $this->belongsTo(menu::class);
    }
}

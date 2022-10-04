<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class menu extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'image'];

    public function Items(): HasMany
    {
        return $this->hasMany(item::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'stock_quantity',
        'image',
        'is_active',
        'created_at',
    ];

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'stock_quantity' => 'integer',
            'is_active' => 'boolean',
            'created_at' => 'datetime',
        ];
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }
}

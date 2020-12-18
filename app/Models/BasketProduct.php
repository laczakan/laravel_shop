<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasketProduct extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'basket_id',
        'quantity',
    ];

    /**
     * Basket product belongs to product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Casts\MoneyIntegerCast;

class Product extends Model
{
    use HasFactory;

    protected $casts = [
        'price' => MoneyIntegerCast::class . ':GBP',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

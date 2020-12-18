<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    use HasFactory;

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
    ];

    /**
     * Basket belongs to user
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Basket has many basket products
     */
    public function basketProducts()
    {
        return $this->hasMany(BasketProduct::class);
    }

}

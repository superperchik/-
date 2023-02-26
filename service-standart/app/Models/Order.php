<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'user_id'
    ];

    public function products()
    {
        return $this->hasMany(ProductOrder::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getIdPositions()
    {
        return $this->products->map(function ($item) {
            return $item->product_id;
        })->all();
    }

    public function getPrice()
    {
        return $this->products->reduce(function ($sum, $item) {
            return $sum + $item->price;
        });
    }
}

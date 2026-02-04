<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    protected $fillable = [
        'order_id',
        'product_id', // OJO: aquí guarda el ID de product_offers
        'quantity'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // product_orders.product_id -> product_offers.id
    public function productOffer()
    {
        return $this->belongsTo(ProductOffer::class, 'product_id');
    }
}

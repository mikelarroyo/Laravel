<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOffer extends Model
{
    protected $fillable = [
        'offer_id',
        'product_id',
        'price'
    ];

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // product_orders.product_id -> product_offers.id
    public function productsOrder()
    {
        return $this->hasMany(ProductOrder::class, 'product_id');
    }
}

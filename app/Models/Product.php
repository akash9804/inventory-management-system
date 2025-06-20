<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'sku', 'price', 'quantity'];
    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
    ];
    /**
     * Get the sales order items associated with the product.
     */
    public function salesOrderItems()
    {
        return $this->hasMany(SalesOrderItem::class);
    }
    /**
     * Get the sales orders associated with the product.
     */
    public function salesOrders()
    {
        return $this->hasManyThrough(SalesOrder::class, SalesOrderItem::class);
    }
    /**
     * Get the stock value of the product.
     */
    public function getStockValueAttribute()
    {
        return $this->price * $this->quantity;
    }
}

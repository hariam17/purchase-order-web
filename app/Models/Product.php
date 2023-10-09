<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    function PurchaseOrderLines(){
        return $this->hasMany(PurchaseOrderLine::class);
    }

    protected $fillable = [
        'product_name', 'product_code', 'price', 'created_at', 'updated_at'
    ];
}

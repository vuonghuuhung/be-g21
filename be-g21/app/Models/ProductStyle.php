<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStyle extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'style_name', 'image', 'standard_price', 'fixed_price', 'stock', 'status'];
}

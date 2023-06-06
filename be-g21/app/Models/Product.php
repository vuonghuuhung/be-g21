<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['status', 'product_name', 'category_id', 'description', 'image'];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function colors()
    {
        return $this->hasMany('App\Models\ProductColor');
    }

    public function styles()
    {
        return $this->hasMany('App\Models\ProductStyle');
    }
}

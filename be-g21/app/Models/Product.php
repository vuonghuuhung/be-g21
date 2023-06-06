<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['status'];

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

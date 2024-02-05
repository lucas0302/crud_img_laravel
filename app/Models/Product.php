<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name','detail'];

    public function product()
{
    return $this->belongsTo(Product::class, 'product_id');
}
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_img extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'image_path'];

    // Relacionamento muitos para um com a tabela products
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

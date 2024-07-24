<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'product_category_id',
        'product_name',	
        'description',
        'price',	
    ];

    public function productCat(){
        return $this->belongsTo(Product_categorie::class, 'product_category_id');
    }
}

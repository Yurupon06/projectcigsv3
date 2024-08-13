<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $table = 'members';
    protected $fillable = [
        'customer_id',
        'start_date',	
        'end_date',
        'status',	
        'qr_token',	
    ];

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function product_categorie()
    {
        return $this->belongsTo(Product_categorie::class, 'product_category_id');
    }
}


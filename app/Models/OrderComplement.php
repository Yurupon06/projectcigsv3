<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderComplement extends Model
{
    use HasFactory;
    protected $table = 'order_complements';
    protected $fillable = [
        'user_id',
        'total_amount',	
        'status',
        'quantity',
        'qr_token',	
    ];

/*************  ✨ Codeium Command ⭐  *************/
    /**
     * Get the user that owns the OrderComplement
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
/******  5b782275-4a8e-4ef3-9c6f-30852dd5ef3b  *******/    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

}

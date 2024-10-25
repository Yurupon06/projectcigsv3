<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';
    protected $fillable = [
        'user_id',
        'phone',	
        'born',	
        'gender',	
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }


    public function activeMember()
    {
        return $this->hasOne(Member::class, 'customer_id')->where('status', 'active');
    }
    public function member()
    {
        return $this->hasOne(Member::class, 'customer_id'); // Atau `hasMany` jika ada banyak data member
    }

    // Relasi ke tabel orders
    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }
}

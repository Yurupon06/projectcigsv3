<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodeOtp extends Model
{
    use HasFactory;
    protected $table = 'code_otps';
    protected $fillable = [
        'phone',
        'otp'
    ];
}

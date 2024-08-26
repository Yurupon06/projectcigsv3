<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberCheckin extends Model
{
    use HasFactory;
    protected $table = 'member_checkins';
    protected $fillable = [
        'member_id',
        'qr_token',
        'image',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}

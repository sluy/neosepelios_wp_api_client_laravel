<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instance extends Model
{
    use HasFactory;

    protected $fillable = [
        'instance_id',
        'instance_secret',
        'name',
        'last_qrcode'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}

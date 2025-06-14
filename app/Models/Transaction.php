<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'frame_id',
        'email',
        'amount',
        'payment_proof',
        'status',
        'is_used',
        'is_download',
        'approved_at' // Tambahkan ini
    ];

    protected $casts = [
        'is_used' => 'boolean',
        'is_download' => 'boolean',
        'approved_at' => 'datetime'
    ];

    public function frame()
    {
        return $this->belongsTo(Frame::class);
    }

    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }
}

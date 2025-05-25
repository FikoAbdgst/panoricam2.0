<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    use HasFactory;

    protected $fillable = [
        'rating',
        'emoji',
        'name',
        'message',
        'frame_id'
    ];

    protected $casts = [
        'rating' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship dengan Frame (jika ada)
    public function frame()
    {
        return $this->belongsTo(Frame::class);
    }

    // Scope untuk filter berdasarkan rating
    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    // Scope untuk testimoni terbaru
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}

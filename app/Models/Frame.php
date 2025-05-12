<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Frame extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'image_path',
        'status', // Added status field
    ];

    // Define constants for status
    const STATUS_FREE = 'free';
    const STATUS_PAID = 'paid';

    // Get available status options
    public static function getStatusOptions()
    {
        return [
            self::STATUS_FREE => 'Gratis',
            self::STATUS_PAID => 'Berbayar',
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getTemplatePath()
    {
        $templatePath = 'admin.frames.templates.' . $this->slug;

        // Check if the view exists
        if (view()->exists($templatePath)) {
            return $templatePath;
        }

        return 'admin.frames.templates.default';
    }

    // Helper method to check if frame is free
    public function isFree()
    {
        return $this->status === self::STATUS_FREE;
    }
    public function templateExists()
    {
        $templatePath = resource_path('views/admin/frames/templates/' . $this->slug . '.blade.php');
        return file_exists($templatePath);
    }
}

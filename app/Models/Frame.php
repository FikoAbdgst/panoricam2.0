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
    ];

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
}

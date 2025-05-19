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
        'price',
        'used', // Add used to fillable
    ];


    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }


    public function isFree()
    {
        return $this->price == 0;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getTemplatePath()
    {
        $templatePath = 'admin.frames.templates.' . $this->slug;

        if (view()->exists($templatePath)) {
            return $templatePath;
        }

        return 'admin.frames.templates.default';
    }

    public function templateExists()
    {
        $templatePath = resource_path('views/admin/frames/templates/' . $this->slug . '.blade.php');
        return file_exists($templatePath);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Frame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class FrameTempController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $topFrames = Frame::with('category')->orderBy('used', 'desc')->take(3)->get();

        // Base query dengan eager loading testimoni untuk menghitung rating
        $query = Frame::with(['category', 'testimonis'])
            ->withAvg('testimonis', 'rating');

        // Filter berdasarkan kategori
        if ($request->has('category') && $request->category) {
            $categoryId = $request->query('category');
            $selectedCategory = Category::find($categoryId);

            if ($selectedCategory) {
                $query->where('category_id', $categoryId);
            }
        } else {
            $selectedCategory = null;
        }

        // Filter berdasarkan rating (sorting)
        $sortBy = $request->query('sort_rating', null);
        if ($sortBy === 'asc') {
            // Rating terendah ke tertinggi (null values last)
            $query->orderByRaw('testimonis_avg_rating IS NULL, testimonis_avg_rating ASC');
        } elseif ($sortBy === 'desc') {
            // Rating tertinggi ke terendah (null values last)
            $query->orderByRaw('testimonis_avg_rating IS NULL, testimonis_avg_rating DESC');
        } else {
            // Default sorting (bisa berdasarkan created_at atau yang lain)
            $query->orderBy('created_at', 'desc');
        }

        $frames = $query->get();

        // Jika request AJAX, return partial view
        if ($request->ajax()) {
            return view('frame', compact('categories', 'frames', 'selectedCategory', 'topFrames'))->render();
        }

        return view('frame', compact('categories', 'frames', 'selectedCategory', 'topFrames'));
    }

    public function getFrameTemplate(Request $request, $frameId)
    {
        $frame = Frame::findOrFail($frameId);

        // Check if template exists, otherwise use default
        $templateSlug = $frame->slug;
        $templatePath = 'admin.frames.templates.' . $templateSlug;

        // Check if the view exists
        if (!view()->exists($templatePath)) {
            // Use default template and log a warning
            Log::warning("Frame template not found: {$templatePath}. Using default template instead.");
            $templatePath = 'admin.frames.templates.default';
        }

        // Return the rendered view
        return view($templatePath, compact('frame'))->render();
    }

    public function getFrameStatus(Request $request, $frameId)
    {
        $frame = Frame::findOrFail($frameId);

        return response()->json([
            'id' => $frame->id,
            'price' => $frame->price,
            'formatted_price' => $frame->formatted_price,
            'isFree' => $frame->isFree()
        ]);
    }
}

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
        $topFrames = Frame::with('category')->orderBy('used', 'desc')->take(3)->get(); // Ambil 3 frame dengan used terbanyak

        if ($request->has('category')) {
            $categoryId = $request->query('category');
            $selectedCategory = Category::find($categoryId);

            if ($selectedCategory) {
                $frames = Frame::with('category')->where('category_id', $categoryId)->get();
                return view('frame', compact('categories', 'frames', 'selectedCategory', 'topFrames'));
            }
        }

        $frames = Frame::with('category')->get();
        return view('frame', compact('categories', 'frames', 'topFrames'));
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

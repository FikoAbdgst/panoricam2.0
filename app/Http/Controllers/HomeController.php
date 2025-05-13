<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Frame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        if ($request->has('category')) {
            $categoryId = $request->query('category');
            $selectedCategory = Category::find($categoryId);

            if ($selectedCategory) {
                $frames = Frame::with('category')->where('category_id', $categoryId)->get();
                return view('home', compact('categories', 'frames', 'selectedCategory'));
            }
        }

        $frames = Frame::with('category')->get();
        return view('home', compact('categories', 'frames'));
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
            'status' => $frame->status,
            'isPaid' => $frame->status === Frame::STATUS_PAID
        ]);
    }
}

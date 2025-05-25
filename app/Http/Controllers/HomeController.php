<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Frame;
use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
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
                return view('home', compact('categories', 'frames', 'selectedCategory', 'topFrames'));
            }
        }

        $frames = Frame::with('category')->get();
        return view('home', compact('categories', 'frames', 'topFrames'));
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
    public function getTestimonis(Request $request)
    {
        try {
            $query = Testimoni::query();

            // Filter berdasarkan rating jika ada
            if ($request->has('rating')) {
                $query->byRating($request->rating);
            }

            // Pagination
            $perPage = $request->get('per_page', 10);
            $testimonis = $query->latest()
                ->with('frame')
                ->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $testimonis
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data testimoni'
            ], 500);
        }
    }
    public function getTestimoniStats()
    {
        try {
            $stats = [
                'total' => Testimoni::count(),
                'average_rating' => round(Testimoni::avg('rating'), 1),
                'rating_distribution' => [
                    '5' => Testimoni::byRating(5)->count(),
                    '4' => Testimoni::byRating(4)->count(),
                    '3' => Testimoni::byRating(3)->count(),
                    '2' => Testimoni::byRating(2)->count(),
                    '1' => Testimoni::byRating(1)->count(),
                ],
                'recent_testimonis' => Testimoni::latest()
                    ->limit(5)
                    ->get(['rating', 'name', 'message', 'created_at'])
            ];

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil statistik testimoni'
            ], 500);
        }
    }
}

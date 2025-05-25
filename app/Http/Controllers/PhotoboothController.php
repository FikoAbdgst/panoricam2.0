<?php

namespace App\Http\Controllers;

use App\Models\Frame;
use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class PhotoboothController extends Controller
{
    public function index(Request $request)
    {
        $frameId = $request->query('frame_id');

        if (!$frameId) {
            return redirect()->route('home')->with('error', 'Silakan pilih frame terlebih dahulu');
        }

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

        // Pass frame data directly to the view instead of relying on @include
        return view('booth.index', compact('frame', 'templatePath'));
    }

    public function savePhoto(Request $request)
    {
        $request->validate([
            'photos' => 'required|array',
            'photos.*' => 'required|string',
            'frame_id' => 'required|exists:frames,id',
            'final_image' => 'required|string',
        ]);

        $frameId = $request->input('frame_id');
        $finalImage = $request->input('final_image');

        // Get frame information
        $frame = Frame::find($frameId);

        // Increment the 'used' field
        $frame->increment('used');

        // Return success with the base64 image data
        return response()->json([
            'success' => true,
            'message' => 'Photo processed successfully',
            'final_image' => $finalImage,
            'frame_info' => [
                'id' => $frame->id,
                'name' => $frame->name,
                'slug' => $frame->slug,
                'used' => $frame->used, // Optional: Return updated used count
            ]
        ]);
    }

    public function getFrameSlug($frameId)
    {
        $frame = Frame::findOrFail($frameId);
        return $frame->slug;
    }

    public function submitTestimoni(Request $request)
    {
        try {
            // Validasi input
            $validator = Validator::make($request->all(), [
                'rating' => 'required|integer|min:1|max:5',
                'emoji' => 'nullable|string|max:10',
                'name' => 'nullable|string|max:100',
                'message' => 'nullable|string|max:500',
                'frame_id' => 'nullable|integer|exists:frames,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak valid',
                    'errors' => $validator->errors()
                ], 400);
            }

            // Simpan testimoni
            $testimoni = Testimoni::create([
                'rating' => $request->rating,
                'emoji' => $request->emoji,
                'name' => $request->name ?: 'Anonymous',
                'message' => $request->message,
                'frame_id' => $request->frame_id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Testimoni berhasil disimpan',
                'data' => [
                    'id' => $testimoni->id,
                    'rating' => $testimoni->rating,
                    'name' => $testimoni->name
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }
}

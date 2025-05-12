<?php

namespace App\Http\Controllers;

use App\Models\Frame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

        // Return success with the base64 image data
        return response()->json([
            'success' => true,
            'message' => 'Photo processed successfully',
            'final_image' => $finalImage, // Mengembalikan data base64 langsung
            'frame_info' => [
                'id' => $frame->id,
                'name' => $frame->name,
                'slug' => $frame->slug,
            ]
        ]);
    }

    public function getFrameSlug($frameId)
    {
        $frame = Frame::findOrFail($frameId);
        return $frame->slug;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Frame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            $templatePath = 'admin.frames.templates.default';
        }

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

        $savedPhotos = [];
        $photos = $request->input('photos');
        $frameId = $request->input('frame_id');
        $finalImage = $request->input('final_image');

        // Get frame information
        $frame = Frame::find($frameId);

        // Process each individual photo
        foreach ($photos as $photoData) {
            // Clean up base64 data to get raw image data
            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $photoData));

            // Generate a unique filename
            $filename = 'photos/' . uniqid() . '.jpg';

            // Save to storage
            Storage::disk('public')->put($filename, $imageData);

            $savedPhotos[] = $filename;
        }

        // Save the final composite image that includes the frame template
        $finalImageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $finalImage));
        $finalImagePath = 'photos/final_' . uniqid() . '.jpg';
        Storage::disk('public')->put($finalImagePath, $finalImageData);

        // Return success with the stored image paths
        return response()->json([
            'success' => true,
            'message' => 'Photos saved successfully',
            'image_paths' => $savedPhotos,
            'final_image_path' => $finalImagePath,
            'download_url' => asset('storage/' . $finalImagePath)
        ]);
    }

    public function getFrameSlug($frameId)
    {
        $frame = Frame::findOrFail($frameId);
        return $frame->slug;
    }
}

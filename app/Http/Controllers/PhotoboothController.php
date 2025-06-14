<?php

namespace App\Http\Controllers;

use App\Models\Frame;
use App\Models\Testimoni;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class PhotoboothController extends Controller
{
    public function index(Request $request)
    {
        $frameId = $request->query('frame_id');
        $orderId = $request->query('order_id');

        if (!$frameId) {
            return redirect()->route('home')->with('error', 'Silakan pilih frame terlebih dahulu');
        }

        $frame = Frame::findOrFail($frameId);
        $isDownloaded = false; // Default untuk frame gratis

        // Check if this is a premium frame and requires payment
        if (!$frame->isFree()) {
            if (!$orderId) {
                return redirect()->route('frametemp')->with('error', 'Frame premium memerlukan pembayaran');
            }

            // Verify transaction
            $transaction = Transaction::where('order_id', $orderId)
                ->where('frame_id', $frameId)
                ->where('status', 'approved')
                ->first();

            if (!$transaction) {
                return redirect()->route('frametemp')->with('error', 'Transaksi tidak valid atau belum disetujui');
            }

            // Check if already used
            if ($transaction->is_used) {
                return redirect()->route('frametemp')->with('error', 'Link sudah pernah digunakan');
            }

            // Check if already downloaded
            $isDownloaded = $transaction->is_download;

            // Mark as used jika belum di-download
            if (!$isDownloaded) {
                $transaction->update(['is_used' => true]);
            }
        }

        // Check if template exists, otherwise use default
        $templateSlug = $frame->slug;
        $templatePath = 'admin.frames.templates.' . $templateSlug;

        // Check if the view exists
        if (!view()->exists($templatePath)) {
            // Use default template and log a warning
            Log::warning("Frame template not found: {$templatePath}. Using default template instead.");
            $templatePath = 'admin.frames.templates.default';
        }

        // Pass frame data and download status to the view
        return view('booth.index', compact('frame', 'templatePath', 'isDownloaded', 'orderId'));
    }

    public function savePhoto(Request $request)
    {
        $request->validate([
            'photos' => 'required|array',
            'photos.*' => 'required|string',
            'frame_id' => 'required|exists:frames,id',
            'final_image' => 'required|string',
            'order_id' => 'nullable|string'
        ]);

        $frameId = $request->input('frame_id');
        $finalImage = $request->input('final_image');
        $orderId = $request->input('order_id');

        // Get frame information
        $frame = Frame::find($frameId);

        // If premium frame, mark download as true
        if (!$frame->isFree() && $orderId) {
            $transaction = Transaction::where('order_id', $orderId)->first();
            if ($transaction) {
                $transaction->update(['is_download' => true]);
            }
        }

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
                'used' => $frame->used,
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

    public function resetUsedStatus(Request $request)
    {
        try {
            $request->validate([
                'order_id' => 'required|string'
            ]);

            $transaction = Transaction::where('order_id', $request->order_id)
                ->where('status', 'approved')
                ->first();

            // Tidak bisa reset jika sudah di-download
            if ($transaction && $transaction->is_used && !$transaction->is_download) {
                $transaction->update(['is_used' => false]);

                Log::info("Reset is_used for order_id: {$request->order_id}");

                return response()->json([
                    'success' => true,
                    'message' => 'Status berhasil direset'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Tidak perlu reset atau sudah di-download'
            ]);
        } catch (\Exception $e) {
            Log::error('Error resetting used status: ' . $e->getMessage());
            return response()->json(['success' => false], 500);
        }
    }

    // Method baru untuk cek status download
    public function checkDownloadStatus(Request $request)
    {
        try {
            $orderId = $request->query('order_id');

            if (!$orderId) {
                return response()->json([
                    'success' => true,
                    'is_downloaded' => false
                ]);
            }

            $transaction = Transaction::where('order_id', $orderId)
                ->where('status', 'approved')
                ->first();

            return response()->json([
                'success' => true,
                'is_downloaded' => $transaction ? $transaction->is_download : false
            ]);
        } catch (\Exception $e) {
            Log::error('Error checking download status: ' . $e->getMessage());
            return response()->json(['success' => false], 500);
        }
    }
}

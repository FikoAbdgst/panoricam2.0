<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Frame;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FrameController extends Controller
{
    private function checkAdminAuth()
    {
        if (!session()->has('admin_id')) {
            return false;
        }
        return true;
    }

    public function index()
    {
        if (!$this->checkAdminAuth()) {
            return redirect()->route('admin.login');
        }

        $frames = Frame::with('category')->get();
        return view('admin.frames.index', compact('frames'));
    }

    public function create()
    {
        if (!$this->checkAdminAuth()) {
            return redirect()->route('admin.login');
        }

        $categories = Category::all();
        return view('admin.frames.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if (!$this->checkAdminAuth()) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:frames,slug',
            'category_id' => 'required|exists:categories,id',
            'frame_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0', // Changed from status to price
        ]);

        DB::beginTransaction();

        try {
            $imagePath = null;
            if ($request->hasFile('frame_image')) {
                $imagePath = $request->file('frame_image')->store('frames', 'public');
            }

            // Create the frame
            Frame::create([
                'name' => $request->name,
                'slug' => $request->slug ?? Str::slug($request->name),
                'category_id' => $request->category_id,
                'image_path' => $imagePath,
                'price' => $request->price, // Changed from status to price
            ]);

            DB::commit();

            return redirect()->route('admin.frames.index')
                ->with('success', 'Frame berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }


    public function show(Frame $frame)
    {
        if (!$this->checkAdminAuth()) {
            return redirect()->route('admin.login');
        }

        return view('admin.frames.show', compact('frame'));
    }

    public function edit(Frame $frame)
    {
        if (!$this->checkAdminAuth()) {
            return redirect()->route('admin.login');
        }

        $categories = Category::all();
        return view('admin.frames.edit', compact('frame', 'categories'));
    }

    public function update(Request $request, Frame $frame)
    {
        if (!$this->checkAdminAuth()) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:frames,slug,' . $frame->id,
            'category_id' => 'required|exists:categories,id',
            'frame_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0', // Changed from status to price
        ]);

        DB::beginTransaction();

        try {
            $data = [
                'name' => $request->name,
                'slug' => $request->slug ?? Str::slug($request->name),
                'category_id' => $request->category_id,
                'price' => $request->price, // Changed from status to price
            ];

            // Update image if provided
            if ($request->hasFile('frame_image')) {
                // Delete old image if exists
                if ($frame->image_path) {
                    Storage::disk('public')->delete($frame->image_path);
                }

                $data['image_path'] = $request->file('frame_image')->store('frames', 'public');
            }

            // Update frame
            $frame->update($data);

            DB::commit();

            return redirect()->route('admin.frames.index')
                ->with('success', 'Frame berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function destroy(Frame $frame)
    {
        if (!$this->checkAdminAuth()) {
            return redirect()->route('admin.login');
        }

        DB::beginTransaction();

        try {
            // Delete image if exists
            if ($frame->image_path) {
                Storage::disk('public')->delete($frame->image_path);
            }

            // Delete the frame
            $frame->delete();

            DB::commit();

            return redirect()->route('admin.frames.index')
                ->with('success', 'Frame berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}

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
            'status' => 'required|in:free,paid', // Add status validation
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
                'status' => $request->status, // Add status field
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
            'status' => 'required|in:free,paid', // Add status validation
        ]);

        DB::beginTransaction();

        try {
            $data = [
                'name' => $request->name,
                'slug' => $request->slug ?? Str::slug($request->name),
                'category_id' => $request->category_id,
                'status' => $request->status, // Add status field
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

    public function createTemplate(Frame $frame)
    {
        if (!$this->checkAdminAuth()) {
            return redirect()->route('admin.login');
        }

        $templatesDir = resource_path('views/admin/frames/templates');
        $templatePath = $templatesDir . '/' . $frame->slug . '.blade.php';

        // Create templates directory if it doesn't exist
        if (!file_exists($templatesDir)) {
            mkdir($templatesDir, 0755, true);
        }

        // Check if default template exists to copy from
        $defaultPath = $templatesDir . '/default.blade.php';
        if (!file_exists($defaultPath)) {
            // Create default template with basic frame
            $defaultContent = <<<HTML
            {{-- Frame Template: Default --}}
            <div class="default-frame absolute inset-0 pointer-events-none">
                {{-- Border frame --}}
                <div class="absolute inset-0 border-8 border-white rounded-lg shadow-inner"></div>
                
                {{-- Optional decorative elements --}}
                <div class="absolute top-0 left-0 w-full h-8 bg-gradient-to-r from-blue-500 to-purple-500 opacity-50"></div>
                <div class="absolute bottom-0 left-0 w-full h-8 bg-gradient-to-r from-purple-500 to-blue-500 opacity-50"></div>
                
                {{-- Frame corner decorations --}}
                <div class="absolute top-0 left-0 w-16 h-16 border-t-4 border-l-4 border-blue-500 rounded-tl-lg"></div>
                <div class="absolute top-0 right-0 w-16 h-16 border-t-4 border-r-4 border-blue-500 rounded-tr-lg"></div>
                <div class="absolute bottom-0 left-0 w-16 h-16 border-b-4 border-l-4 border-blue-500 rounded-bl-lg"></div>
                <div class="absolute bottom-0 right-0 w-16 h-16 border-b-4 border-r-4 border-blue-500 rounded-br-lg"></div>
            </div>
            HTML;
            file_put_contents($defaultPath, $defaultContent);
        }

        // Copy from default template if it doesn't already exist
        if (!file_exists($templatePath)) {
            $content = file_get_contents($defaultPath);

            // Replace default class with frame-specific class
            $content = str_replace(
                'class="default-frame',
                'class="' . $frame->slug . '-frame',
                $content
            );

            // Replace frame name
            $content = str_replace(
                'Frame Template: Default',
                'Frame Template: ' . $frame->name,
                $content
            );

            // Write the template file
            file_put_contents($templatePath, $content);

            return redirect()->route('admin.frames.index')
                ->with('success', "Template untuk '{$frame->name}' berhasil dibuat!");
        }

        return redirect()->route('admin.frames.index')
            ->with('info', "Template untuk '{$frame->name}' sudah ada!");
    }
}

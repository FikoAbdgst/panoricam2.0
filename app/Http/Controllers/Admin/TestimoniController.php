<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimoni;
use Illuminate\Http\Request;

class TestimoniController extends Controller
{
    // Untuk dashboard admin (tetap tampilkan semua testimoni)
    public function index()
    {
        $testimonis = Testimoni::latest()->get();
        return view('admin.testimoni.index', compact('testimonis'));
    }

    public function destroy($id)
    {
        $testimoni = Testimoni::findOrFail($id);
        $testimoni->delete();

        return redirect()->route('admin.testimoni.index')->with('success', 'Testimoni berhasil dihapus.');
    }
}
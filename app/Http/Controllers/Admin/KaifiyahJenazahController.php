<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KaifiyahItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KaifiyahJenazahController extends Controller
{
    /**
     * Tampilkan halaman Kaifiyah Jenazah dengan data dari database.
     */
    public function index()
    {
        $sections = [
            ['key' => 'bathing', 'title' => 'Memandikan Jenazah'],
            ['key' => 'shrouding', 'title' => 'Mengkafani Jenazah'],
            ['key' => 'prayer', 'title' => 'Mensholatkan'],
            ['key' => 'burial', 'title' => 'Mengkubur'],
        ];

        $itemsBySection = KaifiyahItem::orderBy('created_at', 'asc')->get()->groupBy('section');

        return view('admin.kaifiyah_jenazah.index', compact('sections', 'itemsBySection'));
    }

    /**
     * Simpan item baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'section' => 'required|in:bathing,shrouding,prayer,burial',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('kaifiyah', 'public');
        }

        KaifiyahItem::create([
            'section' => $validated['section'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'image_path' => $path,
        ]);

        return redirect()->route('admin.funeral.howto.index')->with('success', 'Item berhasil ditambahkan.');
    }

    /**
     * Perbarui item.
     */
    public function update(Request $request, KaifiyahItem $item)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = [
            'title' => $validated['title'],
            'description' => $validated['description'],
        ];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('kaifiyah', 'public');
            if ($item->image_path && Storage::disk('public')->exists($item->image_path)) {
                Storage::disk('public')->delete($item->image_path);
            }
            $data['image_path'] = $path;
        }

        $item->update($data);

        return redirect()->route('admin.funeral.howto.index')->with('success', 'Item berhasil diperbarui.');
    }

    /**
     * Hapus item.
     */
    public function destroy(KaifiyahItem $item)
    {
        if ($item->image_path && Storage::disk('public')->exists($item->image_path)) {
            Storage::disk('public')->delete($item->image_path);
        }

        $item->delete();

        return redirect()->route('admin.funeral.howto.index')->with('success', 'Item berhasil dihapus.');
    }

    public function create(Request $request)
    {
        $sections = [
            ['key' => 'bathing', 'title' => 'Memandikan Jenazah'],
            ['key' => 'shrouding', 'title' => 'Mengkafani Jenazah'],
            ['key' => 'prayer', 'title' => 'Mensholatkan'],
            ['key' => 'burial', 'title' => 'Mengkubur'],
        ];
        $selected = $request->query('section');
        return view('admin.kaifiyah_jenazah.create', compact('sections', 'selected'));
    }

    public function edit(KaifiyahItem $item)
    {
        $sections = [
            ['key' => 'bathing', 'title' => 'Memandikan Jenazah'],
            ['key' => 'shrouding', 'title' => 'Mengkafani Jenazah'],
            ['key' => 'prayer', 'title' => 'Mensholatkan'],
            ['key' => 'burial', 'title' => 'Mengkubur'],
        ];
        return view('admin.kaifiyah_jenazah.edit', compact('item', 'sections'));
    }
}

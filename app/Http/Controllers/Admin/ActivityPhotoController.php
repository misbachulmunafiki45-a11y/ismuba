<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ActivityPhotoController extends Controller
{
    public function index(): View
    {
        $photos = ActivityPhoto::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.foto_kegiatan.index', compact('photos'));
    }

    public function create(): View
    {
        return view('admin.foto_kegiatan.create');
    }

    public function edit(ActivityPhoto $photo): View
    {
        return view('admin.foto_kegiatan.edit', compact('photo'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            // Simpan ke storage/app/public/activity_photos
            $path = $request->file('image')->store('activity_photos', 'public');
        }

        ActivityPhoto::create([
            'image_path' => $path,
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('admin.activity.photos.index')->with('success', 'Foto kegiatan berhasil ditambahkan');
    }

    public function update(Request $request, ActivityPhoto $photo): RedirectResponse
    {
        $validated = $request->validate([
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        // Update description
        $photo->description = $validated['description'] ?? $photo->description;

        // If new image uploaded, store and remove old
        if ($request->hasFile('image')) {
            $newPath = $request->file('image')->store('activity_photos', 'public');
            // Delete old image if exists
            if ($photo->image_path && Storage::disk('public')->exists($photo->image_path)) {
                Storage::disk('public')->delete($photo->image_path);
            }
            $photo->image_path = $newPath;
        }

        $photo->save();

        return redirect()->route('admin.activity.photos.index')->with('success', 'Foto kegiatan berhasil diperbarui');
    }

    public function destroy(ActivityPhoto $photo): RedirectResponse
    {
        // Delete image file if exists
        if ($photo->image_path && Storage::disk('public')->exists($photo->image_path)) {
            Storage::disk('public')->delete($photo->image_path);
        }

        $photo->delete();

        return redirect()->route('admin.activity.photos.index')->with('success', 'Foto kegiatan berhasil dihapus');
    }
}

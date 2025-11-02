<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrayerReading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TataCaraSholatController extends Controller
{
    public function index()
    {
        $readings = PrayerReading::orderBy('id', 'asc')->get();
        return view('admin.tata_cara_sholat.index', compact('readings'));
    }

    public function create()
    {
        return view('admin.tata_cara_sholat.create');
    }

    public function edit(PrayerReading $reading)
    {
        return view('admin.tata_cara_sholat.edit', compact('reading'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'arabic' => ['nullable', 'string'],
            'latin' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('tata_cara_sholat', 'public');
        }

        $reading = PrayerReading::create([
            'title' => $data['title'],
            'arabic' => $data['arabic'] ?? '',
            'latin' => $data['latin'] ?? '',
            'description' => $data['description'] ?? null,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.prayer.howto.index')->with('status', 'Bacaan sholat berhasil ditambahkan');
    }

    public function update(Request $request, PrayerReading $reading)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'arabic' => ['nullable', 'string'],
            'latin' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $imagePath = $reading->image_path;
        if ($request->hasFile('image')) {
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('tata_cara_sholat', 'public');
        }

        $reading->update([
            'title' => $data['title'],
            'arabic' => $data['arabic'] ?? '',
            'latin' => $data['latin'] ?? '',
            'description' => $data['description'] ?? null,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.prayer.howto.index')->with('status', 'Bacaan sholat berhasil diperbarui');
    }

    public function destroy(PrayerReading $reading)
    {
        if ($reading->image_path && Storage::disk('public')->exists($reading->image_path)) {
            Storage::disk('public')->delete($reading->image_path);
        }
        $reading->delete();
        return redirect()->route('admin.prayer.howto.index')->with('status', 'Bacaan sholat berhasil dihapus');
    }
}
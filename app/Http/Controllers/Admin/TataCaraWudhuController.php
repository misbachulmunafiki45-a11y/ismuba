<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WudhuReading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TataCaraWudhuController extends Controller
{
    public function index()
    {
        $readings = WudhuReading::orderBy('id', 'asc')->get();
        return view('admin.tata_cara_wudhu.index', compact('readings'));
    }

    public function create()
    {
        return view('admin.tata_cara_wudhu.create');
    }

    public function edit(WudhuReading $reading)
    {
        return view('admin.tata_cara_wudhu.edit', compact('reading'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'arabic' => ['required', 'string'],
            'latin' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('tata_cara_wudhu', 'public');
        }

        WudhuReading::create([
            'title' => $data['title'],
            'arabic' => $data['arabic'],
            'latin' => $data['latin'],
            'description' => $data['description'] ?? null,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.wudhu.howto.index')->with('status', 'Bacaan wudhu berhasil ditambahkan');
    }

    public function update(Request $request, WudhuReading $reading)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'arabic' => ['required', 'string'],
            'latin' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $imagePath = $reading->image_path;
        if ($request->hasFile('image')) {
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('tata_cara_wudhu', 'public');
        }

        $reading->update([
            'title' => $data['title'],
            'arabic' => $data['arabic'],
            'latin' => $data['latin'],
            'description' => $data['description'] ?? null,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.wudhu.howto.index')->with('status', 'Bacaan wudhu berhasil diperbarui');
    }

    public function destroy(WudhuReading $reading)
    {
        if ($reading->image_path && Storage::disk('public')->exists($reading->image_path)) {
            Storage::disk('public')->delete($reading->image_path);
        }
        $reading->delete();
        return redirect()->route('admin.wudhu.howto.index')->with('status', 'Bacaan wudhu berhasil dihapus');
    }
}
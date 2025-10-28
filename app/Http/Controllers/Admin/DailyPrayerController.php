<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyPrayer;
use Illuminate\Http\Request;

class DailyPrayerController extends Controller
{
    public function index()
    {
        $items = DailyPrayer::orderBy('id', 'asc')->paginate(5);
        return view('admin.daily_prayers.index', compact('items'));
    }

    public function create()
    {
        return view('admin.daily_prayers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'arabic' => ['required','string'],
            'latin' => ['required','string'],
            'description' => ['nullable','string'],
        ]);

        DailyPrayer::create($data);
        return redirect()->route('admin.daily.prayers.index')->with('success', 'Doa harian berhasil ditambahkan');
    }

    public function edit(DailyPrayer $prayer)
    {
        return view('admin.daily_prayers.edit', compact('prayer'));
    }

    public function update(Request $request, DailyPrayer $prayer)
    {
        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'arabic' => ['required','string'],
            'latin' => ['required','string'],
            'description' => ['nullable','string'],
        ]);

        $prayer->update($data);
        return redirect()->route('admin.daily.prayers.index')->with('success', 'Doa harian berhasil diperbarui');
    }

    public function destroy(DailyPrayer $prayer)
    {
        $prayer->delete();
        return redirect()->route('admin.daily.prayers.index')->with('success', 'Doa harian berhasil dihapus');
    }
}

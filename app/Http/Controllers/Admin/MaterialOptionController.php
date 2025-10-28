<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaterialOption;
use Illuminate\Http\Request;

class MaterialOptionController extends Controller
{
    public function index(Request $request)
    {
        // Tampilkan data meski tipe lama berbeda (kelas/class_level, mapel/subject)
        $classOptions = MaterialOption::query()
            ->whereIn('type', ['class_level','kelas','class'])
            ->orderBy('key')
            ->get();

        $subjectOptions = MaterialOption::query()
            ->whereIn('type', ['subject','mapel'])
            ->orderBy('key')
            ->get();

        return view('admin.materi.options.index', compact('classOptions','subjectOptions'));
    }

    public function create(Request $request)
    {
        $types = [
            'class_level' => 'Kelas',
            'semester' => 'Semester',
            'subject' => 'Mapel',
        ];
        $defaultType = $request->query('type', 'class_level');
        if (! array_key_exists($defaultType, $types)) { $defaultType = 'class_level'; }
        return view('admin.materi.options.create', compact('types','defaultType'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => ['required','in:class_level,semester,subject'],
            'key' => ['required','string','max:100'],
        ]);
        MaterialOption::create($data);
        return redirect()->route('admin.materi.options.index')->with('success', 'Opsi berhasil ditambahkan');
    }

    public function edit(MaterialOption $option)
    {
        $types = [
            'class_level' => 'Kelas',
            'semester' => 'Semester',
            'subject' => 'Mapel',
        ];
        $type = $option->type;
        return view('admin.materi.options.edit', compact('option','types','type'));
    }

    public function update(Request $request, MaterialOption $option)
    {
        $data = $request->validate([
            'type' => ['required','in:class_level,semester,subject'],
            'key' => ['required','string','max:100'],
        ]);
        $option->update($data);
        return redirect()->route('admin.materi.options.index')->with('success', 'Opsi berhasil diperbarui');
    }

    public function destroy(MaterialOption $option)
    {
        $option->delete();
        return redirect()->route('admin.materi.options.index')->with('success', 'Opsi berhasil dihapus');
    }
}

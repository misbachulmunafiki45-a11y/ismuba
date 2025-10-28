<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\MaterialOption;
use Illuminate\Http\Request;

class MateriController extends Controller
{
    public function index(Request $request)
    {
        $filters = [
            'class_level' => $request->query('class_level'),
            'semester' => $request->query('semester'),
            'subject' => $request->query('subject'),
        ];

        $query = Material::query()->orderBy('published_at', 'desc')->orderBy('id', 'desc');
        foreach ($filters as $key => $val) {
            if (!empty($val)) { $query->where($key, $val); }
        }
        $materials = $query->paginate(10)->withQueryString();

        // Options
        $classOpts = MaterialOption::type('class_level')->get();
        $classes = $classOpts->count()
            ? $classOpts->mapWithKeys(fn($o) => [$o->key => ($o->label ?: $o->key)])->toArray()
            : ['X' => 'X', 'XI' => 'XI', 'XII' => 'XII'];
        $semesterOpts = MaterialOption::type('semester')->get();
        $semesters = $semesterOpts->count()
            ? $semesterOpts->mapWithKeys(fn($o) => [$o->key => ($o->label ?: ucfirst($o->key))])->toArray()
            : ['ganjil' => 'Ganjil', 'genap' => 'Genap'];
        $subjectOpts = MaterialOption::type('subject')->get();
        $subjects = $subjectOpts->count()
            ? $subjectOpts->mapWithKeys(fn($o) => [$o->key => ($o->label ?: $o->key)])->toArray()
            : ['Al Islam' => 'Al Islam', 'Kemuh' => 'Kemuh', 'BTQ' => 'BTQ'];

        // Selected values as scalars to simplify Blade
        $selectedClass = (string) ($filters['class_level'] ?? '');
        $selectedSemester = (string) ($filters['semester'] ?? '');
        $selectedSubject = (string) ($filters['subject'] ?? '');

        return view('admin.materi.index', compact('materials','classes','semesters','subjects','filters','selectedClass','selectedSemester','selectedSubject'));
    }

    public function create(Request $request)
    {
        $classOpts = MaterialOption::type('class_level')->get();
        $classes = $classOpts->count()
            ? $classOpts->mapWithKeys(fn($o) => [$o->key => ($o->label ?: $o->key)])->toArray()
            : ['X' => 'X', 'XI' => 'XI', 'XII' => 'XII'];
        $semesterOpts = MaterialOption::type('semester')->get();
        $semesters = $semesterOpts->count()
            ? $semesterOpts->mapWithKeys(fn($o) => [$o->key => ($o->label ?: ucfirst($o->key))])->toArray()
            : ['ganjil' => 'Ganjil', 'genap' => 'Genap'];
        $subjectOpts = MaterialOption::type('subject')->get();
        $subjects = $subjectOpts->count()
            ? $subjectOpts->mapWithKeys(fn($o) => [$o->key => ($o->label ?: $o->key)])->toArray()
            : ['Al Islam' => 'Al Islam', 'Kemuh' => 'Kemuh', 'BTQ' => 'BTQ'];

        $defaultClass = (string) $request->query('class_level', '');
        $defaultSemester = (string) $request->query('semester', '');
        $defaultSubject = (string) $request->query('subject', '');

        return view('admin.materi.create', compact('classes','semesters','subjects','defaultClass','defaultSemester','defaultSubject'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'class_level' => ['required','string'],
            'semester' => ['required','string'],
            'subject' => ['required','string'],
            'title' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'file' => ['nullable','file','mimes:pdf','max:5120'],
            'video_url' => ['nullable','url'],
            'published_at' => ['nullable','date'],
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('materi', 'public');
        }

        Material::create([
            'class_level' => $data['class_level'],
            'semester' => $data['semester'],
            'subject' => $data['subject'],
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'file_path' => $filePath,
            'video_url' => $data['video_url'] ?? null,
            'published_at' => $data['published_at'] ?? null,
        ]);

        return redirect()->route('admin.materi.index')->with('success', 'Materi berhasil ditambahkan');
    }

    public function edit(Material $material)
    {
        $classOpts = MaterialOption::type('class_level')->get();
        $classes = $classOpts->count()
            ? $classOpts->mapWithKeys(fn($o) => [$o->key => ($o->label ?: $o->key)])->toArray()
            : ['X' => 'X', 'XI' => 'XI', 'XII' => 'XII'];
        $semesterOpts = MaterialOption::type('semester')->get();
        $semesters = $semesterOpts->count()
            ? $semesterOpts->mapWithKeys(fn($o) => [$o->key => ($o->label ?: ucfirst($o->key))])->toArray()
            : ['ganjil' => 'Ganjil', 'genap' => 'Genap'];
        $subjectOpts = MaterialOption::type('subject')->get();
        $subjects = $subjectOpts->count()
            ? $subjectOpts->mapWithKeys(fn($o) => [$o->key => ($o->label ?: $o->key)])->toArray()
            : ['Al Islam' => 'Al Islam', 'Kemuh' => 'Kemuh', 'BTQ' => 'BTQ'];

        return view('admin.materi.edit', compact('material','classes','semesters','subjects'));
    }

    public function update(Request $request, Material $material)
    {
        $data = $request->validate([
            'class_level' => ['required','string'],
            'semester' => ['required','string'],
            'subject' => ['required','string'],
            'title' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'file' => ['nullable','file','mimes:pdf','max:5120'],
            'video_url' => ['nullable','url'],
            'published_at' => ['nullable','date'],
        ]);

        $filePath = $material->file_path;
        if ($request->hasFile('file')) {
            // TODO: optionally delete old file
            $filePath = $request->file('file')->store('materi', 'public');
        }

        $material->update([
            'class_level' => $data['class_level'],
            'semester' => $data['semester'],
            'subject' => $data['subject'],
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'file_path' => $filePath,
            'video_url' => $data['video_url'] ?? null,
            'published_at' => $data['published_at'] ?? null,
        ]);

        return redirect()->route('admin.materi.index')->with('success', 'Materi berhasil diperbarui');
    }

    public function destroy(Material $material)
    {
        $material->delete();
        return redirect()->route('admin.materi.index')->with('success', 'Materi berhasil dihapus');
    }
}

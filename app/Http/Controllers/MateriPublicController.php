<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialOption;
use Illuminate\View\View;

class MateriPublicController extends Controller
{
    /**
     * Halaman awal: pilih Kelas.
     */
    public function index(): View
    {
        $classOpts = MaterialOption::type('class_level')->get();
        $classes = $classOpts->count()
            ? $classOpts->map(fn($o) => [
                'key' => $o->key,
                'label' => $o->label ?: $o->key,
            ])
            : collect([
                ['key' => 'X', 'label' => 'X'],
                ['key' => 'XI', 'label' => 'XI'],
                ['key' => 'XII', 'label' => 'XII'],
            ]);

        return view('materi_public.kelas', compact('classes'));
    }

    /**
     * Pilih Semester berdasarkan Kelas.
     */
    public function semester(string $class): View
    {
        $semesterOpts = MaterialOption::type('semester')->get();
        $semesters = $semesterOpts->count()
            ? $semesterOpts->map(fn($o) => [
                'key' => $o->key,
                'label' => $o->label ?: ucfirst($o->key),
            ])
            : collect([
                ['key' => 'ganjil', 'label' => 'Ganjil'],
                ['key' => 'genap', 'label' => 'Genap'],
            ]);

        return view('materi_public.semester', [
            'class' => $class,
            'semesters' => $semesters,
        ]);
    }

    /**
     * Pilih Mapel berdasarkan Kelas dan Semester.
     */
    public function subject(string $class, string $semester): View
    {
        $subjectOpts = MaterialOption::type('subject')->get();
        $subjects = $subjectOpts->count()
            ? $subjectOpts->map(fn($o) => [
                'key' => $o->key,
                'label' => $o->label ?: $o->key,
            ])
            : collect([
                ['key' => 'Al Islam', 'label' => 'Al Islam'],
                ['key' => 'Kemuh', 'label' => 'Kemuh'],
                ['key' => 'BTQ', 'label' => 'BTQ'],
            ]);

        return view('materi_public.mapel', [
            'class' => $class,
            'semester' => $semester,
            'subjects' => $subjects,
        ]);
    }

    /**
     * Daftar materi sesuai Kelas, Semester, dan Mapel.
     */
    public function list(string $class, string $semester, string $subject): View
    {
        $materials = Material::query()
            ->where('class_level', $class)
            ->where('semester', $semester)
            ->where('subject', $subject)
            ->orderBy('published_at', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return view('materi_public.list', [
            'class' => $class,
            'semester' => $semester,
            'subject' => $subject,
            'materials' => $materials,
        ]);
    }
}
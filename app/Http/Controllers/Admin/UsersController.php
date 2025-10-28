<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UsersController extends Controller
{
    /**
     * Show the create user form.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Redirect ke halaman Manajemen Akun setelah berhasil menambah pengguna
        return redirect()->route('admin.account.index')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    /**
     * Delete an existing user.
     */
    public function destroy(User $user): RedirectResponse
    {
        // Cegah menghapus akun yang sedang login
        if (auth()->id() === $user->id) {
            return redirect()->route('admin.account.index')
                ->with('error', 'Tidak dapat menghapus akun yang sedang login.');
        }

        $user->delete();

        return redirect()->route('admin.account.index')
            ->with('success', 'Akun berhasil dihapus.');
    }
}
?>
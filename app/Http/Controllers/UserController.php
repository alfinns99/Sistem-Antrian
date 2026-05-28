<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Loket;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest; // Import Form Request
use App\Http\Requests\UpdateUserRequest; // Import Form Request

class UserController extends Controller
{
    public function __construct()
    {
        // Panggil policy untuk semua metode di controller ini
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Tampilkan daftar semua pengguna.
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Tampilkan formulir untuk membuat pengguna baru.
     */
    public function create()
    {
        $lokets = Loket::where('status', 'aktif')->get();
        return view('users.create', compact('lokets'));
    }

    /**
     * Simpan pengguna baru ke database.
     */
    public function store(StoreUserRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['password'] = Hash::make($validatedData['password']);
        User::create($validatedData);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan!');
    }

    /**
     * Tampilkan detail pengguna tertentu.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Tampilkan formulir untuk mengedit pengguna.
     */
    public function edit(User $user)
    {
        $lokets = Loket::where('status', 'aktif')->get();
        return view('users.edit', compact('user', 'lokets'));
    }

    /**
     * Perbarui pengguna di database.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validatedData = $request->validated();
        
        // Perbarui password hanya jika diisi, jika kosong hapus dari array agar tidak di-update
        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        $user->update($validatedData);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui!');
    }

    /**
     * Hapus pengguna dari database.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus!');
    }
}
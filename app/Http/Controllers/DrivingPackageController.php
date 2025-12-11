<?php

namespace App\Http\Controllers;

use App\Models\DrivingPackage;
use Illuminate\Http\Request;

class DrivingPackageController extends Controller
{
    /**
     * Menampilkan daftar semua paket kursus.
     * PASTIKAN FUNGSI INI ADA.
     */
    public function index()
    {
        $packages = DrivingPackage::latest()->paginate(10);
        return view('packages.index', compact('packages'));
    }

    /**
     * Menampilkan form untuk membuat paket baru.
     */
    public function create()
    {
        return view('packages.create');
    }

    /**
     * Menyimpan paket baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:driving_packages,name',
            'price' => 'required|numeric|min:0',
            'total_meetings' => 'required|integer|min:1',
        ]);

        DrivingPackage::create($validatedData);

        return redirect()->route('packages.index')
                       ->with('success', 'Paket kursus baru berhasil ditambahkan.');
    }

    /**
     * (Opsional) Tambahkan method lain seperti show, edit, update, destroy jika diperlukan.
     */
    public function show(DrivingPackage $package)
    {
        // Untuk menampilkan detail satu paket
        return view('packages.show', compact('package'));
    }

    public function edit(DrivingPackage $package)
    {
        return view('packages.edit', compact('package'));
    }

     public function update(Request $request, DrivingPackage $package)
    {
        $validatedData = $request->validate([
            // Saat update, kita perlu memberitahu rule unique untuk mengabaikan data paket ini sendiri
            'name' => 'required|string|max:255|unique:driving_packages,name,' . $package->id,
            'price' => 'required|numeric|min:0',
            'total_meetings' => 'required|integer|min:1',
        ]);

        $package->update($validatedData);

        return redirect()->route('packages.index')
                       ->with('success', 'Data paket kursus berhasil diperbarui.');
    }

    public function destroy(DrivingPackage $package)
    {
        try {
            $package->delete();
            return redirect()->route('packages.index')->with('success', 'Paket berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus paket.');
        }
    }
}

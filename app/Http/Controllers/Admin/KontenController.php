<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mitra;
use Illuminate\Support\Facades\Storage;

class KontenController extends Controller
{
    // 1. Tampilkan Halaman Mitra
    public function mitra()
    {
        $mitras = Mitra::latest()->paginate(10);
        return view('admin.konten.mitra', compact('mitras'));
    }

    // 2. Simpan Data Mitra (Upload Logo)
    public function storeMitra(Request $request)
    {
        $request->validate([
            'nama_mitra' => 'required|string|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'url' => 'nullable|url',
            'status' => 'required|in:Publish,Private'
        ]);

        $logoPath = $request->file('logo')->store('mitra', 'public');

        Mitra::create([
            'nama_mitra' => $request->nama_mitra,
            'logo' => $logoPath,
            'url' => $request->url,
            'status' => $request->status
        ]);

        return back()->with('success', 'Data Mitra berhasil ditambahkan!');
    }

    // 3. Update Data Mitra
    public function updateMitra(Request $request, $id)
    {
        $mitra = Mitra::findOrFail($id);

        $request->validate([
            'nama_mitra' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'url' => 'nullable|url',
            'status' => 'required|in:Publish,Private'
        ]);

        $data = [
            'nama_mitra' => $request->nama_mitra,
            'url' => $request->url,
            'status' => $request->status
        ];

        // Jika upload logo baru, hapus yang lama
        if ($request->hasFile('logo')) {
            if (Storage::disk('public')->exists($mitra->logo)) {
                Storage::disk('public')->delete($mitra->logo);
            }
            $data['logo'] = $request->file('logo')->store('mitra', 'public');
        }

        $mitra->update($data);

        return back()->with('success', 'Data Mitra berhasil diperbarui!');
    }

    // 4. Hapus Data Mitra
    public function destroyMitra($id)
    {
        $mitra = Mitra::findOrFail($id);
        
        // Hapus file gambar dari storage
        if (Storage::disk('public')->exists($mitra->logo)) {
            Storage::disk('public')->delete($mitra->logo);
        }
        
        $mitra->delete();

        return back()->with('success', 'Data Mitra berhasil dihapus!');
    }

    // Fungsi untuk menampilkan halaman Produk
    // 1. Tampilkan Halaman Produk
    public function produk()
    {
        $produks = \App\Models\KontenProduk::latest()->paginate(10);
        return view('admin.konten.produk', compact('produks'));
    }

    // 2. Simpan Produk Baru
    public function storeProduk(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $gambarPath = $request->file('gambar')->store('konten_produk', 'public');

        \App\Models\KontenProduk::create([
            'nama_produk' => $request->nama_produk,
            'gambar' => $gambarPath
        ]);

        return back()->with('success', 'Produk berhasil ditambahkan!');
    }

    // 3. Update Produk
    public function updateProduk(Request $request, $id)
    {
        $produk = \App\Models\KontenProduk::findOrFail($id);

        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = ['nama_produk' => $request->nama_produk];

        if ($request->hasFile('gambar')) {
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($produk->gambar)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($produk->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('konten_produk', 'public');
        }

        $produk->update($data);

        return back()->with('success', 'Produk berhasil diperbarui!');
    }

    // 4. Hapus Produk
    public function destroyProduk($id)
    {
        $produk = \App\Models\KontenProduk::findOrFail($id);
        
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($produk->gambar)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($produk->gambar);
        }
        
        $produk->delete();

        return back()->with('success', 'Produk berhasil dihapus!');
    }

    // 1. Tampilkan Halaman Portofolio
    public function portofolio()
    {
        $portofolios = \App\Models\Portofolio::latest()->paginate(10);
        return view('admin.konten.portofolio', compact('portofolios'));
    }

    // 2. Simpan Portofolio
    public function storePortofolio(Request $request)
    {
        $request->validate([
            'nama_klien' => 'required|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:Publish,Private'
        ]);

        $gambarPath = $request->file('gambar')->store('portofolio', 'public');

        \App\Models\Portofolio::create([
            'nama_klien' => $request->nama_klien,
            'gambar' => $gambarPath,
            'status' => $request->status
        ]);

        return back()->with('success', 'Portofolio berhasil ditambahkan!');
    }

    // 3. Update Portofolio
    public function updatePortofolio(Request $request, $id)
    {
        $porto = \App\Models\Portofolio::findOrFail($id);

        $request->validate([
            'nama_klien' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:Publish,Private'
        ]);

        $data = [
            'nama_klien' => $request->nama_klien,
            'status' => $request->status
        ];

        if ($request->hasFile('gambar')) {
            if (Storage::disk('public')->exists($porto->gambar)) {
                Storage::disk('public')->delete($porto->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('portofolio', 'public');
        }

        $porto->update($data);

        return back()->with('success', 'Portofolio berhasil diperbarui!');
    }

    // 4. Hapus Portofolio
    public function destroyPortofolio($id)
    {
        $porto = \App\Models\Portofolio::findOrFail($id);
        
        if (Storage::disk('public')->exists($porto->gambar)) {
            Storage::disk('public')->delete($porto->gambar);
        }
        
        $porto->delete();

        return back()->with('success', 'Portofolio berhasil dihapus!');
    }

    // Fungsi untuk menampilkan halaman Testimoni
    // 1. Tampilkan Halaman Testimoni
    public function testimoni()
    {
        $testimonis = \App\Models\Testimoni::latest()->paginate(10);
        return view('admin.konten.testimoni', compact('testimonis'));
    }

    // 2. Simpan Testimoni
    public function storeTestimoni(Request $request)
    {
        $request->validate([
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'nama_customer' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'testimoni' => 'required|string'
        ]);

        $data = $request->except('foto_profil');

        if ($request->hasFile('foto_profil')) {
            $data['foto_profil'] = $request->file('foto_profil')->store('testimoni', 'public');
        }

        \App\Models\Testimoni::create($data);

        return back()->with('success', 'Testimoni berhasil ditambahkan!');
    }

    // 3. Update Testimoni
    public function updateTestimoni(Request $request, $id)
    {
        $testi = \App\Models\Testimoni::findOrFail($id);

        $request->validate([
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'nama_customer' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'testimoni' => 'required|string'
        ]);

        $data = $request->except('foto_profil');

        if ($request->hasFile('foto_profil')) {
            if ($testi->foto_profil && Storage::disk('public')->exists($testi->foto_profil)) {
                Storage::disk('public')->delete($testi->foto_profil);
            }
            $data['foto_profil'] = $request->file('foto_profil')->store('testimoni', 'public');
        }

        $testi->update($data);

        return back()->with('success', 'Testimoni berhasil diperbarui!');
    }

    // 4. Hapus Testimoni
    public function destroyTestimoni($id)
    {
        $testi = \App\Models\Testimoni::findOrFail($id);
        
        if ($testi->foto_profil && Storage::disk('public')->exists($testi->foto_profil)) {
            Storage::disk('public')->delete($testi->foto_profil);
        }
        
        $testi->delete();
        
        return back()->with('success', 'Testimoni berhasil dihapus!');
    }
}

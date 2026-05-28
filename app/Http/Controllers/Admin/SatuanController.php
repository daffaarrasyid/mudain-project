<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Satuan;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    public function index()
    {
        $perPage = request('per_page', 10);
        if (!in_array($perPage, [10, 25, 50])) {
            $perPage = 10;
        }

        // Ambil data, paginasi data per halaman (ascending order)
        $satuans = Satuan::oldest()->paginate($perPage)->withQueryString();
        return view('admin.master-data.satuan', compact('satuans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_satuan' => 'required|string|max:255',
        ]);

        Satuan::create($request->all());

        return back()->with('success', 'Data satuan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_satuan' => 'required|string|max:255',
        ]);

        $satuan = Satuan::findOrFail($id);
        $satuan->update($request->all());

        return back()->with('success', 'Data satuan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Satuan::findOrFail($id)->delete();
        
        return back()->with('success', 'Data satuan berhasil dihapus!');
    }
}
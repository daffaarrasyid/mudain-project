<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Satuan;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    public function index()
    {
        // Ambil data, paginasi 10 data per halaman (ascending order)
        $satuans = Satuan::oldest()->paginate(10);
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
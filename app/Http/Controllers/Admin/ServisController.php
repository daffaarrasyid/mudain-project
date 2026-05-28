<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Servis;
use Illuminate\Http\Request;

class ServisController extends Controller
{
    public function index()
    {
        $perPage = request('per_page', 10);
        if (!in_array($perPage, [10, 25, 50])) {
            $perPage = 10;
        }

        $servis = Servis::latest()->paginate($perPage)->withQueryString();
        
        $lastData = Servis::latest('id')->first();
        $newCode = $lastData ? 'SRV-' . str_pad((int)substr($lastData->kode_servis, 4) + 1, 3, '0', STR_PAD_LEFT) : 'SRV-001';

        return view('admin.master-data.servis', compact('servis', 'newCode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_servis' => 'required|unique:servis',
            'nama_servis' => 'required|string|max:255',
            'harga_dasar' => 'required|numeric'
        ]);
        Servis::create($request->all());
        return back()->with('success', 'Data servis berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_servis' => 'required|string|max:255',
            'harga_dasar' => 'required|numeric'
        ]);
        Servis::findOrFail($id)->update($request->except('kode_servis'));
        return back()->with('success', 'Data servis berhasil diupdate!');
    }

    public function destroy($id)
    {
        Servis::findOrFail($id)->delete();
        return back()->with('success', 'Data servis berhasil dihapus!');
    }
}
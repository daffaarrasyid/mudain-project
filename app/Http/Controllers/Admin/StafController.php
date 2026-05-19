<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Staf;
use App\Models\Servis;
use Illuminate\Http\Request;

class StafController extends Controller
{
    public function index()
    {
        $stafs = Staf::with('servis')->oldest()->paginate(10);
        $dataServis = Servis::all();
        
        $lastData = Staf::latest('id')->first();
        $newCode = $lastData ? 'STF-' . str_pad((int)substr($lastData->kode_staf, 4) + 1, 3, '0', STR_PAD_LEFT) : 'STF-001';

        return view('admin.master-data.staf', compact('stafs', 'dataServis', 'newCode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_staf' => 'required|unique:stafs',
            'nama_staf' => 'required|string|max:255',
            'no_telp'   => 'required|string',
            'servis_id' => 'required|exists:servis,id'
        ]);
        Staf::create($request->all());
        return back()->with('success', 'Data staf berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_staf' => 'required|string|max:255',
            'no_telp'   => 'required|string',
            'servis_id' => 'required|exists:servis,id'
        ]);
        Staf::findOrFail($id)->update($request->except('kode_staf'));
        return back()->with('success', 'Data staf berhasil diupdate!');
    }

    public function destroy($id)
    {
        Staf::findOrFail($id)->delete();
        return back()->with('success', 'Data staf berhasil dihapus!');
    }
}
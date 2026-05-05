<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Imports\SuppliersImport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::oldest()->paginate(10);
        
        // Generate Kode Supplier Otomatis (Format: SP-00001)
        $lastSupplier = Supplier::latest('id')->first();
        if ($lastSupplier) {
            // Mengambil angka setelah "SP-" (3 karakter pertama)
            $lastCode = (int) substr($lastSupplier->kode_supplier, 3);
            // Menambahkan 1, lalu pad dengan angka 0 di kiri sampai total 5 digit
            $newCode = 'SP-' . str_pad($lastCode + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $newCode = 'SP-00001';
        }

        return view('admin.master-data.supplier', compact('suppliers', 'newCode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_supplier' => 'required|unique:suppliers,kode_supplier',
            'nama_supplier' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
        ]);

        Supplier::create($request->all());
        return back()->with('success', 'Data supplier berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
        ]);

        $supplier = Supplier::findOrFail($id);
        $supplier->update($request->except(['kode_supplier'])); // Kode tidak boleh diupdate
        return back()->with('success', 'Data supplier berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Supplier::findOrFail($id)->delete();
        return back()->with('success', 'Data supplier berhasil dihapus!');
    }

    // --- FITUR EXPORT PDF ---
    public function exportPdf()
    {
        $suppliers = Supplier::all();
        $pdf = Pdf::loadView('admin.master-data.supplier-pdf', compact('suppliers'));
        return $pdf->download('Data_Supplier_Mudain.pdf');
    }

    // --- FITUR IMPORT EXCEL ---
    public function importExcel(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv'
        ]);

        // Memanggil class SuppliersImport yang baru aja kita buat manual
        Excel::import(new SuppliersImport, $request->file('file_excel'));
        
        return back()->with('success', 'Data supplier berhasil diimport!');
    }
}
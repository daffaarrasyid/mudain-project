<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Imports\CustomersImport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::oldest()->paginate(10);
        
        // Generate Kode Customer (Format: CS-000001)
        $lastCustomer = Customer::latest('id')->first();
        if ($lastCustomer) {
            $lastCode = (int) substr($lastCustomer->kode_customer, 3);
            $newCode = 'CS-' . str_pad($lastCode + 1, 6, '0', STR_PAD_LEFT);
        } else {
            $newCode = 'CS-000001';
        }

        return view('admin.master-data.customer', compact('customers', 'newCode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_customer'  => 'required|unique:customers,kode_customer',
            'nama_customer'  => 'required|string|max:255',
            'no_telp'        => 'required|string|max:20',
            'jenis_customer' => 'required|in:Umum,Pelanggan',
        ]);

        Customer::create($request->all());
        return back()->with('success', 'Data customer berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_customer'  => 'required|string|max:255',
            'no_telp'        => 'required|string|max:20',
            'jenis_customer' => 'required|in:Umum,Pelanggan',
        ]);

        $customer = Customer::findOrFail($id);
        $customer->update($request->except(['kode_customer']));
        return back()->with('success', 'Data customer berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Customer::findOrFail($id)->delete();
        return back()->with('success', 'Data customer berhasil dihapus!');
    }

    // --- FITUR EXPORT PDF ---
    public function exportPdf()
    {
        $customers = Customer::all();
        // Buat file view admin/customer/pdf.blade.php nanti untuk layout printnya
        $pdf = Pdf::loadView('admin.master-data.customer_pdf', compact('customers'));
        return $pdf->download('Data_Customer_Mudain.pdf');
    }

    // --- FITUR IMPORT EXCEL ---
    public function importExcel(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new CustomersImport, $request->file('file_excel'));
        return back()->with('success', 'Data customer berhasil diimport!');
    }
}
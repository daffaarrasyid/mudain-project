<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ToolsController extends Controller
{
    // Fungsi untuk menampilkan halaman Generate Barcode
    public function generateBarcode()
    {
        return view('admin.tools.generate-barcode');
    }

    // Fungsi untuk menampilkan halaman Backup Data
    public function backupData()
    {
        return view('admin.tools.backup-data');
    }
}
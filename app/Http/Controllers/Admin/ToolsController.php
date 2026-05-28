<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ToolsController extends Controller
{
    // Fungsi untuk menampilkan halaman Backup Data
    public function backupData()
    {
        return view('admin.tools.backup-data');
    }

    public function processBackup()
    {
        // 1. Ambil kredensial database dari config (biasanya ngambil dari .env)
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host     = config('database.connections.mysql.host');

        // 2. Bikin penamaan file dinamis berdasarkan tanggal & jam
        $fileName = 'backup_' . $database . '_' . now()->format('Y-m-d_H-i-s') . '.sql';
        $path = storage_path('app/public/' . $fileName);

        // 3. Susun perintah command line mysqldump
        $passString = $password ? "-p\"{$password}\"" : '';
        $command = "mysqldump -h {$host} -u {$username} {$passString} {$database} > \"{$path}\"";

        // 4. Eksekusi perintah di background
        exec($command, $output, $returnVar);

        // 5. Cek apakah eksekusi berhasil
        if ($returnVar === 0 && File::exists($path)) {
            // Berhasil: Download file lalu otomatis hapus dari storage server biar gak menuh-menuhin
            return response()->download($path)->deleteFileAfterSend(true);
        } else {
            // Gagal: Lempar pesan error ke halaman
            return back()->with('error', 'Gagal backup! Pastikan "mysqldump" sudah dikenali oleh sistem server/laptop lo.');
        }
    }
}
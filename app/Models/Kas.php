<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kas extends Model
{
    use HasFactory;

    protected $table = 'kas';
    protected $guarded = []; // Izinkan semua kolom diisi

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getDynamicKas($awal = null, $akhir = null)
    {
        // 1. Ambil data penjualan
        $queryP = \App\Models\Penjualan::with(['user', 'riwayat_pembayarans']);
        if ($awal && $akhir) {
            $queryP->whereBetween('created_at', [$awal, $akhir]);
        }
        $penjualans = $queryP->get();
        $kasPenjualan = collect();

        foreach ($penjualans as $p) {
            $sumCicilan = $p->riwayat_pembayarans->sum('nominal_bayar');
            $initialBayar = $p->bayar - $sumCicilan;

            if ($initialBayar > 0) {
                $kasPenjualan->push((object)[
                    'kode_kas' => 'KS-P' . str_pad($p->id, 5, '0', STR_PAD_LEFT),
                    'created_at' => $p->created_at,
                    'jenis' => 'Penjualan',
                    'keterangan' => 'Pembayaran Awal Invoice ' . $p->invoice,
                    'tipe' => 'Masuk',
                    'nominal' => $initialBayar,
                    'user' => $p->user,
                ]);
            }
        }

        // Ambil cicilan piutang
        $penjualansAll = \App\Models\Penjualan::with(['user', 'riwayat_pembayarans'])->get();
        foreach ($penjualansAll as $p) {
            foreach ($p->riwayat_pembayarans as $rp) {
                $tglStr = $rp->tanggal_bayar . ' 00:00:00';
                if (!$awal || !$akhir || ($rp->tanggal_bayar >= $awal && $rp->tanggal_bayar <= $akhir) || ($tglStr >= $awal && $tglStr <= $akhir)) {
                    $kasPenjualan->push((object)[
                        'kode_kas' => 'KS-PT' . str_pad($rp->id, 5, '0', STR_PAD_LEFT),
                        'created_at' => \Carbon\Carbon::parse($rp->tanggal_bayar),
                        'jenis' => 'Piutang',
                        'keterangan' => 'Cicilan Invoice ' . $p->invoice . ' - ' . ($rp->keterangan ?? 'Pembayaran Cicilan'),
                        'tipe' => 'Masuk',
                        'nominal' => $rp->nominal_bayar,
                        'user' => $p->user,
                    ]);
                }
            }
        }

        // 2. Ambil data pembelian
        $queryB = \App\Models\Pembelian::with(['user', 'riwayat_pembayarans']);
        if ($awal && $akhir) {
            $queryB->whereBetween('created_at', [$awal, $akhir]);
        }
        $pembelians = $queryB->get();
        $kasPembelian = collect();

        foreach ($pembelians as $b) {
            $sumCicilan = $b->riwayat_pembayarans->sum('nominal_bayar');
            $initialBayar = $b->bayar - $sumCicilan;

            if ($initialBayar > 0) {
                $kasPembelian->push((object)[
                    'kode_kas' => 'KS-B' . str_pad($b->id, 5, '0', STR_PAD_LEFT),
                    'created_at' => $b->created_at,
                    'jenis' => 'Pembelian',
                    'keterangan' => 'Pembayaran Awal PO ' . $b->faktur,
                    'tipe' => 'Keluar',
                    'nominal' => $initialBayar,
                    'user' => $b->user,
                ]);
            }
        }

        // Ambil cicilan hutang
        $pembeliansAll = \App\Models\Pembelian::with(['user', 'riwayat_pembayarans'])->get();
        foreach ($pembeliansAll as $b) {
            foreach ($b->riwayat_pembayarans as $rb) {
                $tglStr = $rb->tanggal_bayar . ' 00:00:00';
                if (!$awal || !$akhir || ($rb->tanggal_bayar >= $awal && $rb->tanggal_bayar <= $akhir) || ($tglStr >= $awal && $tglStr <= $akhir)) {
                    $kasPembelian->push((object)[
                        'kode_kas' => 'KS-HT' . str_pad($rb->id, 5, '0', STR_PAD_LEFT),
                        'created_at' => \Carbon\Carbon::parse($rb->tanggal_bayar),
                        'jenis' => 'Hutang',
                        'keterangan' => 'Cicilan PO ' . $b->faktur . ' - ' . ($rb->keterangan ?? 'Pembayaran Cicilan'),
                        'tipe' => 'Keluar',
                        'nominal' => $rb->nominal_bayar,
                        'user' => $b->user,
                    ]);
                }
            }
        }

        // 3. Ambil data kas manual (selain Penjualan & Pembelian)
        $queryM = self::with('user')->whereNotIn('jenis', ['Penjualan', 'Pembelian']);
        if ($awal && $akhir) {
            $queryM->whereBetween('created_at', [$awal, $akhir]);
        }
        $kasManual = $queryM->get()->map(function ($k) {
            return (object)[
                'kode_kas' => $k->kode_kas,
                'created_at' => $k->created_at,
                'jenis' => $k->jenis,
                'keterangan' => $k->keterangan,
                'tipe' => $k->tipe,
                'nominal' => $k->nominal,
                'user' => $k->user,
            ];
        });

        // 4. Gabungkan dan urutkan (default desc)
        return $kasPenjualan->concat($kasPembelian)->concat($kasManual)->sortByDesc('created_at')->values();
    }

    public static function getDynamicLabaRugi($awal = null, $akhir = null)
    {
        // 1. Penjualan (100% dari 'total_harga')
        $queryP = \App\Models\Penjualan::with('user');
        if ($awal && $akhir) {
            $queryP->whereBetween('created_at', [$awal, $akhir]);
        }
        $penjualans = $queryP->get()->map(function ($p) {
            return (object)[
                'kode_kas' => 'KS-P' . str_pad($p->id, 5, '0', STR_PAD_LEFT),
                'created_at' => $p->created_at,
                'jenis' => 'Penjualan',
                'keterangan' => 'Penjualan Invoice ' . $p->invoice . ' (Total: 100%)',
                'tipe' => 'Masuk',
                'nominal' => $p->total_harga,
                'user' => $p->user,
            ];
        });

        // 2. Pembelian (100% dari 'grand_total')
        $queryB = \App\Models\Pembelian::with('user');
        if ($awal && $akhir) {
            $queryB->whereBetween('created_at', [$awal, $akhir]);
        }
        $pembelians = $queryB->get()->map(function ($b) {
            return (object)[
                'kode_kas' => 'KS-B' . str_pad($b->id, 5, '0', STR_PAD_LEFT),
                'created_at' => $b->created_at,
                'jenis' => 'Pembelian',
                'keterangan' => 'Pembelian PO ' . $b->faktur . ' (Total: 100%)',
                'tipe' => 'Keluar',
                'nominal' => $b->grand_total,
                'user' => $b->user,
            ];
        });

        // 3. Kas manual (selain Penjualan & Pembelian)
        $queryM = self::with('user')->whereNotIn('jenis', ['Penjualan', 'Pembelian']);
        if ($awal && $akhir) {
            $queryM->whereBetween('created_at', [$awal, $akhir]);
        }
        $kasManual = $queryM->get()->map(function ($k) {
            return (object)[
                'kode_kas' => $k->kode_kas,
                'created_at' => $k->created_at,
                'jenis' => $k->jenis,
                'keterangan' => $k->keterangan,
                'tipe' => $k->tipe,
                'nominal' => $k->nominal,
                'user' => $k->user,
            ];
        });

        return $penjualans->concat($pembelians)->concat($kasManual)->sortByDesc('created_at')->values();
    }
}
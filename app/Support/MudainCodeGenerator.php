<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;

class MudainCodeGenerator
{
    public static function forProduk(): string
    {
        return self::next('produk', 'id_produk', 'PRD-', 4);
    }

    public static function forPenjualan(): string
    {
        return self::next('penjualan', 'id_penjualan', 'PNJ-' . now()->format('Ymd') . '-', 4);
    }

    public static function forPembelian(): string
    {
        return self::next('pembelian', 'id_pembelian', 'PBL-' . now()->format('Ymd') . '-', 4);
    }

    protected static function next(string $table, string $column, string $prefix, int $padding): string
    {
        $lastCode = DB::table($table)
            ->where($column, 'like', $prefix . '%')
            ->orderByDesc($column)
            ->value($column);

        if (! $lastCode) {
            return $prefix . str_pad('1', $padding, '0', STR_PAD_LEFT);
        }

        $sequence = (int) substr($lastCode, -$padding);

        return $prefix . str_pad((string) ($sequence + 1), $padding, '0', STR_PAD_LEFT);
    }
}

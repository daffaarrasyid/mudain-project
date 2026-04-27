@extends('admin.layouts.app')

@section('page-title', 'Entry Pembelian')

@section('content')
    <div class="space-y-6" x-data="purchaseForm(@js($produkOptions->map(fn ($produk) => [
        'id' => $produk->id_produk,
        'nama' => $produk->nama_produk,
        'harga' => 0,
    ])->values()))">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-2xl font-bold text-slate-900">Entry Pembelian</h2>
            <p class="mt-2 text-sm text-slate-500">Catat pembelian barang dari pemasok dan tambahkan item masuk ke stok.</p>
        </div>

        <form action="{{ route('admin.transaksi.store-pembelian') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid gap-6 lg:grid-cols-3">
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-2">
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-slate-700">Tanggal</label>
                            <input type="datetime-local" name="tanggal" value="{{ old('tanggal', now()->format('Y-m-d\TH:i')) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100" required>
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-slate-700">Supplier</label>
                            <select name="id_pemasok" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100" required>
                                <option value="">Pilih supplier</option>
                                @foreach ($pemasokOptions as $pemasok)
                                    <option value="{{ $pemasok->id_pemasok }}" @selected(old('id_pemasok') == $pemasok->id_pemasok)>{{ $pemasok->nama_pemasok }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-slate-700">Status Pembayaran</label>
                            <select name="status_pembayaran" x-model="paymentStatus" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">
                                <option value="tunai">Tunai</option>
                                <option value="hutang">Hutang</option>
                            </select>
                        </div>
                        <div x-show="paymentStatus === 'hutang'">
                            <label class="mb-1 block text-sm font-semibold text-slate-700">Jatuh Tempo</label>
                            <input type="date" name="jatuh_tempo" value="{{ old('jatuh_tempo') }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">
                        </div>
                    </div>

                    <div class="mt-6 overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200 text-sm">
                            <thead>
                                <tr class="text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                                    <th class="px-3 py-3">Produk</th>
                                    <th class="px-3 py-3">Qty</th>
                                    <th class="px-3 py-3">Harga Beli</th>
                                    <th class="px-3 py-3">Subtotal</th>
                                    <th class="px-3 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <template x-for="(item, index) in items" :key="index">
                                    <tr>
                                        <td class="px-3 py-3">
                                            <select :name="`items[${index}][id_produk]`" x-model="item.id_produk" class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2 outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">
                                                <option value="">Pilih produk</option>
                                                <template x-for="produk in products" :key="produk.id">
                                                    <option :value="produk.id" x-text="produk.nama"></option>
                                                </template>
                                            </select>
                                        </td>
                                        <td class="px-3 py-3">
                                            <input type="number" min="1" :name="`items[${index}][jumlah]`" x-model.number="item.jumlah" @input="refreshSubtotal(index)" class="w-24 rounded-2xl border border-slate-200 px-3 py-2 outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">
                                        </td>
                                        <td class="px-3 py-3">
                                            <input type="number" min="0" step="0.01" :name="`items[${index}][harga]`" x-model.number="item.harga" @input="refreshSubtotal(index)" class="w-32 rounded-2xl border border-slate-200 px-3 py-2 outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">
                                        </td>
                                        <td class="px-3 py-3 font-semibold text-slate-900" x-text="rupiah(item.subtotal)"></td>
                                        <td class="px-3 py-3 text-right">
                                            <button type="button" @click="removeRow(index)" class="rounded-xl border border-rose-200 px-3 py-2 text-xs font-semibold text-rose-600">Hapus</button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 flex flex-wrap gap-3">
                        <button type="button" @click="addRow()" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700">Tambah Baris</button>
                        <div class="rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white">
                            Total: <span x-text="rupiah(total)"></span>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Catatan</label>
                    <textarea name="catatan" rows="8" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100">{{ old('catatan') }}</textarea>
                    <button type="submit" class="mt-6 w-full rounded-2xl bg-orange-500 px-4 py-3 text-sm font-semibold text-white">Simpan Pembelian</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        function purchaseForm(products) {
            return {
                products,
                paymentStatus: 'tunai',
                items: [{ id_produk: '', jumlah: 1, harga: 0, subtotal: 0 }],
                get total() {
                    return this.items.reduce((sum, item) => sum + Number(item.subtotal || 0), 0);
                },
                addRow() { this.items.push({ id_produk: '', jumlah: 1, harga: 0, subtotal: 0 }); },
                removeRow(index) { if (this.items.length > 1) this.items.splice(index, 1); },
                refreshSubtotal(index) {
                    const item = this.items[index];
                    item.subtotal = Number(item.jumlah || 0) * Number(item.harga || 0);
                },
                rupiah(value) {
                    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(value || 0);
                }
            }
        }
    </script>
@endpush

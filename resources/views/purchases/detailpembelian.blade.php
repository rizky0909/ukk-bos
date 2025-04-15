<x-layout>
    <x-card>
        <div class="relative overflow-x-auto my-3 mx-4">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3">Nama Produk</th>
                        <th class="px-6 py-3">Jumlah</th>
                        <th class="px-6 py-3">Harga Satuan</th>
                        <th class="px-6 py-3">Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['detail'] as $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $item['product']['nama_produk'] ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $item['quantity'] }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $item['product']['harga'] ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                Rp {{ number_format($item['quantity'] * $item['price'], 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50 dark:bg-gray-700 font-semibold text-gray-900 dark:text-white">
                    <tr>
                        <td colspan="3" class="px-6 py-3 text-right">Total Harga</td>
                        <td class="px-6 py-3">Rp {{ number_format($data->total_price, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="px-6 py-3 text-right">Total Kembali</td>
                        <td class="px-6 py-3">Rp {{ number_format($data->total_return, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="px-6 py-3 text-right">Total Bayar</td>
                        <td class="px-6 py-3">Rp {{ number_format($data->total_payment, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- Debug Output (Opsional) --}}
        {{-- <pre>{{ print_r($data, true) }}</pre> --}}
    </x-card>
</x-layout>

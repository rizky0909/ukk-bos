<x-layout>

    <x-card>

        <div class="flex justify-between items-center">
            <span class="text-4xl">Pembelian</span>

            @if (Auth::user()->role == 'staff')
                <a href="{{ route('transactionCreate') }}">
                    <button type="button"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        Tambah Pembelian
                    </button>
                </a>
            @endif

        </div>
        <br>
        <div class="flex justify-between">
            <div>
               
            </div>
            <div class="flex gap-2 ">
                
                <a href="{{ route('downloadExcel') }}">
                    <button type="button"
                        class=" items-center font-medium text-blue-600 dark:text-red-500 hover:underline">
                        Cetak Excel
                    </button>
                </a>
            </div>
        </div>

        <x-table :headers="['Nama Pelanggan', 'Tanggal Penjualan', 'Total Harga', 'Dibuat Oleh', '']">
            @foreach ($transactions as $transaction)
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4 text-gray-900 dark:text-white">
                        {{ $transaction->customer->name ?? 'NON-MEMBER' }}
                    </td>
                    <td class="px-6 py-4 text-gray-900 dark:text-white">
                        {{ $transaction->created_at->format('d F Y') }}
                    </td>
                    <td class="px-6 py-4 text-gray-900 dark:text-white">
                        Rp. {{ number_format($transaction->total_price) }}
                    </td>
                    <td class="px-6 py-4 text-gray-900 dark:text-white">
                        {{ $transaction->user->name }}
                    </td>
                    <td class="px-6 py-4 space-x-3">
                        <div class="flex gap-5">
                            <a href="{{route('detailPembelian',$transaction->id)}}">
                            <button data-modal-target="modal-muehe transaction-id"
                                data-modal-toggle="modal-muehe transaction-id"
                                class="font-medium text-yellow-300 dark:text-yellow-500 hover:underline">
                                Lihat
                            </button>
                        </a>
                            <a href="{{ route('downloadPDF', $transaction->id) }}">
                                <button type="button"
                                    class="font-medium text-blue-600 dark:text-red-500 hover:underline">
                                    Unduh Bukti
                                </button>
                            </a>
                        </div>
                    </td>
                </tr>

                
            @endforeach

        </x-table>
        <div class="mt-4">
            <div>{{ $transactions->links() }}</div>
        </div>
    </x-card>
    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Success',
                text: '{{ session('success') }}',
                icon: "success",
                draggable: true
            });
        </script>
    @endif
</x-layout>

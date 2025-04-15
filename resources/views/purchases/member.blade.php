<x-layout>

    <x-card>
        <form id="transactionForm" action="{{ route('updateMember') }}" method="post">
            @csrf
            <input type="text" name="transaction_id" value="{{ $transaction->id }}" hidden>
            <div class="w-full flex">
                <div class="w-1/2">
                    <x-card>
                        @foreach ($cart as $item)
                            <p>{{ $item['nama_produk'] }}</p>
                            <div class="flex justify-between">
                                <div>Rp. {{ number_format($item['harga']) }} x {{ $item['jumlah'] }}</div>
                                <div>Rp. {{ number_format($item['subtotal']) }}</div>
                            </div>
                        @endforeach
                        <br>
                        <div class="flex justify-between">
                            <div>Total</div>
                            <div>Rp. {{ number_format(collect($cart)->sum('subtotal')) }}</div>
                        </div>
                    </x-card>
                </div>
                <div class="w-1/2 p-10">
                    @if (!$transaction->customer->name)
                        <div>Masukan Nama Member Baru</div>
                        <input type="text" id="nama"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            name="nama" />
                    @else
                        <div>Nama Member</div>
                        <input type="text" id="nama" readonly
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            name="nama" value="{{ $transaction->customer->name }}" />
                    @endif
                    <br>
                    @if (!$transaction->customer->name)
                        <div>Point</div>
                        <input type="number" id="total_point"
                            class="bg-white border mb-3 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            name="total_point" value="{{ $transaction->point }}" readonly />
                        <div class="flex items-center mb-4">
                            <input id="default-checkbox" type="checkbox" disabled
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm">
                            <label for="default-checkbox" class="ms-2 text-sm font-medium text-gray-900">Untuk Pembelian
                                Pertama Belum Bisa Menukar Point</label>
                        </div>
                    @else
                        <div>Point</div>
                        <input type="number" id="total_point"
                            class="bg-white border mb-3 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            name="total_point" value="{{ $transaction->customer->total_point }}" readonly />
                        <div class="flex items-center">
                            <input id="use_point" name="use_point" type="checkbox" value="1"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm">
                            <label for="use_point" class="ms-2 text-sm font-medium text-gray-900">Tukar Point</label>
                        </div>
                    @endif
                    <div class="flex w-full justify-end">
                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                            Tambah Pembelian
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </x-card>

</x-layout>



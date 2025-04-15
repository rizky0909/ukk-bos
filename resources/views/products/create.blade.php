<x-layout>
    <x-card>
        <form action="{{ route('productStore') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="flex gap-3 p-5">
                <div class="w-1/2">
                    <label for="nama_produk" class="block mb-2 text-sm font-medium text-gray-900">Nama Produk</label>
                    <input type="text"
                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                         name="nama_produk" />

                </div>

                <div class="w-1/2">
                    <label class="block mb-2 text-sm font-medium text-gray-900" for="gambar_produk">Gambar
                        Produk</label>
                    <input
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-white focus:outline-none"
                        id="gambar_produk" type="file" name="gambar">
                </div>
            </div>
            <div class="flex gap-3 p-5">
                <div class="w-1/2">
                    <label for="harga" class="block mb-2 text-sm font-medium text-gray-900">Harga</label>
                    <input type="text" id="harga"
                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                         oninput="formatRupiah(this)" name="harga" />
                </div>
                <div class="w-1/2">
                    <label for="stok" class="block mb-2 text-sm font-medium text-gray-900">Stok</label>
                    <input type="number" id="stok"
                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                         name="stok" />
                </div>
            </div>
            <div class="flex flex-row-reverse">
                <div class="justify-end items-end">
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none focus:ring-blue-800">Simpan</button>
                </div>
            </div>
        </form>
    </x-card>
</x-layout>
<script>
    function formatRupiah(input) {
        let angka = input.value.replace(/[^\d]/g, ''); // Hanya angka
        let formatted = new Intl.NumberFormat('id-ID').format(angka); // Format angka
        input.value = angka ? `Rp ${formatted}` : ''; // Tambahkan "Rp "
    }
</script>

@if (session('error'))
    <script>
        Swal.fire({
            title: 'Error',
            text: '{{ session('error') }}',
            icon: "error",
            draggable: true
        });
    </script>
@endif

<x-layout>
    <x-card>
        <form action="{{ route('cart') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-3 gap-4">
                @foreach ($products as $product)
                    <input type="hidden" name="harga[{{ $product->id }}]" value="{{ $product->harga }}">
                    <input type="hidden" name="nama_produk[{{ $product->id }}]" value="{{ $product->nama_produk }}">

                    <div
                        class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 flex">
                        <!-- Gambar -->
                        <img src="{{ asset('storage/' . $product->gambar) }}" class="w-1/3 object-cover rounded-l-lg"
                            alt="{{ $product->nama_produk }}">

                        <!-- Konten -->
                        <div class="p-5 w-2/3 flex flex-col justify-between">
                            <a href="#">
                                <h5 class="mb-2 text-lg font-bold tracking-tight text-gray-900 dark:text-white">
                                    {{ $product->nama_produk }}
                                </h5>
                            </a>
                            <p class="mb-3 text-sm text-gray-700 dark:text-gray-400">
                                Stok {{ $product->stok }}
                            </p>
                            <p class="mb-3 text-sm text-gray-700 dark:text-gray-400">
                                Rp. {{ number_format($product->harga) }}
                            </p>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <button
                                        class="minus inline-flex items-center justify-center h-6 w-6 p-1 me-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                        type="button">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 18 2">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M1 1h16" />
                                        </svg>
                                    </button>
                                    <div>
                                        <input type="number" name="jumlah[{{ $product->id }}]"
                                            max="{{ $product->stok }}" data-stok="{{ $product->stok }}"
                                            data-harga="{{ $product->harga }}"
                                            class="bg-gray-50 w-14 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-2.5 py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            value="0" required readonly />

                                    </div>
                                    <button
                                        class="plus inline-flex items-center justify-center h-6 w-6 p-1 ms-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                        type="button">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 18 18">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M9 1v16M1 9h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                            <br>
                            <p class="subtotal mb-3 text-sm text-gray-700 dark:text-gray-400">
                                Rp. 0
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
            <br>
            <div class="flex flex-col-reverse">
                <button id="submitBtn" type="submit"
                    class="items-end justify-end text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Selanjutnya
                </button>

            </div>
        </form>
    </x-card>
</x-layout>

<script>
    const rupiah = a => 'Rp . ' + a.toLocaleString('id-ID')

    document.querySelectorAll('.plus, .minus').forEach(b => b.onclick = () => {
        const i = b.closest('.flex').querySelector('input[name^="jumlah"]')
        v = Math.max(0, Math.min(+i.value + (b.classList.contains('plus') ? 1 : -1), +i.dataset.stok))
        i.value = v
        p = i.closest('.p-5')
        p.querySelector('.subtotal').textContent = rupiah(v * +i.dataset.harga)
        const n = p.querySelector('input[name^="nama_produk"]')
        n && (n.disabled = !v)
    })

    document.getElementById('submitBtn').onclick = (e) => {
        const kosong = [...document.querySelectorAll('input[name^="jumlah"]')].every(i => +i.value === 0)
        if (kosong) {
            e.preventDefault()
            Swal.fire({
                title: 'Warning',
                text: 'Minimal Pilih Satu Barang',
                icon: "warning",
                draggable: true
            });
        }
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

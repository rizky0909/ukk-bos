<x-layout>

    <x-card>
        <form id="transactionForm" action="{{ route('transactionStore') }}" method="post">
            @csrf
            <div class="w-full flex">
                <input type="hidden" id="payment_clean" name="total_payment_clean" />

                <div class="w-1/2">
                    <h6 class="text-3xl">Produk yang dipilih</h6>
                    @foreach ($cart as $item)
                    {{ $item['nama_produk'] }}
                        <br>
                        <input type="hidden" name="total_price" value="{{ collect($cart)->sum(['subtotal']) }}" />
                        <div class="mb-4">
                            <div></div>
                            <div class="flex justify-between">
                                <div>Rp. {{ number_format($item['harga'] ) }} x {{ $item['jumlah']  }} </div>
                                <div>Rp. {{ number_format($item['subtotal'] ) }} </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="flex justify-between">
                        <h6 class="text-2xl">Total</h6>
                        <h6 class="text-2xl">Rp. {{ number_format(collect($cart)->sum('subtotal')) }}</h6>
                    </div>
                </div>

                <div class=" w-1/2 p-10">
                    <div>Member Status<span class="text-red-400"> Dapat juga membuat member</span></div>
                    <select id="member" name="member"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="">Bukan Member</option>
                        <option value="MEMBER">Member</option>
                    </select>
                    <br>
                    <div id="hp" class="hidden">
                        <div>No Telepon<span class="text-red-400"> (daftar/gunakan member)</span></div>
                        <input type="number" id="no_hp"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            name="no_hp" />
                        <br>
                    </div>
                    <div>Total Bayar</div>
                    <input type="text" id="payment"
                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        oninput="formatRupiah(this); checkPayment();" name="total_payment" data-total="{{ collect($cart)->sum(['subtotal']) }}" />

                    <span class="text-red-300 hidden" id="bayar">Jumlah bayar kurang</span>
                    <br>
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

<script>
    const submit = document.getElementById('transactionForm')
    const paymentC = document.getElementById('payment_clean')
    const member = document.getElementById('member')
    const phone = document.getElementById('hp')
    const payment = document.getElementById('payment')
    const bayar = document.getElementById('bayar')
    const total = parseInt(payment.dataset.total) || 0

    function formatRupiah(input) {
        let angka = input.value.replace(/[^\d]/g, ''); // Hanya angka
        let formatted = new Intl.NumberFormat('id-ID').format(angka); // Format angka
        input.value = angka ? `Rp ${formatted}` : ''; // Tambahkan "Rp "
    }

    member.onchange = () => {
        phone.classList.toggle('hidden',  member.value != 'MEMBER')
    }

    function validatePayment() {
        let angka = payment.value.replace(/[^\d]/g, '');
        paymentC.value = angka
        bayar.classList.toggle('hidden', angka >= total)
    }

    payment.oninput = () => {
        validatePayment(),
        formatRupiah(payment)
    }

    submit.onsubmit = (e) => {
        if((parseInt(paymentC.value) || 0) < total) {
            e.preventDefault()
            Swal.fire({
                title: 'Warning',
                text: 'Jumlah Bayar Kurang',
                icon: "warning",
                draggable: true
            });
        }
    }

</script>

<x-layout>

    @if (Auth::user()->role == 'staff')
        <div class="my-50">
            <x-card>
                <div class="text-center">
                    Total Penjualan Hari Ini
                    <br>
                    {{ App\Models\Transactions::whereDate('created_at', today())->count() }}
                </div>
            </x-card>
        </div>
    @else
        <div class="my-10 px-4">
            <x-card>
                <h2 class="text-center text-lg font-bold mb-4">Grafik Penjualan {{ now()->year }}</h2>
                <div class="flex gap-x-72">
                    <!-- Bar Chart -->
                    <div class="w-full h-[350px]">
                        <canvas id="barChart"></canvas>
                    </div>

                    <!-- Pie Chart -->
                    <div class="w-full h-[350px]">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>

            </x-card>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const months = @json($months);
            const sales = @json($salesPerMonth);

            // Bar Chart
            const barCtx = document.getElementById('barChart').getContext('2d');
            new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Penjualan per Bulan',
                        data: sales,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });

            // Pie Chart (ganti dengan Doughnut Chart)
            const pieCtx = document.getElementById('pieChart').getContext('2d');
            new Chart(pieCtx, {
                type: 'doughnut',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Persentase Penjualan',
                        data: sales,
                        backgroundColor: months.map((_, i) => `hsl(${i * 30}, 70%, 60%)`)
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right',
                        }
                    }
                }
            });
        </script>
    @endif
</x-layout>

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

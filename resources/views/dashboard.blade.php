<x-app-layout>
    <x-slot name="header">
        <h1 class="m-0 text-dark">Dashboard</h1>
    </x-slot>

    {{-- ==================== SMALL BOX BARIS 1 ==================== --}}
    <div class="row mt-3 col-12">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ number_format($totalCustomers) }}</h3>
                    <p>Total Pelanggan</p>
                </div>
                <div class="icon"><i class="fas fa-users"></i></div>
                <a href="{{ url('/customers') }}" class="small-box-footer">
                    Lihat detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ number_format($activeServices) }}</h3>
                    <p>Layanan Aktif</p>
                </div>
                <div class="icon"><i class="fas fa-wifi"></i></div>
                <a href="{{ url('/customer-services') }}" class="small-box-footer">
                    Lihat detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ number_format($isolirServices) }}</h3>
                    <p>Layanan Isolir</p>
                </div>
                <div class="icon"><i class="fas fa-ban"></i></div>
                <a href="{{ url('/customer-services?status=isolir') }}" class="small-box-footer">
                    Lihat detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ number_format($invoiceUnpaid) }}</h3>
                    <p>Invoice Belum Lunas (Bulan Ini)</p>
                </div>
                <div class="icon"><i class="fas fa-file-invoice-dollar"></i></div>
                <a href="{{ url('/invoices?status=unpaid') }}" class="small-box-footer">
                    Lihat detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- ==================== INFO BOX KEUANGAN ==================== --}}
    <div class="row">
        <div class="col-md-6">
            <div class="info-box">
                <span class="info-box-icon bg-primary"><i class="fas fa-coins"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Tagihan Bulan Ini</span>
                    <span class="info-box-number">Rp {{ number_format($totalTagihanBulanIni, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="info-box">
                <span class="info-box-icon bg-teal"><i class="fas fa-hand-holding-usd"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Terbayar Bulan Ini</span>
                    <span class="info-box-number">Rp {{ number_format($totalTerbayarBulanIni, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- ==================== CHART + TABEL JATUH TEMPO ==================== --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">Pendapatan 6 Bulan Terakhir</h3>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" style="min-height: 250px; height: 250px;"></canvas>
                </div>
            </div>

            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">Invoice Jatuh Tempo Terdekat</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-valign-middle">
                        <thead>
                            <tr>
                                <th>No. Invoice</th>
                                <th>Pelanggan</th>
                                <th>Jatuh Tempo</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($upcomingDueInvoices as $invoice)
                                <tr>
                                    <td>{{ $invoice->inv_number }}</td>
                                    <td>{{ $invoice->customerService->customer->nama ?? '-' }}</td>
                                    <td>{{ optional($invoice->due_date)->format('d M Y') }}</td>
                                    <td>Rp {{ number_format($invoice->total, 0, ',', '.') }}</td>
                                    <td><span class="badge badge-danger">Belum Lunas</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">
                                        Tidak ada invoice yang mendekati jatuh tempo.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ==================== AKTIVITAS PENAGIHAN ==================== --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">Aktivitas Penagihan Terbaru</h3>
                </div>
                <div class="card-body p-0">
                    <ul class="products-list product-list-in-card pl-2 pr-2">
                        @forelse ($recentCollections as $collection)
                            <li class="item">
                                <div class="product-info ml-2">
                                    <span class="product-title">
                                        {{ $collection->invoice->customerService->customer->nama ?? '-' }}
                                        @php
                                            $badgeClass = match ($collection->status) {
                                                'SUCCESS' => 'badge-success',
                                                'NOT_HOME' => 'badge-secondary',
                                                'PROMISE_TO_PAY' => 'badge-warning',
                                                'REJECTED' => 'badge-danger',
                                                default => 'badge-light',
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }} float-right">
                                            {{ str_replace('_', ' ', $collection->status) }}
                                        </span>
                                    </span>
                                    <span class="product-description">
                                        Ditagih oleh {{ $collection->collector->nama ?? '-' }} &middot;
                                        {{ optional($collection->visit_date)->format('d M Y') }}
                                    </span>
                                </div>
                            </li>
                        @empty
                            <li class="item text-center text-muted py-3">
                                Belum ada aktivitas penagihan.
                            </li>
                        @endforelse
                    </ul>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ url('/collections') }}" class="uppercase">Lihat Semua Aktivitas</a>
                </div>
            </div>

            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">Status Invoice Bulan Ini</h3>
                </div>
                <div class="card-body">
                    @php
                        $totalInvoiceBulanIni = $invoiceUnpaid + $invoicePaid;
                        $persenLunas =
                            $totalInvoiceBulanIni > 0 ? round(($invoicePaid / $totalInvoiceBulanIni) * 100) : 0;
                    @endphp
                    <p class="mb-1">Lunas ({{ $persenLunas }}%)</p>
                    <div class="progress progress-sm mb-3">
                        <div class="progress-bar bg-success" style="width: {{ $persenLunas }}%"></div>
                    </div>
                    <span class="text-muted">
                        {{ $invoicePaid }} lunas dari {{ $totalInvoiceBulanIni }} invoice bulan ini
                    </span>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: 'Labels', // Ganti dengan array label bulan, misalnya ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun']
                    datasets: [{
                        label: 'Pendapatan',
                        data: 'Data', // Ganti dengan array data pendapatan, misalnya [1000000, 1500000, 2000000, 2500000, 3000000, 3500000]
                        fill: true,
                        backgroundColor: 'rgba(60,141,188,0.2)',
                        borderColor: 'rgba(60,141,188,1)',
                        tension: 0.3,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        </script>
    @endpush
</x-app-layout>

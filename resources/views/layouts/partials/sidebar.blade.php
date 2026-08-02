{{-- resources/views/layouts/partials/sidebar.blade.php --}}
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ url('/dashboard') }}" class="brand-link">
        <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="{{ url('/dashboard') }}"
                       class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-header">MASTER DATA</li>

                <li class="nav-item">
                    <a href="{{ url('/branches') }}" class="nav-link {{ request()->is('branches*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-building"></i>
                        <p>Cabang</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/areas') }}" class="nav-link {{ request()->is('areas*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-map-marked-alt"></i>
                        <p>Area</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/routers') }}" class="nav-link {{ request()->is('routers*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-network-wired"></i>
                        <p>Router</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/internet-packets') }}" class="nav-link {{ request()->is('internet-packets*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-box"></i>
                        <p>Paket Internet</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/collectors') }}" class="nav-link {{ request()->is('collectors*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>Penagih (Collector)</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/technicians') }}" class="nav-link {{ request()->is('technicians*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tools"></i>
                        <p>Teknisi</p>
                    </a>
                </li>

                <li class="nav-header">PELANGGAN</li>

                <li class="nav-item">
                    <a href="{{ url('/customers') }}" class="nav-link {{ request()->is('customers*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Data Pelanggan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/customer-services') }}" class="nav-link {{ request()->is('customer-services*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-wifi"></i>
                        <p>Layanan Pelanggan</p>
                    </a>
                </li>

                <li class="nav-header">KEUANGAN</li>

                <li class="nav-item">
                    <a href="{{ url('/invoices') }}" class="nav-link {{ request()->is('invoices*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-invoice-dollar"></i>
                        <p>Invoice</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/payments') }}" class="nav-link {{ request()->is('payments*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-hand-holding-usd"></i>
                        <p>Pembayaran</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/collections') }}" class="nav-link {{ request()->is('collections*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-route"></i>
                        <p>Penagihan</p>
                    </a>
                </li>

                <li class="nav-header">MONITORING</li>

                <li class="nav-item">
                    <a href="{{ url('/monitoring-sessions') }}" class="nav-link {{ request()->is('monitoring-sessions*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>Sesi Monitoring</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>

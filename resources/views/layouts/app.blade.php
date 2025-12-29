<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>

<style>
    .menu-active {
        background-color: #f0f6ff;
        /* biru muda mirip blue-200 Tailwind */
    }

    .content-scroll {
        height: 100vh;
        overflow-y: auto;
    }
</style>

<body>

    <nav class="navbar bg-white border-bottom d-md-none">
        <div class="container-fluid">
            <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas"
                aria-controls="sidebarOffcanvas">
                <i class="bi bi-list fs-4"></i>
            </button>
            <a class="navbar-brand ms-2" href="#">SML</a>
        </div>
    </nav>

    @php
        $menuItems = [];

        if (auth()->user()->role === 'admin') {
            $menuItems = [
                ['label' => 'Dashboard', 'url' => '/admin/dashboard', 'icon' => 'bi-speedometer2'],
                ['label' => 'Data Pengguna', 'url' => '/admin/DataPengguna', 'icon' => 'bi-person-badge'],
                ['label' => 'Data Pelanggan', 'url' => '/admin/DataPelanggan', 'icon' => 'bi-person-vcard'],
                ['label' => 'Data Kendaraan', 'url' => '/admin/DataKendaraan', 'icon' => 'bi-car-front-fill'],
                ['label' => 'Kontrak Leasing', 'url' => '/admin/KontrakLeasing', 'icon' => 'bi-journal-text'],
                ['label' => 'Pembayaran', 'url' => '/admin/Pembayaran', 'icon' => 'bi-cash-stack'],
                ['label' => 'Laporan', 'url' => '/admin/Laporan', 'icon' => 'bi-bar-chart-line'],
                ['label' => 'Profil', 'url' => '/profil/profil', 'icon' => 'bi-person-circle'],
            ];
        } elseif (auth()->user()->role === 'pelanggan') {
            $menuItems = [
                ['label' => 'Kontrak Saya', 'url' => '/pelanggan/home', 'icon' => 'bi-house-door'],
                ['label' => 'Riwayat Bayar', 'url' => '/pelanggan/riwayat', 'icon' => 'bi-clock-history'],
                ['label' => 'Bayar Cicilan', 'url' => '/pelanggan/bayar', 'icon' => 'bi-credit-card'],
                ['label' => 'Profil', 'url' => '/profil/profil', 'icon' => 'bi-person-circle'],

            ];
        } elseif (auth()->user()->role === 'manajer') {
            $menuItems = [
                ['label' => 'Dashboard', 'url' => '/manajer/dashboard', 'icon' => 'bi-speedometer2'],
                ['label' => 'Analisis Kontrak', 'url' => '/manajer/AnalisisKontrak', 'icon' => 'bi-journal-text'],
                ['label' => 'Analisis Pembayaran', 'url' => '/manajer/AnalisisPembayaran', 'icon' => 'bi-cash-stack'],
                ['label' => 'Laporan Pendapatan', 'url' => '/manajer/LaporanPendapatan', 'icon' => 'bi-bar-chart-line'],
                ['label' => 'Marketing Performance', 'url' => '/manajer/MarketingPerformance', 'icon' => 'bi-graph-up-arrow'],
                ['label' => 'Profil', 'url' => '/profil/profil', 'icon' => 'bi-person-circle'],

            ];
        } elseif (auth()->user()->role === 'marketing') {
            $menuItems = [
                ['label' => 'Dashboard', 'url' => route('marketing.dashboard'), 'icon' => 'bi-speedometer2'],
                ['label' => 'Ajukan Kontrak', 'url' => route('marketing.ajukanKontrak'), 'icon' => 'bi-journal-plus'],
                ['label' => 'Data Pelanggan', 'url' => route('marketing.pelanggan.index'), 'icon' => 'bi-person-vcard'],

                ['label' => 'Pengajuan Saya', 'url' => route('marketing.ajuan'), 'icon' => 'bi-file-earmark-text'],
                ['label' => 'Pengingat Pembayaran', 'url' => route('marketing.pengingat'), 'icon' => 'bi-bell'],
                ['label' => 'Profil', 'url' => '/profil/profil', 'icon' => 'bi-person-circle'],
            ];
        }
    @endphp

    <div class="d-flex">

        <!-- Sidebar (desktop) -->
        <div class="bg-white text-dark d-none d-md-flex flex-column border-end" style="width: 250px; height: 100vh;">

            <div class="p-3 border-bottom d-flex align-items-center gap-3">
                <div class="d-flex justify-content-center align-items-center bg-primary text-white rounded"
                    style="width: 40px; height: 40px;">
                    <i class="bi bi-building"></i>
                </div>
                <div class="d-flex flex-column">
                    <h5 class="mb-0">SML</h5>
                    <small class="text-muted">Sistem Leasing</small>
                </div>
            </div>


            <nav class="flex-grow-1 p-3">
                <ul class="list-unstyled">

                    @foreach($menuItems as $item)
                        <li class="mb-2">
                            <a href="{{ $item['url'] }}"
                                class="d-flex align-items-center gap-2 px-3 py-2 rounded {{ request()->is(ltrim($item['url'], '/') . '/*') || request()->is(ltrim($item['url'], '/')) ? 'menu-active text-primary' : 'text-dark text-decoration-none' }}">
                                <i class="bi {{ $item['icon'] }}"></i>
                                <span>{{ $item['label'] }}</span>
                            </a>
                        </li>
                    @endforeach

                </ul>
            </nav>

            <!-- Logout -->
            <div class="p-3 border-top">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-outline-danger w-100 d-flex align-items-center gap-2">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>

        </div>

        <!-- Content -->
        <div class="p-4 flex-grow-1 content-scroll">
            @yield('content')
        </div>

    </div>

    <!-- Offcanvas sidebar for mobile -->
    <div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="sidebarOffcanvas"
        aria-labelledby="sidebarOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarOffcanvasLabel">SML</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <div class="bg-white text-dark d-flex flex-column" style="width: 250px;">
                <div class="p-3 border-bottom d-flex align-items-center gap-3">
                    <div class="d-flex justify-content-center align-items-center bg-primary text-white rounded"
                        style="width: 40px; height: 40px;">
                        <i class="bi bi-building"></i>
                    </div>
                    <div class="d-flex flex-column">
                        <h5 class="mb-0">SML</h5>
                        <small class="text-muted">Sistem Leasing</small>
                    </div>
                </div>
                <nav class="p-3">
                    <ul class="list-unstyled">
                        @foreach($menuItems as $item)
                            <li class="mb-2">
                                <a href="{{ $item['url'] }}"
                                    class="d-flex align-items-center gap-2 px-3 py-2 rounded {{ request()->is(ltrim($item['url'], '/') . '/*') || request()->is(ltrim($item['url'], '/')) ? 'menu-active text-primary' : 'text-dark text-decoration-none' }}">
                                    <i class="bi {{ $item['icon'] }}"></i>
                                    <span>{{ $item['label'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </nav>
                <div class="p-3 border-top">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-outline-danger w-100 d-flex align-items-center gap-2">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
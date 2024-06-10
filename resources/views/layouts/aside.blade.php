    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link">
            <img src="{{ asset('imgs/logo.png') }}" alt="{{ config('app.name') }}"
                class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">


            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
                    <li class="nav-header">Home</li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}"
                            class="nav-link {{ $active === 'dashboard' ? ' active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                    @if ($role === 'admin')
                        <li class="nav-header">Data</li>
                        <li class="nav-item">
                            <a href="{{ route('customer') }}"
                                class="nav-link {{ $active === 'customer' ? ' active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Kelola Customer
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('mobil') }}" class="nav-link {{ $active === 'mobil' ? ' active' : '' }}">
                                <i class="nav-icon fas fa-car"></i>
                                <p>
                                    Kelola Mobil
                                </p>
                            </a>
                        </li>
                        <li class="nav-header">Laporan</li>
                        <li class="nav-item">
                            <a href="{{ route('penjualan') }}"
                                class="nav-link {{ $active === 'penjualan' ? ' active' : '' }}">
                                <i class="nav-icon fas fa-chart-line"></i>
                                <p>
                                    Laporan Penjualan
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('cicilan') }}"
                                class="nav-link {{ $active === 'cicilan' ? ' active' : '' }}">
                                <i class="nav-icon fas fa-chart-line"></i>
                                <p>
                                    Laporan Cicilan
                                </p>
                            </a>
                        </li>
                    @endif
                    @if ($role === 'customer')
                        <li class="nav-header">Data</li>
                        <li class="nav-item">
                            <a href="{{ route('penjualan') }}"
                                class="nav-link {{ $active === 'penjualan' ? ' active' : '' }}">
                                <i class="nav-icon fas fa-chart-line"></i>
                                <p>
                                    Laporan Pembelian
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('cicilan') }}"
                                class="nav-link {{ $active === 'cicilan' ? ' active' : '' }}">
                                <i class="nav-icon fas fa-chart-line"></i>
                                <p>
                                    Laporan Cicilan
                                </p>
                            </a>
                        </li>
                    @endif
                    <li class="nav-header">Other</li>
                    {{-- @if ($role === 'admin')
                        <li class="nav-item">
                            <a href="{{ route('galery') }}"
                                class="nav-link {{ $active === 'gallery' ? ' active' : '' }}">
                                <i class="nav-icon far fa-images"></i>
                                <p>
                                    Gallery
                                </p>
                            </a>
                        </li>
                    @endif --}}
                    {{-- @if ($role === 'customer')
                        <li class="nav-item">
                            <a href="{{ route('profil') }}"
                                class="nav-link {{ $active === 'profil' ? ' active' : '' }}">
                                <i class="nav-icon far fa-user"></i>
                                <p>
                                    Profil
                                </p>
                            </a>
                        </li>
                    @endif --}}
                    <li class="nav-item">
                        <a href="{{ route('ubahpassword') }}"
                            class="nav-link {{ $active === 'ubah_password' ? ' active' : '' }}">
                            <i class="nav-icon 	fas fa-fingerprint"></i>
                            <p>
                                Ubah Password
                            </p>
                        </a>
                    </li>
                    <li class="nav-header">Navigasi</li>
                    <li class="nav-item">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <a href="#" class="nav-link" onclick="event.preventDefault(); confirmLogout();">
                                <i class="nav-icon fas fa-power-off"></i>
                                <p>Log out</p>
                            </a>
                        </form>
                    </li>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

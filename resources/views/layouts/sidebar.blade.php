<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('dashboard') }}" class="brand-link">

        {{-- Menggunakan file logo-icon.png sebagai ikon kecil --}}
        <img src="{{ asset('logo.png') }}" alt="Bintang Mulya Icon" class="brand-image img elevation" style="opacity: .8">

        {{-- Menggunakan teks biasa untuk nama brand agar rapi --}}
        <span class="brand-text font-weight-light">Bintang Mulya</span>

    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                {{-- Di bawah ini adalah semua item menu Anda --}}
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('attendance.page') }}"
                        class="nav-link {{ request()->routeIs('attendance.*', 'schedules.edit') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-calendar-check"></i>
                        <p>Absensi Harian</p>
                    </a>
                </li>

                <li class="nav-header">MANAJEMEN DATA</li>

                <li class="nav-item">
                    <a href="{{ route('students.index') }}"
                        class="nav-link {{ request()->routeIs('students.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Data Siswa</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('instructors.index') }}"
                        class="nav-link {{ request()->routeIs('instructors.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>Data Instruktur</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('packages.index') }}"
                        class="nav-link {{ request()->routeIs('packages.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-box"></i>
                        <p>Paket Kursus</p>
                    </a>
                </li>

                <li class="nav-header">PENGATURAN</li>

                <li class="nav-item">
                    <a href="{{ route('users.index') }}"
                        class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>Manajemen User</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Sistem HRD</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    {{-- ===============================
        ADMIN ONLY
    ================================== --}}
    @if(auth()->user()->role === 'Admin')

        <div class="sidebar-heading">Admin Area</div>

        <!-- Master Data -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAdminMaster">
                <i class="fas fa-fw fa-database"></i>
                <span>Master Data</span>
            </a>
            <div id="collapseAdminMaster" class="collapse">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('jabatan.index') }}">Jabatan</a>
                    <a class="collapse-item" href="{{ route('departemen.index') }}">Departemen</a>
                </div>
            </div>
        </li>

        <!-- User Management -->
        <li class="nav-item {{ request()->is('users*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('users.index') }}">
                <i class="fas fa-users-cog"></i>
                <span>Kelola Users</span>
            </a>
        </li>

        <!-- System -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-tools"></i>
                <span>Backup & Pengaturan</span>
            </a>
        </li>

        <hr class="sidebar-divider">

    @endif


    {{-- ===============================
        HRD ONLY
    ================================== --}}
    @if(auth()->user()->role === 'HRD')

        <div class="sidebar-heading">HRD Area</div>

        <!-- Data Karyawan -->
        <li class="nav-item {{ request()->is('karyawan') || request()->is('karyawan/*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('karyawan.index') }}">
                <i class="fas fa-id-card-alt"></i>
                <span>Data Karyawan</span>
            </a>
        </li>

        <!-- Absensi - TAMBAHKAN CLASS ACTIVE -->
        <li class="nav-item {{ request()->is('absensi*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('absensi.index') }}">
                <i class="fas fa-clock"></i>
                <span>Absensi</span>
            </a>
        </li>

        <!-- Shift -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseShift">
                <i class="fas fa-calendar"></i>
                <span>Shift</span>
            </a>
            <div id="collapseShift" class="collapse">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('shift.index') }}">Data Shift</a>
                    <a class="collapse-item" href="{{ route('karyawan_shift.index') }}">Penjadwalan Shift</a>
                </div>
            </div>
        </li>

        <!-- Cuti Approval - TAMBAHKAN CLASS ACTIVE -->
        <li class="nav-item {{ request()->is('cuti*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('cuti.index') }}">
                <i class="fas fa-file-signature"></i>
                <span>Approval Cuti</span>
            </a>
        </li>

        <!-- Penggajian -->
        <li class="nav-item {{ request()->is('penggajian*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('penggajian.index') }}">
                <i class="fas fa-money-check-alt"></i>
                <span>Penggajian</span>
            </a>
        </li>

        <!-- Potongan -->
        <li class="nav-item {{ request()->is('potongan*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('potongan.index') }}">
                <i class="fas fa-cut"></i>
                <span>Potongan</span>
            </a>
        </li>

        <hr class="sidebar-divider">

    @endif


    {{-- ===============================
        KARYAWAN ONLY
    ================================== --}}
    @if(auth()->user()->role === 'Karyawan')

        <div class="sidebar-heading">Menu Karyawan</div>

        <li class="nav-item {{ request()->is('absensi*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('absensi.index') }}">
                <i class="fas fa-fw fa-clock"></i>
                <span>Absensi</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('cuti*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('cuti.index') }}">
                <i class="fas fa-fw fa-calendar-alt"></i>
                <span>Pengajuan Cuti</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('profile*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('profile.index') }}">
                <i class="fas fa-fw fa-user"></i>
                <span>Profilku</span>
            </a>
        </li>

        <hr class="sidebar-divider">

    @endif


    <!-- Logout -->
    <li class="nav-item mt-3">
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm mx-3">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </li>

</ul>
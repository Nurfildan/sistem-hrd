<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Brand -->
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

    {{-- ================= ADMIN ================= --}}
    @if(auth()->user()->role === 'Admin')

        <div class="sidebar-heading">Admin Area</div>

        <!-- Master Data -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAdminMaster">
                <i class="fas fa-database"></i>
                <span>Master Data</span>
            </a>
            <div id="collapseAdminMaster" class="collapse">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('admin.jabatan.index') }}">Jabatan</a>
                    <a class="collapse-item" href="{{ route('admin.departemen.index') }}">Departemen</a>
                    <a class="collapse-item" href="{{ route('karyawan.index') }}">Data Karyawan</a>
                    <a class="collapse-item" href="{{ route('admin.users.index') }}">Kelola Users</a>
                </div>
            </div>
        </li>        

        <!-- Laporan -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLaporan">
                <i class="fas fa-file-alt"></i>
                <span>Laporan</span>
            </a>
            <div id="collapseLaporan" class="collapse">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('admin.laporan.absensi') }}">Laporan Absensi</a>
                    <a class="collapse-item" href="{{ route('admin.laporan.cuti') }}">Laporan Cuti</a>
                    <a class="collapse-item" href="{{ route('admin.laporan.penggajian') }}">Laporan Penggajian</a>
                </div>
            </div>
        </li>

        <!-- System -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSystem">
                <i class="fas fa-tools"></i>
                <span>System</span>
            </a>
            <div id="collapseSystem" class="collapse">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('admin.system.settings') }}">Pengaturan Sistem</a>
                    <form action="{{ route('admin.system.backup') }}" method="POST">
                        @csrf
                        <button class="collapse-item btn btn-link p-0 text-left">
                            Backup Database
                        </button>
                    </form>
                </div>
            </div>
        </li>

        <hr class="sidebar-divider">
    @endif


    {{-- ================= HRD ================= --}}
    @if(auth()->user()->role === 'HRD')

        <div class="sidebar-heading">HRD Area</div>

        <li class="nav-item {{ request()->is('karyawan*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('karyawan.index') }}">
                <i class="fas fa-id-card-alt"></i>
                <span>Data Karyawan</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('absensi*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('absensi.index') }}">
                <i class="fas fa-clock"></i>
                <span>Absensi</span>
            </a>
        </li>

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

        <li class="nav-item {{ request()->is('cuti*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('cuti.index') }}">
                <i class="fas fa-file-signature"></i>
                <span>Approval Cuti</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('penggajian*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('penggajian.index') }}">
                <i class="fas fa-money-check-alt"></i>
                <span>Penggajian</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('aturan-potongan*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('aturan-potongan.index') }}">
                <i class="fas fa-cut"></i>
                <span>Aturan Potongan</span>
            </a>
        </li>

        <hr class="sidebar-divider">
    @endif


    {{-- ================= KARYAWAN ================= --}}
    @if(auth()->user()->role === 'Karyawan')

        <div class="sidebar-heading">Menu Karyawan</div>

        <li class="nav-item {{ request()->is('absensi*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('absensi.index') }}">
                <i class="fas fa-clock"></i>
                <span>Absensi</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('cuti*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('cuti.index') }}">
                <i class="fas fa-calendar-alt"></i>
                <span>Pengajuan Cuti</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('profile*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('profile.index') }}">
                <i class="fas fa-user"></i>
                <span>Profilku</span>
            </a>
        </li>

        <hr class="sidebar-divider">
    @endif    

</ul>

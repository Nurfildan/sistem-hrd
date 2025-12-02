@extends('layouts.app')

@section('content')
<div class="container-fluid">
    
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-calendar-alt"></i> Pengaturan Shift Karyawan
        </h1>
        <button onclick="saveSchedule()" class="btn btn-primary btn-icon-split shadow-sm">
            <span class="icon text-white-50">
                <i class="fas fa-save"></i>
            </span>
            <span class="text">Simpan Jadwal</span>
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Month Navigation Card -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <button onclick="changeMonth(-1)" class="btn btn-sm btn-outline-primary mr-2">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <h5 class="mb-0 text-primary font-weight-bold">
                            <i class="fas fa-calendar mr-2"></i>
                            <span id="currentMonth"></span>
                        </h5>
                        <button onclick="changeMonth(1)" class="btn btn-sm btn-outline-primary ml-2">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-6 text-right">
                    <div class="btn-group" role="group">
                        <button onclick="setViewMode('calendar')" id="btnCalendar" class="btn btn-primary">
                            <i class="fas fa-calendar-alt"></i> Kalender
                        </button>
                        <button onclick="setViewMode('list')" id="btnList" class="btn btn-outline-primary">
                            <i class="fas fa-list"></i> List
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Shift Legend -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-info-circle"></i> Jenis Shift
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($shifts as $shift)
                    <div class="col-md-3 mb-2">
                        <div class="border-left-{{ getShiftBorderColor($shift->id) }} p-3 shadow-sm h-100">
                            <div class="font-weight-bold text-{{ getShiftColor($shift->id) }} text-uppercase mb-1">
                                {{ $shift->nama_shift }}
                            </div>
                            <div class="text-xs text-gray-600">
                                <i class="fas fa-clock"></i> 
                                {{ substr($shift->jam_mulai, 0, 5) }} - {{ substr($shift->jam_selesai, 0, 5) }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Calendar View -->
    <div id="calendarView"></div>
    
    <!-- List View -->
    <div id="listView" style="display: none;"></div>

</div>

<!-- Modal Pilih Shift -->
<div class="modal fade" id="shiftModal" tabindex="-1" role="dialog" aria-labelledby="shiftModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalTitle">
                    <i class="fas fa-clock"></i> Pilih Shift
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @foreach($shifts as $shift)
                    <button onclick="assignShift({{ $shift->id }})" 
                            class="btn btn-outline-{{ getShiftColor($shift->id) }} btn-block btn-lg mb-3 shift-modal-btn">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-left">
                                <div class="font-weight-bold">{{ $shift->nama_shift }}</div>
                                <small>{{ substr($shift->jam_mulai, 0, 5) }} - {{ substr($shift->jam_selesai, 0, 5) }}</small>
                            </div>
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </button>
                @endforeach
                
                <hr>
                
                <button onclick="removeShift()" class="btn btn-outline-danger btn-block btn-lg">
                    <i class="fas fa-trash"></i> Hapus Shift
                </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Batal
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999;">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
        <div class="spinner-border text-light" role="status" style="width: 3rem; height: 3rem;">
            <span class="sr-only">Loading...</span>
        </div>
        <p class="text-white mt-3">Menyimpan jadwal...</p>
    </div>
</div>

@endsection

@push('styles')
<style>
    /* SB Admin 2 Compatible Styles */
    .shift-cell {
        transition: all 0.3s;
        cursor: pointer;
        min-height: 80px;
        padding: 0.5rem;
        border: 2px solid #e3e6f0;
        border-radius: 0.35rem;
        background: white;
        position: relative;
    }
    
    .shift-cell:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        border-color: #4e73df;
    }
    
    .shift-cell.weekend {
        background-color: #f8f9fc;
    }
    
    .shift-badge {
        font-size: 0.65rem;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-weight: 700;
        text-transform: uppercase;
    }
    
    .shift-modal-btn {
        transition: all 0.3s;
        border-width: 2px;
    }
    
    .shift-modal-btn:hover {
        transform: translateX(5px);
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    .karyawan-card-header {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    }
    
    .border-left-primary { border-left: 0.25rem solid #4e73df !important; }
    .border-left-warning { border-left: 0.25rem solid #f6c23e !important; }
    .border-left-info { border-left: 0.25rem solid #36b9cc !important; }
    .border-left-secondary { border-left: 0.25rem solid #858796 !important; }
    
    .day-header {
        font-size: 0.75rem;
        font-weight: 700;
        color: #858796;
        text-transform: uppercase;
        padding: 0.5rem;
        text-align: center;
    }
    
    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 0.5rem;
    }
    
    .btn-icon-split {
        padding: 0;
        overflow: hidden;
        border-radius: 10rem;
    }
    
    .btn-icon-split .icon {
        background: rgba(0, 0, 0, 0.15);
        padding: 0.5rem 0.75rem;
    }
    
    .btn-icon-split .text {
        padding: 0.5rem 1rem;
    }
    
    .alert {
        border-radius: 0.35rem;
        border: none;
    }
</style>
@endpush

@push('scripts')
<script>
    // Data dari Laravel
    const karyawanList = @json($karyawan);
    const shifts = @json($shifts);
    const jadwalShiftData = @json($jadwalShift);
    
    const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    const dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

    let currentDate = new Date({{ $tahun }}, {{ $bulan - 1 }}, 1);
    let viewMode = 'calendar';
    let selectedKaryawan = null;
    let selectedDate = null;
    let shiftAssignments = {};

    // Load existing schedule
    function loadSchedule() {
        shiftAssignments = {};
        Object.keys(jadwalShiftData).forEach(karyawanId => {
            jadwalShiftData[karyawanId].forEach(item => {
                const key = `${item.karyawan_id}-${item.tanggal}`;
                shiftAssignments[key] = item.shift_id;
            });
        });
    }

    function getDaysInMonth(date) {
        const year = date.getFullYear();
        const month = date.getMonth();
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const daysInMonth = lastDay.getDate();
        const startingDayOfWeek = firstDay.getDay();
        
        return { daysInMonth, startingDayOfWeek, year, month };
    }

    function changeMonth(delta) {
        currentDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + delta, 1);
        window.location.href = `{{ route('karyawan_shift.index') }}?bulan=${currentDate.getMonth() + 1}&tahun=${currentDate.getFullYear()}`;
    }

    function setViewMode(mode) {
        viewMode = mode;
        document.getElementById('btnCalendar').className = mode === 'calendar' 
            ? 'btn btn-primary'
            : 'btn btn-outline-primary';
        document.getElementById('btnList').className = mode === 'list'
            ? 'btn btn-primary'
            : 'btn btn-outline-primary';
        render();
    }

    function getShiftKey(karyawanId, year, month, date) {
        const monthStr = String(month + 1).padStart(2, '0');
        const dateStr = String(date).padStart(2, '0');
        return `${karyawanId}-${year}-${monthStr}-${dateStr}`;
    }

    function openShiftModal(karyawanId, date) {
        selectedKaryawan = karyawanId;
        selectedDate = date;
        const info = getDaysInMonth(currentDate);
        const karyawan = karyawanList.find(k => k.id === karyawanId);
        document.getElementById('modalTitle').innerHTML = 
            `<i class="fas fa-clock"></i> Pilih Shift - ${karyawan.nama}<br><small class="text-white-50">Tanggal ${date} ${monthNames[info.month]} ${info.year}</small>`;
        $('#shiftModal').modal('show');
    }

    function assignShift(shiftId) {
        const info = getDaysInMonth(currentDate);
        const key = getShiftKey(selectedKaryawan, info.year, info.month, selectedDate);
        shiftAssignments[key] = shiftId;
        $('#shiftModal').modal('hide');
        render();
    }

    function removeShift() {
        const info = getDaysInMonth(currentDate);
        const key = getShiftKey(selectedKaryawan, info.year, info.month, selectedDate);
        delete shiftAssignments[key];
        $('#shiftModal').modal('hide');
        render();
    }

    function getShiftColor(shiftId) {
        const colors = { 1: 'primary', 2: 'warning', 3: 'info', 4: 'secondary' };
        return colors[shiftId] || 'secondary';
    }

    function getShiftBadgeClass(shiftId) {
        return `badge badge-${getShiftColor(shiftId)}`;
    }

    function renderCalendarView() {
        const info = getDaysInMonth(currentDate);
        let html = '';

        karyawanList.forEach(karyawan => {
            html += `
                <div class="card shadow mb-4">
                    <div class="card-header karyawan-card-header py-3">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h6 class="m-0 font-weight-bold text-white">
                                    <i class="fas fa-user-circle"></i> ${karyawan.nama}
                                </h6>
                                <small class="text-white-50">
                                    <i class="fas fa-building"></i> ${karyawan.departemen ? karyawan.departemen.nama_departemen : '-'}
                                </small>
                            </div>
                            <div class="col-md-6 text-right">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">
                                        <i class="fas fa-copy"></i> Copy Minggu
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="copyWeek(${karyawan.id}, 1, 2)">
                                            <i class="fas fa-arrow-right"></i> Minggu 1 → 2
                                        </a>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="copyWeek(${karyawan.id}, 1, 3)">
                                            <i class="fas fa-arrow-right"></i> Minggu 1 → 3
                                        </a>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="copyWeek(${karyawan.id}, 1, 4)">
                                            <i class="fas fa-arrow-right"></i> Minggu 1 → 4
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="copyWeek(${karyawan.id}, 2, 3)">
                                            <i class="fas fa-arrow-right"></i> Minggu 2 → 3
                                        </a>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="copyWeek(${karyawan.id}, 2, 4)">
                                            <i class="fas fa-arrow-right"></i> Minggu 2 → 4
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="copyWeek(${karyawan.id}, 3, 4)">
                                            <i class="fas fa-arrow-right"></i> Minggu 3 → 4
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-primary" href="javascript:void(0)" onclick="copyWeekToAll(${karyawan.id}, 1)">
                                            <i class="fas fa-clone"></i> Copy Minggu 1 ke Semua
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="calendar-grid mb-2">`;
            
            dayNames.forEach(day => {
                html += `<div class="day-header">${day}</div>`;
            });
            
            html += `</div><div class="calendar-grid">`;

            for (let i = 0; i < info.startingDayOfWeek; i++) {
                html += '<div></div>';
            }

            for (let date = 1; date <= info.daysInMonth; date++) {
                const key = getShiftKey(karyawan.id, info.year, info.month, date);
                const shiftId = shiftAssignments[key];
                const shift = shifts.find(s => s.id === shiftId);
                const dayOfWeek = (info.startingDayOfWeek + date - 1) % 7;
                const isWeekend = dayOfWeek === 0 || dayOfWeek === 6;

                html += `
                    <div onclick="openShiftModal(${karyawan.id}, ${date})" 
                         class="shift-cell ${isWeekend ? 'weekend' : ''}">
                        <div class="text-xs font-weight-bold text-gray-600 mb-2">${date}</div>`;
                
                if (shift) {
                    html += `<span class="shift-badge ${getShiftBadgeClass(shift.id)}">
                        ${shift.nama_shift.replace('Shift ', '')}
                    </span>`;
                }
                
                html += `</div>`;
            }

            html += '</div></div></div>';
        });

        document.getElementById('calendarView').innerHTML = html;
    }

    function renderListView() {
        const info = getDaysInMonth(currentDate);
        let html = `
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-bar"></i> Ringkasan Shift Karyawan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Karyawan</th>
                                    <th>Departemen</th>
                                    <th class="text-center">Total Hari Kerja</th>
                                    <th class="text-center">Shift Pagi</th>
                                    <th class="text-center">Shift Siang</th>
                                    <th class="text-center">Shift Malam</th>
                                    <th class="text-center">Off</th>
                                </tr>
                            </thead>
                            <tbody>`;

        karyawanList.forEach((karyawan, index) => {
            let totalHariKerja = 0;
            const countShift = { 1: 0, 2: 0, 3: 0, 4: 0 };

            for (let date = 1; date <= info.daysInMonth; date++) {
                const key = getShiftKey(karyawan.id, info.year, info.month, date);
                const shiftId = shiftAssignments[key];
                if (shiftId) {
                    if (shiftId !== 4) totalHariKerja++;
                    countShift[shiftId]++;
                }
            }

            html += `
                <tr>
                    <td class="text-center">${index + 1}</td>
                    <td class="font-weight-bold">${karyawan.nama}</td>
                    <td>${karyawan.departemen ? karyawan.departemen.nama_departemen : '-'}</td>
                    <td class="text-center">
                        <span class="badge badge-primary badge-pill">${totalHariKerja}</span>
                    </td>
                    <td class="text-center">${countShift[1]}</td>
                    <td class="text-center">${countShift[2]}</td>
                    <td class="text-center">${countShift[3]}</td>
                    <td class="text-center">${countShift[4]}</td>
                </tr>`;
        });

        html += '</tbody></table></div></div></div>';
        document.getElementById('listView').innerHTML = html;
    }

    function copyWeek(karyawanId, fromWeek, toWeek) {
        const info = getDaysInMonth(currentDate);
        let copied = 0;
        
        // Hitung tanggal mulai untuk setiap minggu
        const sourceStartDate = ((fromWeek - 1) * 7) + 1;
        const targetStartDate = ((toWeek - 1) * 7) + 1;
        
        // Copy 7 hari
        for (let i = 0; i < 7; i++) {
            const sourceDate = sourceStartDate + i;
            const targetDate = targetStartDate + i;
            
            // Pastikan tanggal tidak melebihi jumlah hari dalam bulan
            if (sourceDate <= info.daysInMonth && targetDate <= info.daysInMonth) {
                const sourceKey = getShiftKey(karyawanId, info.year, info.month, sourceDate);
                const targetKey = getShiftKey(karyawanId, info.year, info.month, targetDate);
                
                if (shiftAssignments[sourceKey]) {
                    shiftAssignments[targetKey] = shiftAssignments[sourceKey];
                    copied++;
                }
            }
        }
        
        if (copied > 0) {
            alert(`✅ ${copied} jadwal berhasil dicopy dari Minggu ${fromWeek} ke Minggu ${toWeek}!`);
            render();
        } else {
            alert(`⚠️ Tidak ada jadwal di Minggu ${fromWeek} untuk dicopy`);
        }
    }

    function copyWeekToAll(karyawanId, fromWeek) {
        const info = getDaysInMonth(currentDate);
        const sourceStartDate = ((fromWeek - 1) * 7) + 1;
        let copied = 0;
        
        // Hitung jumlah minggu dalam bulan (maksimal 5 minggu)
        const totalWeeks = Math.ceil(info.daysInMonth / 7);
        
        if (!confirm(`📋 Copy jadwal Minggu ${fromWeek} ke semua minggu lainnya (${totalWeeks} minggu)?`)) {
            return;
        }
        
        // Copy ke semua minggu
        for (let week = 1; week <= totalWeeks; week++) {
            if (week === fromWeek) continue; // Skip minggu sumber
            
            const targetStartDate = ((week - 1) * 7) + 1;
            
            for (let i = 0; i < 7; i++) {
                const sourceDate = sourceStartDate + i;
                const targetDate = targetStartDate + i;
                
                if (sourceDate <= info.daysInMonth && targetDate <= info.daysInMonth) {
                    const sourceKey = getShiftKey(karyawanId, info.year, info.month, sourceDate);
                    const targetKey = getShiftKey(karyawanId, info.year, info.month, targetDate);
                    
                    if (shiftAssignments[sourceKey]) {
                        shiftAssignments[targetKey] = shiftAssignments[sourceKey];
                        copied++;
                    }
                }
            }
        }
        
        if (copied > 0) {
            alert(`✅ ${copied} jadwal berhasil dicopy ke semua minggu!`);
            render();
        } else {
            alert(`⚠️ Tidak ada jadwal di Minggu ${fromWeek} untuk dicopy`);
        }
    }

    function render() {
        const info = getDaysInMonth(currentDate);
        document.getElementById('currentMonth').textContent = `${monthNames[info.month]} ${info.year}`;

        if (viewMode === 'calendar') {
            document.getElementById('calendarView').style.display = 'block';
            document.getElementById('listView').style.display = 'none';
            renderCalendarView();
        } else {
            document.getElementById('calendarView').style.display = 'none';
            document.getElementById('listView').style.display = 'block';
            renderListView();
        }
    }

    function saveSchedule() {
        const schedules = [];
        const info = getDaysInMonth(currentDate);

        Object.keys(shiftAssignments).forEach(key => {
            const [karyawanId, year, month, date] = key.split('-');
            schedules.push({
                karyawan_id: parseInt(karyawanId),
                shift_id: shiftAssignments[key],
                tanggal: `${year}-${month}-${date}`
            });
        });

        if (schedules.length === 0) {
            alert('⚠️ Tidak ada jadwal untuk disimpan');
            return;
        }

        if (!confirm(`💾 Simpan ${schedules.length} jadwal shift sekarang?`)) {
            return;
        }

        // Show loading
        document.getElementById('loadingOverlay').style.display = 'block';

        $.ajax({
            url: '{{ route("karyawan_shift.bulkStore") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                schedules: schedules
            },
            success: function(response) {
                document.getElementById('loadingOverlay').style.display = 'none';
                alert('✅ ' + response.message);
                location.reload();
            },
            error: function(xhr) {
                document.getElementById('loadingOverlay').style.display = 'none';
                alert('❌ Gagal menyimpan jadwal shift');
            }
        });
    }

    // Initialize
    $(document).ready(function() {
        loadSchedule();
        render();
        
        // Tooltip
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endpush

@php
function getShiftColor($shiftId) {
    $colors = [
        1 => 'primary',
        2 => 'warning',
        3 => 'info',
        4 => 'secondary'
    ];
    return $colors[$shiftId] ?? 'secondary';
}

function getShiftBorderColor($shiftId) {
    return getShiftColor($shiftId);
}
@endphp
<?php $title = 'Smart Dashboard';
$adminLayout = true; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-8 transition-all duration-300">
        <div class="max-w-7xl mx-auto space-y-8">

            <div class="flex flex-col md:flex-row justify-between items-end gap-4">
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Dashboard Overview</h1>
                    <p class="text-slate-500 mt-1">Pantau aktivitas laboratorium ICLABS secara real-time.</p>
                </div>
                <div class="flex items-center gap-3 bg-white px-4 py-2 rounded-full shadow-sm border border-slate-200">
                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                    <span class="text-xs font-bold text-slate-600 uppercase tracking-wide">
                        <?= date('l, d F Y') ?>
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pengguna</p>
                            <h3 class="text-3xl font-black text-slate-800 mt-2"><?= $stats['users'] ?></h3>
                        </div>
                        <div
                            class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                            <i class="bi bi-people-fill"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center gap-2 text-xs font-medium text-slate-500">
                        <span class="text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded flex items-center gap-1">
                            <i class="bi bi-arrow-up-short"></i> Active
                        </span>
                        <span>Terdaftar di sistem</span>
                    </div>
                </div>

                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Laboratorium</p>
                            <h3 class="text-3xl font-black text-slate-800 mt-2"><?= $stats['labs'] ?></h3>
                        </div>
                        <div
                            class="w-12 h-12 bg-violet-50 text-violet-600 rounded-xl flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                            <i class="bi bi-pc-display"></i>
                        </div>
                    </div>
                    <div class="mt-4 text-xs font-medium text-slate-500">
                        Ruangan Siap Digunakan
                    </div>
                </div>

                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kelas Semester Ini</p>
                            <h3 class="text-3xl font-black text-slate-800 mt-2"><?= $stats['courses'] ?></h3>
                        </div>
                        <div
                            class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                    </div>
                    <div class="mt-4 text-xs font-medium text-slate-500">
                        Mata Kuliah Terjadwal
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-indigo-600 to-blue-700 p-6 rounded-2xl shadow-lg shadow-blue-500/20 text-white relative overflow-hidden group">
                    <div
                        class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700">
                    </div>

                    <div class="relative z-10">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-xs font-bold text-blue-200 uppercase tracking-wider">Sesi Hari Ini</p>
                                <h3 class="text-3xl font-black mt-2"><?= $stats['today_sessions'] ?></h3>
                            </div>
                            <div
                                class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center text-xl">
                                <i class="bi bi-clock-history"></i>
                            </div>
                        </div>
                        <div class="mt-4 text-xs font-medium text-blue-100 flex items-center gap-2">
                            <?php if ($stats['today_sessions'] > 0): ?>
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Sedang Berlangsung
                            <?php else: ?>
                            <span class="opacity-70">Tidak ada jadwal hari ini</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                    <h3 class="font-bold text-slate-800 mb-6 flex items-center gap-2">
                        <i class="bi bi-bar-chart-fill text-primary-600"></i> Kesibukan Laboratorium
                    </h3>
                    <div class="h-64">
                        <canvas id="labChart"></canvas>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                    <h3 class="font-bold text-slate-800 mb-6 flex items-center gap-2">
                        <i class="bi bi-pie-chart-fill text-violet-600"></i> Pengguna Sistem
                    </h3>
                    <div class="h-64 flex items-center justify-center">
                        <canvas id="userChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <div>
                        <h3 class="font-bold text-slate-800 text-lg">Jadwal Praktikum Hari Ini</h3>
                        <p class="text-xs text-slate-500 mt-1">Daftar sesi yang dijadwalkan untuk <?= date('d F Y') ?>
                        </p>
                    </div>
                    <a href="<?= url('/schedule') ?>"
                        class="text-sm font-bold text-primary-600 hover:text-primary-700 flex items-center gap-1">
                        Lihat Full Jadwal <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-xs">
                            <tr>
                                <th class="px-6 py-4">Waktu</th>
                                <th class="px-6 py-4">Laboratorium</th>
                                <th class="px-6 py-4">Mata Kuliah</th>
                                <th class="px-6 py-4">Dosen</th>
                                <th class="px-6 py-4 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php if (!empty($todaySchedule)): ?>
                            <?php foreach ($todaySchedule as $sch):
                                    // Status sederhana berdasarkan jam
                                    $now = date('H:i:s');
                                    $statusClass = 'bg-slate-100 text-slate-600';
                                    $statusText = 'Scheduled';

                                    if ($now >= $sch['start_time'] && $now <= $sch['end_time']) {
                                        $statusClass = 'bg-emerald-100 text-emerald-700 animate-pulse';
                                        $statusText = 'Live Now';
                                    } elseif ($now > $sch['end_time']) {
                                        $statusClass = 'bg-slate-100 text-slate-400';
                                        $statusText = 'Finished';
                                    }
                                ?>
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-6 py-4 font-mono font-medium text-slate-700">
                                    <?= substr($sch['start_time'], 0, 5) ?> - <?= substr($sch['end_time'], 0, 5) ?>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-bold text-slate-800"><?= e($sch['lab_name']) ?></span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-slate-900"><?= e($sch['course_name']) ?></div>
                                    <div class="text-xs text-slate-500"><?= e($sch['class_code']) ?></div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="w-6 h-6 rounded-full bg-slate-200 flex items-center justify-center text-xs font-bold text-slate-600">
                                            <?= substr($sch['lecturer_name'] ?? '?', 0, 1) ?>
                                        </div>
                                        <span class="text-slate-600"><?= e($sch['lecturer_name'] ?? '-') ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-block px-3 py-1 rounded-full text-xs font-bold <?= $statusClass ?>">
                                        <?= $statusText ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                    <i class="bi bi-calendar-x text-3xl mb-2 block"></i>
                                    Tidak ada jadwal praktikum hari ini.
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
</div>

<?php include APP_PATH . '/views/admin/layouts/footer.php'; ?>

<script>
// Data dari PHP
const labLabels = <?= json_encode(array_column($charts['labs'], 'lab_name')) ?>;
const labData = <?= json_encode(array_column($charts['labs'], 'total_courses')) ?>;

const userLabels = <?= json_encode(array_column($charts['users'], 'role_name')) ?>;
const userData = <?= json_encode(array_column($charts['users'], 'total')) ?>;

// 1. Bar Chart (Lab Utilization)
const ctxLab = document.getElementById('labChart').getContext('2d');
new Chart(ctxLab, {
    type: 'bar',
    data: {
        labels: labLabels,
        datasets: [{
            label: 'Jumlah Kelas',
            data: labData,
            backgroundColor: '#3b82f6',
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    borderDash: [2, 2]
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});

// 2. Doughnut Chart (User Roles)
const ctxUser = document.getElementById('userChart').getContext('2d');
new Chart(ctxUser, {
    type: 'doughnut',
    data: {
        labels: userLabels.map(l => l.charAt(0).toUpperCase() + l.slice(1)), // Capitalize
        datasets: [{
            data: userData,
            backgroundColor: ['#6366f1', '#10b981', '#f59e0b', '#ef4444'],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    usePointStyle: true,
                    padding: 20
                }
            }
        },
        cutout: '70%'
    }
});
</script>
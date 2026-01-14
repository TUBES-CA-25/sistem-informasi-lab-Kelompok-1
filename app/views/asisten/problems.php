<?php $title = 'Masalah Laboratorium'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">Masalah Laboratorium</h1>
                <p class="text-slate-500 mt-1">Kelola dan pantau semua laporan masalah.</p>
            </div>
        </div>

        <?php displayFlash(); ?>

        <!-- Tabs -->
        <div class="mb-6">
            <div class="border-b border-slate-200">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <button onclick="switchTab('semua')" id="tab-semua" class="tab-button border-emerald-500 text-emerald-600 whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm">
                        <i class="bi bi-list-ul mr-2"></i>
                        Semua Masalah
                    </button>
                    <button onclick="switchTab('lapor')" id="tab-lapor" class="tab-button border-transparent text-slate-500 hover:text-emerald-600 hover:border-emerald-300 whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm">
                        <i class="bi bi-plus-circle-fill mr-2"></i>
                        Lapor Masalah
                    </button>
                    <button onclick="switchTab('saya')" id="tab-saya" class="tab-button border-transparent text-slate-500 hover:text-emerald-600 hover:border-emerald-300 whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm">
                        <i class="bi bi-file-earmark-text mr-2"></i>
                        Laporan Saya
                    </button>
                </nav>
            </div>
        </div>

        <!-- Tab Content: Semua Masalah -->
        <div id="content-semua" class="tab-content">
            <!-- Statistics -->
            <?php if (isset($statistics)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500">Total Masalah</p>
                            <p class="text-3xl font-bold text-slate-800 mt-2"><?= $statistics['total'] ?? 0 ?></p>
                        </div>
                        <div class="w-14 h-14 bg-slate-50 rounded-xl flex items-center justify-center">
                            <i class="bi bi-exclamation-circle text-slate-400 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-rose-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-rose-600">Dilaporkan</p>
                            <p class="text-3xl font-bold text-rose-700 mt-2"><?= $statistics['reported'] ?? 0 ?></p>
                        </div>
                        <div class="w-14 h-14 bg-rose-50 rounded-xl flex items-center justify-center">
                            <i class="bi bi-flag text-rose-600 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-amber-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-amber-600">Dalam Proses</p>
                            <p class="text-3xl font-bold text-amber-700 mt-2"><?= $statistics['in_progress'] ?? 0 ?></p>
                        </div>
                        <div class="w-14 h-14 bg-amber-50 rounded-xl flex items-center justify-center">
                            <i class="bi bi-hourglass-split text-amber-600 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-emerald-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-emerald-600">Selesai</p>
                            <p class="text-3xl font-bold text-emerald-700 mt-2"><?= $statistics['resolved'] ?? 0 ?></p>
                        </div>
                        <div class="w-14 h-14 bg-emerald-50 rounded-xl flex items-center justify-center">
                            <i class="bi bi-check-circle text-emerald-600 text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Filter -->
            <div class="flex flex-wrap gap-3 mb-6">
                <a href="<?= url('/asisten/problems') ?>" class="px-4 py-2 bg-slate-600 text-white font-medium rounded-lg hover:bg-slate-700 transition-colors">
                    Semua
                </a>
                <a href="<?= url('/asisten/problems?status=reported') ?>" class="px-4 py-2 bg-rose-600 text-white font-medium rounded-lg hover:bg-rose-700 transition-colors">
                    Dilaporkan
                </a>
                <a href="<?= url('/asisten/problems?status=in_progress') ?>" class="px-4 py-2 bg-amber-600 text-white font-medium rounded-lg hover:bg-amber-700 transition-colors">
                    Dalam Proses
                </a>
                <a href="<?= url('/asisten/problems?status=resolved') ?>" class="px-4 py-2 bg-emerald-600 text-white font-medium rounded-lg hover:bg-emerald-700 transition-colors">
                    Selesai
                </a>
            </div>
            
            <!-- Table -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-emerald-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-emerald-800 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-emerald-800 uppercase tracking-wider">Laboratorium</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-emerald-800 uppercase tracking-wider">PC</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-emerald-800 uppercase tracking-wider">Tipe</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-emerald-800 uppercase tracking-wider">Deskripsi</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-emerald-800 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-emerald-800 uppercase tracking-wider">Pelapor</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-emerald-800 uppercase tracking-wider">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            <?php if (!empty($problems)): ?>
                                <?php foreach ($problems as $problem): ?>
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">#<?= e($problem['id']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700"><?= e($problem['lab_name']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">PC-<?= e($problem['pc_number']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <?php
                                                $typeColors = [
                                                    'hardware' => 'bg-rose-50 text-rose-700 border-rose-200',
                                                    'software' => 'bg-sky-50 text-sky-700 border-sky-200',
                                                    'network' => 'bg-purple-50 text-purple-700 border-purple-200',
                                                    'other' => 'bg-slate-50 text-slate-700 border-slate-200'
                                                ];
                                                $typeColor = $typeColors[$problem['problem_type']] ?? $typeColors['other'];
                                            ?>
                                            <span class="inline-flex px-3 py-1 text-xs font-bold rounded-lg border <?= $typeColor ?>">
                                                <?= ucfirst($problem['problem_type']) ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-slate-600"><?= e(substr($problem['description'], 0, 50)) ?>...</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <?php
                                                $statusColors = [
                                                    'reported' => 'bg-rose-50 text-rose-700 border-rose-200',
                                                    'in_progress' => 'bg-amber-50 text-amber-700 border-amber-200',
                                                    'resolved' => 'bg-emerald-50 text-emerald-700 border-emerald-200'
                                                ];
                                                $statusColor = $statusColors[$problem['status']] ?? 'bg-slate-50 text-slate-700 border-slate-200';
                                            ?>
                                            <span class="inline-flex px-3 py-1 text-xs font-bold rounded-lg border <?= $statusColor ?>">
                                                <?= ucfirst(str_replace('_', ' ', $problem['status'])) ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700"><?= e($problem['reporter_name']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600"><?= date('d M Y', strtotime($problem['reported_at'])) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center">
                                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <i class="bi bi-inbox text-4xl text-slate-300"></i>
                                        </div>
                                        <h3 class="text-lg font-medium text-slate-900">Tidak ada masalah</h3>
                                        <p class="text-slate-500">Belum ada laporan masalah yang tersedia.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tab Content: Lapor Masalah -->
        <div id="content-lapor" class="tab-content hidden">
            <?php include APP_PATH . '/views/asisten/report-problem-form.php'; ?>
        </div>

        <!-- Tab Content: Laporan Saya -->
        <div id="content-saya" class="tab-content hidden">
            <?php include APP_PATH . '/views/asisten/my-reports-content.php'; ?>
        </div>

    </div>
</div>

<script>
function switchTab(tabName) {
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('border-emerald-500', 'text-emerald-600');
        button.classList.add('border-transparent', 'text-slate-500');
    });
    
    document.getElementById('content-' + tabName).classList.remove('hidden');
    
    const activeTab = document.getElementById('tab-' + tabName);
    activeTab.classList.remove('border-transparent', 'text-slate-500');
    activeTab.classList.add('border-emerald-500', 'text-emerald-600');
}

document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const tab = urlParams.get('tab') || 'semua';
    switchTab(tab);
});
</script>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>


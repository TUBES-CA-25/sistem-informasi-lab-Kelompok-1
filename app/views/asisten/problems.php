<?php $title = 'Lab Problems'; $adminLayout = true; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="admin-layout antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>
    
    <main class="p-4 sm:ml-64 pt-10">
    <div class="p-4 border-2 border-dashed border-slate-200 rounded-lg bg-white min-h-[80vh]">
        <div class="admin-navbar">
            <div class="admin-navbar-brand">Lab Problems</div>
            <div class="admin-navbar-profile">
                <span><?= e(getUserName()) ?></span>
            </div>

            <button data-modal-target="addProblemModal" data-modal-toggle="addProblemModal" class="text-white bg-sky-600 hover:bg-sky-700 font-medium rounded-lg text-sm px-5 py-2.5 flex items-center shadow-lg shadow-sky-500/30 transition-all">
                <i class="bi bi-plus-lg mr-2"></i> Lapor Masalah Baru
            </button>
        </div>
        
        <div class="admin-content">
            <?php displayFlash(); ?>
            
            <!-- Statistics -->
            <?php if (isset($statistics)): ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
                <div class="stat-card" style="border-left: 4px solid #64748b;">
                    <div class="stat-label">Total Problems</div>
                    <div class="stat-value"><?= $statistics['total'] ?? 0 ?></div>
                </div>
                <div class="stat-card danger">
                    <div class="stat-label">Reported</div>
                    <div class="stat-value"><?= $statistics['reported'] ?? 0 ?></div>
                </div>
                <div class="stat-card warning">
                    <div class="stat-label">In Progress</div>
                    <div class="stat-value"><?= $statistics['in_progress'] ?? 0 ?></div>
                </div>
                <div class="stat-card success">
                    <div class="stat-label">Resolved</div>
                    <div class="stat-value"><?= $statistics['resolved'] ?? 0 ?></div>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Filter -->
            <div style="margin-bottom: 1.5rem;">
                <a href="<?= url('/admin/problems') ?>" class="btn" style="background: #64748b; color: white;">All</a>
                <a href="<?= url('/admin/problems?status=reported') ?>" class="btn btn-danger">Reported</a>
                <a href="<?= url('/admin/problems?status=in_progress') ?>" class="btn btn-warning">In Progress</a>
                <a href="<?= url('/admin/problems?status=resolved') ?>" class="btn btn-success">Resolved</a>
            </div>
            
            <div class="card">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Laboratory</th>
                            <th>PC</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Reporter</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($problems)): ?>
                            <?php foreach ($problems as $problem): ?>
                                <tr>
                                    <td><?= e($problem['id']) ?></td>
                                    <td><?= e($problem['lab_name']) ?></td>
                                    <td><?= e($problem['pc_number']) ?></td>
                                    <td><?= getProblemTypeLabel($problem['problem_type']) ?></td>
                                    <td><?= e(substr($problem['description'], 0, 50)) ?>...</td>
                                    <td><?= getStatusBadge($problem['status']) ?></td>
                                    <td><?= e($problem['reporter_name']) ?></td>
                                    <td><?= formatDateTime($problem['reported_at']) ?></td>
                                    <td>
                                        <a href="<?= url('/admin/problems/' . $problem['id']) ?>" class="btn btn-primary" style="padding: 0.375rem 0.75rem; font-size: 0.75rem;">View</a>
                                        <form method="POST" action="<?= url('/admin/problems/' . $problem['id'] . '/delete') ?>" style="display: inline;" onsubmit="return confirmDelete()">
                                            <button type="submit" class="btn btn-danger" style="padding: 0.375rem 0.75rem; font-size: 0.75rem;">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" style="text-align: center; padding: 2rem; color: #64748b;">No problems found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </main>
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

<div id="addProblemModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow-xl">
            <div class="flex items-start justify-between p-4 border-b rounded-t bg-slate-50">
                <h3 class="text-lg font-bold text-slate-800">Lapor Masalah Baru</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center" data-modal-hide="addProblemModal">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="p-6">
                <form action="<?= url('/asisten/create-problem') ?>" method="POST">
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900">Laboratorium</label>
                        <select name="laboratory_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                            <?php foreach ($laboratories as $lab): ?>
                                <option value="<?= $lab['id'] ?>"><?= e($lab['lab_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Nomor PC</label>
                            <input type="text" name="pc_number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" placeholder="Contoh: 05" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Jenis Masalah</label>
                            <select name="problem_type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                                <option value="software">Software</option>
                                <option value="hardware">Hardware</option>
                                <option value="network">Jaringan</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900">Deskripsi Masalah</label>
                        <textarea name="description" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" placeholder="Jelaskan detail kerusakannya..." required></textarea>
                    </div>
                    <button type="submit" class="w-full text-white bg-sky-600 hover:bg-sky-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center shadow-lg shadow-sky-500/30">Kirim Laporan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>
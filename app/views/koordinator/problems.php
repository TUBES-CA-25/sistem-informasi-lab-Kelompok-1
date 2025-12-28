<?php $title = 'Koordinator - Problems'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div style="display: flex; min-height: 100vh;">
    <!-- Sidebar -->
    <div style="width: 250px; background: #1e293b; color: white; padding: 1.5rem;">
        <div style="font-size: 1.5rem; font-weight: bold; margin-bottom: 2rem;">ICLABS</div>
        <ul style="list-style: none; padding: 0;">
            <li style="margin-bottom: 0.5rem;">
                <a href="<?= url('/koordinator/dashboard') ?>" style="color: #cbd5e1; text-decoration: none; display: block; padding: 0.5rem;">Dashboard</a>
            </li>
            <li style="margin-bottom: 0.5rem;">
                <a href="<?= url('/koordinator/problems') ?>" style="color: white; text-decoration: none; display: block; padding: 0.5rem; background: #334155; border-radius: 0.25rem;">All Problems</a>
            </li>
            <li>
                <a href="<?= url('/logout') ?>" style="color: #cbd5e1; text-decoration: none; display: block; padding: 0.5rem;">Logout</a>
            </li>
        </ul>
    </div>
    
    <!-- Main Content -->
    <div style="flex: 1; background: #f8fafc;">
        <div style="background: white; padding: 1rem 2rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <h2>📋 Daftar Masalah Lab</h2>
            <p>Kelola semua laporan masalah laboratorium</p>
        </div>
        
        <div style="padding: 2rem;">
            <?php if (hasFlash()): ?>
                <div class="alert alert-<?= getFlash()['type'] ?>">
                    <?= getFlash()['message'] ?>
                </div>
            <?php endif; ?>

            <!-- Filter Status -->
            <div class="card" style="margin-bottom: 2rem;">
                <div class="card-body">
                    <h3 style="margin-bottom: 1rem;">Filter Status</h3>
                    <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                        <a href="/koordinator/problems" class="btn <?= !isset($currentStatus) ? 'btn-primary' : 'btn-secondary' ?>">
                            Semua
                        </a>
                        <a href="/koordinator/problems?status=reported" class="btn <?= ($currentStatus ?? '') === 'reported' ? 'btn-primary' : 'btn-secondary' ?>">
                            Dilaporkan
                        </a>
                        <a href="/koordinator/problems?status=in_progress" class="btn <?= ($currentStatus ?? '') === 'in_progress' ? 'btn-primary' : 'btn-secondary' ?>">
                            Dalam Proses
                        </a>
                        <a href="/koordinator/problems?status=resolved" class="btn <?= ($currentStatus ?? '') === 'resolved' ? 'btn-primary' : 'btn-secondary' ?>">
                            Selesai
                        </a>
                    </div>
                </div>
            </div>

            <!-- Problems List -->
            <div class="card">
                <div class="card-body">
                <?php if (empty($problems)): ?>
                    <div class="empty-state">
                        <p>📭 Tidak ada masalah ditemukan</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Laboratorium</th>
                                    <th>PC Number</th>
                                    <th>Tipe</th>
                                    <th>Deskripsi</th>
                                    <th>Pelapor</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($problems as $problem): ?>
                                    <tr>
                                        <td>#<?= $problem['id'] ?></td>
                                        <td><?= htmlspecialchars($problem['lab_name']) ?></td>
                                        <td><?= htmlspecialchars($problem['pc_number']) ?></td>
                                        <td>
                                            <span class="badge badge-secondary">
                                                <?= ucfirst($problem['problem_type']) ?>
                                            </span>
                                        </td>
                                        <td style="max-width: 300px;">
                                            <?= htmlspecialchars(substr($problem['description'], 0, 100)) ?>
                                            <?= strlen($problem['description']) > 100 ? '...' : '' ?>
                                        </td>
                                        <td><?= htmlspecialchars($problem['reporter_name']) ?></td>
                                        <td><?= getStatusBadge($problem['status']) ?></td>
                                        <td><?= formatDate($problem['reported_at']) ?></td>
                                        <td>
                                            <a href="/koordinator/problems/<?= $problem['id'] ?>" class="btn btn-sm btn-primary">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>

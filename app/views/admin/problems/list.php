<?php $title = 'Lab Problems'; $adminLayout = true; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="admin-layout antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/admin-sidebar.php'; ?>
    
    <main class="p-4 sm:ml-64 pt-10">
    <div class="p-4 border-2 border-dashed border-slate-200 rounded-lg bg-white min-h-[80vh]">
        <div class="admin-navbar">
            <div class="admin-navbar-brand">Lab Problems</div>
            <div class="admin-navbar-profile">
                <span><?= e(getUserName()) ?></span>
            </div>
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
    </div>
    
<?php include APP_PATH . '/views/layouts/footer.php'; ?>
    </main>
</div>


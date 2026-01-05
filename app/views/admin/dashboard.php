<?php $title = 'Admin Dashboard'; $adminLayout = true; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="admin-layout antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/admin-sidebar.php'; ?>
    
    <main class="p-4 sm:ml-64 pt-10">
    <div class="main-content">
        <div class="admin-navbar">
            <div class="admin-navbar-brand">Dashboard</div>
            <div class="admin-navbar-profile">
                <span>Welcome, <?= e($userName) ?></span>
            </div>
        </div>
        
        <div class="admin-content">
            <?php displayFlash(); ?>
            
            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-label">Total Users</div>
                    <div class="stat-value"><?= $statistics['total_users'] ?? 0 ?></div>
                </div>
                
                <div class="stat-card success">
                    <div class="stat-label">Laboratories</div>
                    <div class="stat-value"><?= $statistics['total_laboratories'] ?? 0 ?></div>
                </div>
                
                <div class="stat-card warning">
                    <div class="stat-label">Pending Problems</div>
                    <div class="stat-value"><?= $statistics['pending_problems'] ?? 0 ?></div>
                </div>
                
                <div class="stat-card danger">
                    <div class="stat-label">Total Problems</div>
                    <div class="stat-value"><?= $statistics['total_problems'] ?? 0 ?></div>
                </div>
            </div>
            
            <!-- Recent Problems -->
            <div class="card">
                <div class="card-header">Recent Problems</div>
                <?php if (!empty($recentProblems)): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Laboratory</th>
                                <th>PC Number</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Reported By</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_slice($recentProblems, 0, 10) as $problem): ?>
                                <tr>
                                    <td><?= e($problem['lab_name']) ?></td>
                                    <td><?= e($problem['pc_number']) ?></td>
                                    <td><?= getProblemTypeLabel($problem['problem_type']) ?></td>
                                    <td><?= getStatusBadge($problem['status']) ?></td>
                                    <td><?= e($problem['reporter_name']) ?></td>
                                    <td><?= formatDateTime($problem['reported_at']) ?></td>
                                    <td>
                                        <a href="<?= url('/admin/problems/' . $problem['id']) ?>" class="btn btn-primary" style="padding: 0.375rem 0.75rem; font-size: 0.75rem;">View</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p style="text-align: center; padding: 2rem; color: #64748b;">No problems reported</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php include APP_PATH . '/views/layouts/footer.php'; ?>
    </main>
</div>


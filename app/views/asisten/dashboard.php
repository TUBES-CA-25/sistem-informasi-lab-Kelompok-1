<?php $title = 'Asisten Dashboard'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div style="display: flex; min-height: 100vh;">
    <!-- Simple Sidebar for Asisten -->
    <div style="width: 250px; background: #1e293b; color: white; padding: 1.5rem;">
        <div style="font-size: 1.5rem; font-weight: bold; margin-bottom: 2rem;">ICLABS</div>
        <ul style="list-style: none; padding: 0;">
            <li style="margin-bottom: 0.5rem;"><a href="<?= url('/asisten/dashboard') ?>" style="color: white; text-decoration: none; display: block; padding: 0.5rem; background: #334155; border-radius: 0.25rem;">Dashboard</a></li>
            <li style="margin-bottom: 0.5rem;"><a href="<?= url('/asisten/report-problem') ?>" style="color: #cbd5e1; text-decoration: none; display: block; padding: 0.5rem;">Report Problem</a></li>
            <li style="margin-bottom: 0.5rem;"><a href="<?= url('/asisten/my-reports') ?>" style="color: #cbd5e1; text-decoration: none; display: block; padding: 0.5rem;">My Reports</a></li>
            <li><a href="<?= url('/logout') ?>" style="color: #cbd5e1; text-decoration: none; display: block; padding: 0.5rem;">Logout</a></li>
        </ul>
    </div>
    
    <div style="flex: 1; background: #f8fafc;">
        <div style="background: white; padding: 1rem 2rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <h2>Dashboard</h2>
            <p>Welcome, <?= e($userName) ?></p>
        </div>
        
        <div style="padding: 2rem;">
            <?php displayFlash(); ?>
            
            <div class="card">
                <div class="card-header">My Problem Reports</div>
                <?php if (!empty($myReports)): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Laboratory</th>
                                <th>PC Number</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Reported At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($myReports as $report): ?>
                                <tr>
                                    <td><?= e($report['lab_name']) ?></td>
                                    <td><?= e($report['pc_number']) ?></td>
                                    <td><?= getProblemTypeLabel($report['problem_type']) ?></td>
                                    <td><?= e(substr($report['description'], 0, 50)) ?>...</td>
                                    <td><?= getStatusBadge($report['status']) ?></td>
                                    <td><?= formatDateTime($report['reported_at']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p style="text-align: center; padding: 2rem; color: #64748b;">You haven't reported any problems yet</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>

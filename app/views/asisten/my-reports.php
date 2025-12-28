<?php $title = 'My Reports - Asisten'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div style="display: flex; min-height: 100vh;">
    <!-- Sidebar -->
    <div style="width: 250px; background: #1e293b; color: white; padding: 1.5rem;">
        <div style="font-size: 1.5rem; font-weight: bold; margin-bottom: 2rem;">ICLABS</div>
        <ul style="list-style: none; padding: 0;">
            <li style="margin-bottom: 0.5rem;">
                <a href="<?= url('/asisten/dashboard') ?>" style="color: #cbd5e1; text-decoration: none; display: block; padding: 0.5rem;">Dashboard</a>
            </li>
            <li style="margin-bottom: 0.5rem;">
                <a href="<?= url('/asisten/report-problem') ?>" style="color: #cbd5e1; text-decoration: none; display: block; padding: 0.5rem;">Report Problem</a>
            </li>
            <li style="margin-bottom: 0.5rem;">
                <a href="<?= url('/asisten/my-reports') ?>" style="color: white; text-decoration: none; display: block; padding: 0.5rem; background: #334155; border-radius: 0.25rem;">My Reports</a>
            </li>
            <li>
                <a href="<?= url('/logout') ?>" style="color: #cbd5e1; text-decoration: none; display: block; padding: 0.5rem;">Logout</a>
            </li>
        </ul>
    </div>
    
    <!-- Main Content -->
    <div style="flex: 1; background: #f8fafc;">
        <div style="background: white; padding: 1rem 2rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <h2>📋 My Problem Reports</h2>
            <p>View all problems you have reported</p>
        </div>
        
        <div style="padding: 2rem;">
            <?php displayFlash(); ?>
            
            <!-- Reports Card -->
            <div class="card">
                <?php if (!empty($reports)): ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Laboratory</th>
                                    <th>PC Number</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Reported At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($reports as $report): ?>
                                    <tr>
                                        <td>#<?= $report['id'] ?></td>
                                        <td><?= e($report['lab_name']) ?></td>
                                        <td><strong><?= e($report['pc_number']) ?></strong></td>
                                        <td>
                                            <span class="badge badge-secondary">
                                                <?= ucfirst($report['problem_type']) ?>
                                            </span>
                                        </td>
                                        <td style="max-width: 300px;">
                                            <?= e(substr($report['description'], 0, 100)) ?>
                                            <?= strlen($report['description']) > 100 ? '...' : '' ?>
                                        </td>
                                        <td><?= getStatusBadge($report['status']) ?></td>
                                        <td><?= formatDateTime($report['reported_at']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div style="text-align: center; padding: 3rem;">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">📭</div>
                        <h3 style="color: #64748b; margin-bottom: 0.5rem;">No Reports Yet</h3>
                        <p style="color: #94a3b8; margin-bottom: 1.5rem;">You haven't reported any problems</p>
                        <a href="<?= url('/asisten/report-problem') ?>" class="btn btn-primary">
                            Report a Problem
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <?php if (!empty($reports)): ?>
                <!-- Summary Stats -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-top: 2rem;">
                    <?php
                    $total = count($reports);
                    $reported = count(array_filter($reports, fn($r) => $r['status'] === 'reported'));
                    $inProgress = count(array_filter($reports, fn($r) => $r['status'] === 'in_progress'));
                    $resolved = count(array_filter($reports, fn($r) => $r['status'] === 'resolved'));
                    ?>
                    
                    <div class="card" style="border-left: 4px solid #6366f1;">
                        <div style="color: #64748b; font-size: 0.875rem; margin-bottom: 0.5rem;">Total Reports</div>
                        <div style="font-size: 2rem; font-weight: 700;"><?= $total ?></div>
                    </div>
                    
                    <div class="card" style="border-left: 4px solid #ef4444;">
                        <div style="color: #64748b; font-size: 0.875rem; margin-bottom: 0.5rem;">Reported</div>
                        <div style="font-size: 2rem; font-weight: 700;"><?= $reported ?></div>
                    </div>
                    
                    <div class="card" style="border-left: 4px solid #f59e0b;">
                        <div style="color: #64748b; font-size: 0.875rem; margin-bottom: 0.5rem;">In Progress</div>
                        <div style="font-size: 2rem; font-weight: 700;"><?= $inProgress ?></div>
                    </div>
                    
                    <div class="card" style="border-left: 4px solid #10b981;">
                        <div style="color: #64748b; font-size: 0.875rem; margin-bottom: 0.5rem;">Resolved</div>
                        <div style="font-size: 2rem; font-weight: 700;"><?= $resolved ?></div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>

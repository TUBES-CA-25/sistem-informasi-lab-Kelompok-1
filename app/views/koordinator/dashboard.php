<?php $title = 'Koordinator Dashboard'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div style="display: flex; min-height: 100vh;">
    <div style="width: 250px; background: #1e293b; color: white; padding: 1.5rem;">
        <div style="font-size: 1.5rem; font-weight: bold; margin-bottom: 2rem;">ICLABS</div>
        <ul style="list-style: none; padding: 0;">
            <li style="margin-bottom: 0.5rem;"><a href="<?= url('/koordinator/dashboard') ?>" style="color: white; text-decoration: none; display: block; padding: 0.5rem; background: #334155; border-radius: 0.25rem;">Dashboard</a></li>
            <li style="margin-bottom: 0.5rem;"><a href="<?= url('/koordinator/problems') ?>" style="color: #cbd5e1; text-decoration: none; display: block; padding: 0.5rem;">All Problems</a></li>
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
            
            <!-- Statistics -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
                <div class="card" style="border-left: 4px solid #f59e0b;">
                    <div style="color: #64748b; font-size: 0.875rem; margin-bottom: 0.5rem;">Total Problems</div>
                    <div style="font-size: 2rem; font-weight: 700;"><?= $statistics['total'] ?? 0 ?></div>
                </div>
                <div class="card" style="border-left: 4px solid #ef4444;">
                    <div style="color: #64748b; font-size: 0.875rem; margin-bottom: 0.5rem;">Reported</div>
                    <div style="font-size: 2rem; font-weight: 700;"><?= $statistics['reported'] ?? 0 ?></div>
                </div>
                <div class="card" style="border-left: 4px solid #3b82f6;">
                    <div style="color: #64748b; font-size: 0.875rem; margin-bottom: 0.5rem;">In Progress</div>
                    <div style="font-size: 2rem; font-weight: 700;"><?= $statistics['in_progress'] ?? 0 ?></div>
                </div>
                <div class="card" style="border-left: 4px solid #10b981;">
                    <div style="color: #64748b; font-size: 0.875rem; margin-bottom: 0.5rem;">Resolved</div>
                    <div style="font-size: 2rem; font-weight: 700;"><?= $statistics['resolved'] ?? 0 ?></div>
                </div>
            </div>
            
            <!-- Pending Problems -->
            <div class="card">
                <div class="card-header">Pending Problems</div>
                <?php if (!empty($pendingProblems)): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Laboratory</th>
                                <th>PC</th>
                                <th>Type</th>
                                <th>Reporter</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pendingProblems as $problem): ?>
                                <tr>
                                    <td><?= e($problem['lab_name']) ?></td>
                                    <td><?= e($problem['pc_number']) ?></td>
                                    <td><?= getProblemTypeLabel($problem['problem_type']) ?></td>
                                    <td><?= e($problem['reporter_name']) ?></td>
                                    <td><?= formatDateTime($problem['reported_at']) ?></td>
                                    <td>
                                        <a href="<?= url('/koordinator/problems/' . $problem['id']) ?>" class="btn btn-primary" style="padding: 0.375rem 0.75rem; font-size: 0.75rem;">View</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p style="text-align: center; padding: 2rem; color: #64748b;">No pending problems</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>

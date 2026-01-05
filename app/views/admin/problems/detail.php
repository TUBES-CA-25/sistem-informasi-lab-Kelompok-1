<?php $title = 'Problem Detail'; $adminLayout = true; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="admin-layout antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/admin-sidebar.php'; ?>
    
    <main class="p-4 sm:ml-64 pt-10">
        <div class="max-w-4xl mx-auto">
        <div class="admin-navbar">
            <div class="admin-navbar-brand">Problem Detail</div>
            <div class="admin-navbar-profile">
                <span><?= e(getUserName()) ?></span>
            </div>
        </div>
        
        <div class="admin-content">
            <?php displayFlash(); ?>
            
            <div style="margin-bottom: 1.5rem;">
                <a href="<?= url('/admin/problems') ?>" class="btn" style="background: #64748b; color: white;">← Back to List</a>
            </div>
            
            <div class="card">
                <div class="card-header">Problem Information</div>
                <table class="table">
                    <tr>
                        <th style="width: 200px;">Laboratory</th>
                        <td><?= e($problem['lab_name']) ?> - <?= e($problem['location']) ?></td>
                    </tr>
                    <tr>
                        <th>PC Number</th>
                        <td><?= e($problem['pc_number']) ?></td>
                    </tr>
                    <tr>
                        <th>Problem Type</th>
                        <td><?= getProblemTypeLabel($problem['problem_type']) ?></td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td><?= nl2br(e($problem['description'])) ?></td>
                    </tr>
                    <tr>
                        <th>Current Status</th>
                        <td><?= getStatusBadge($problem['status']) ?></td>
                    </tr>
                    <tr>
                        <th>Reported By</th>
                        <td><?= e($problem['reporter_name']) ?> (<?= e($problem['reporter_email']) ?>)</td>
                    </tr>
                    <tr>
                        <th>Reported At</th>
                        <td><?= formatDateTime($problem['reported_at']) ?></td>
                    </tr>
                </table>
            </div>
            
            <!-- Update Status Form -->
            <div class="card">
                <div class="card-header">Update Status</div>
                <form method="POST" action="<?= url('/admin/problems/' . $problem['id'] . '/update-status') ?>">
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control" required>
                            <option value="reported" <?= $problem['status'] == 'reported' ? 'selected' : '' ?>>Reported</option>
                            <option value="in_progress" <?= $problem['status'] == 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                            <option value="resolved" <?= $problem['status'] == 'resolved' ? 'selected' : '' ?>>Resolved</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Note</label>
                        <textarea name="note" class="form-control" rows="3" placeholder="Add note about this update..."></textarea>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </div>
                </form>
            </div>
            
            <!-- History -->
            <div class="card">
                <div class="card-header">Update History</div>
                <?php if (!empty($histories)): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Note</th>
                                <th>Updated By</th>
                                <th>Updated At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($histories as $history): ?>
                                <tr>
                                    <td><?= getStatusBadge($history['status']) ?></td>
                                    <td><?= e($history['note']) ?></td>
                                    <td><?= e($history['updater_name']) ?></td>
                                    <td><?= formatDateTime($history['updated_at']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p style="text-align: center; padding: 2rem; color: #64748b;">No history yet</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>    
    <?php include APP_PATH . '/views/layouts/footer.php'; ?>
    </main>
</div>


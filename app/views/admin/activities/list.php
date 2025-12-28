<?php $title = 'Lab Activities'; $adminLayout = true; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="admin-layout">
    <?php include APP_PATH . '/views/layouts/admin-sidebar.php'; ?>
    
    <div class="main-content">
        <div class="admin-navbar">
            <div class="admin-navbar-brand">Lab Activities</div>
            <div class="admin-navbar-actions">
                <a href="<?= url('/admin/activities/create') ?>" class="btn btn-primary">+ Add Activity</a>
            </div>
        </div>
        
        <div class="admin-content">
            <?php displayFlash(); ?>
            
            <div class="card">
                <?php if (!empty($activities)): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($activities as $activity): ?>
                                <tr>
                                    <td><?= $activity['id'] ?></td>
                                    <td><?= e($activity['title']) ?></td>
                                    <td>
                                        <span class="badge badge-secondary">
                                            <?= ucfirst($activity['activity_type']) ?>
                                        </span>
                                    </td>
                                    <td><?= formatDate($activity['activity_date']) ?></td>
                                    <td><?= e($activity['location']) ?></td>
                                    <td><?= getStatusBadge($activity['status']) ?></td>
                                    <td><?= e($activity['creator_name']) ?></td>
                                    <td>
                                        <a href="<?= url('/admin/activities/' . $activity['id'] . '/edit') ?>" class="btn btn-sm btn-primary">Edit</a>
                                        <form method="POST" action="<?= url('/admin/activities/' . $activity['id'] . '/delete') ?>" style="display: inline;">
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="empty-state">No activities found. <a href="<?= url('/admin/activities/create') ?>">Create one</a></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>

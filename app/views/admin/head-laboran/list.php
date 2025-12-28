<?php $title = 'Head Laboran'; $adminLayout = true; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="admin-layout">
    <?php include APP_PATH . '/views/layouts/admin-sidebar.php'; ?>
    
    <div class="main-content">
        <div class="admin-navbar">
            <div class="admin-navbar-brand">Head Laboran</div>
            <div class="admin-navbar-actions">
                <a href="<?= url('/admin/head-laboran/create') ?>" class="btn btn-primary">+ Add Head Laboran</a>
            </div>
        </div>
        
        <div class="admin-content">
            <?php displayFlash(); ?>
            
            <div class="card">
                <?php if (!empty($headLaborans)): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Location</th>
                                <th>Time In</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($headLaborans as $hl): ?>
                                <tr>
                                    <td><?= $hl['id'] ?></td>
                                    <td>
                                        <?php if (!empty($hl['photo'])): ?>
                                            <img src="<?= asset($hl['photo']) ?>" alt="Photo" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                                        <?php else: ?>
                                            <div style="width: 50px; height: 50px; border-radius: 50%; background: #e9ecef; display: flex; align-items: center; justify-content: center;">
                                                👤
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= e($hl['user_name']) ?></td>
                                    <td><?= e($hl['user_email']) ?></td>
                                    <td><?= e($hl['location']) ?></td>
                                    <td><?= formatTime($hl['time_in']) ?></td>
                                    <td><?= getStatusBadge($hl['status']) ?></td>
                                    <td>
                                        <a href="<?= url('/admin/head-laboran/' . $hl['id'] . '/edit') ?>" class="btn btn-sm btn-primary">Edit</a>
                                        <form method="POST" action="<?= url('/admin/head-laboran/' . $hl['id'] . '/delete') ?>" style="display: inline;">
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="empty-state">No head laboran found. <a href="<?= url('/admin/head-laboran/create') ?>">Create one</a></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>

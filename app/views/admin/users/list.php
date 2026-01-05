<?php $title = 'Users Management'; $adminLayout = true; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="admin-layout">
    <?php include APP_PATH . '/views/layouts/admin-sidebar.php'; ?>
    <main class="p-4 sm:ml-64 pt-10">
        <div class="p-4 border-2 border-dashed border-slate-200 rounded-lg bg-white min-h-[80vh]">

    <div class="main-content">
        <div class="admin-navbar">
            <div class="admin-navbar-brand">Users Management</div>
            <div class="admin-navbar-profile">
                <span><?= e(getUserName()) ?></span>
            </div>
        </div>
        
        <div class="admin-content">
            <?php displayFlash(); ?>
            
            <div style="margin-bottom: 1.5rem;">
                <a href="<?= url('/admin/users/create') ?>" class="btn btn-primary">Add New User</a>
            </div>
            
            <div class="card">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users)): ?>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= e($user['id']) ?></td>
                                    <td><?= e($user['name']) ?></td>
                                    <td><?= e($user['email']) ?></td>
                                    <td><span class="badge badge-info"><?= e($user['role_name']) ?></span></td>
                                    <td><?= getStatusBadge($user['status']) ?></td>
                                    <td><?= formatDate($user['created_at']) ?></td>
                                    <td>
                                        <a href="<?= url('/admin/users/' . $user['id'] . '/edit') ?>" class="btn btn-primary" style="padding: 0.375rem 0.75rem; font-size: 0.75rem;">Edit</a>
                                        <?php if ($user['id'] != getUserId()): ?>
                                            <form method="POST" action="<?= url('/admin/users/' . $user['id'] . '/delete') ?>" style="display: inline;" onsubmit="return confirmDelete('Delete this user?')">
                                                <button type="submit" class="btn btn-danger" style="padding: 0.375rem 0.75rem; font-size: 0.75rem;">Delete</button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 2rem; color: #64748b;">No users found</td>
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


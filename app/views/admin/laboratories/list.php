<?php $title = 'Laboratories'; $adminLayout = true; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="admin-layout antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/admin-sidebar.php'; ?>
    
    <main class="p-4 sm:ml-64 pt-10">
    <div class="p-4 border-2 border-dashed border-slate-200 rounded-lg bg-white min-h-[80vh]">
        <div class="admin-navbar">
            <div class="admin-navbar-brand">Laboratories</div>
            <div class="admin-navbar-profile">
                <span><?= e(getUserName()) ?></span>
            </div>
        </div>
        
        <div class="admin-content">
            <?php displayFlash(); ?>
            
            <div style="margin-bottom: 1.5rem;">
                <a href="<?= url('/admin/laboratories/create') ?>" class="btn btn-primary">Add New Laboratory</a>
            </div>
            
            <div class="card">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Location</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($laboratories)): ?>
                            <?php foreach ($laboratories as $lab): ?>
                                <tr>
                                    <td><?= e($lab['id']) ?></td>
                                    <td><?= e($lab['lab_name']) ?></td>
                                    <td><?= e($lab['description']) ?></td>
                                    <td><?= e($lab['location']) ?></td>
                                    <td>
                                        <a href="<?= url('/admin/laboratories/' . $lab['id'] . '/edit') ?>" class="btn btn-primary" style="padding: 0.375rem 0.75rem; font-size: 0.75rem;">Edit</a>
                                        <form method="POST" action="<?= url('/admin/laboratories/' . $lab['id'] . '/delete') ?>" style="display: inline;" onsubmit="return confirmDelete()">
                                            <button type="submit" class="btn btn-danger" style="padding: 0.375rem 0.75rem; font-size: 0.75rem;">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 2rem; color: #64748b;">No laboratories found</td>
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


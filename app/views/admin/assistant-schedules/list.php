<?php $title = 'Assistant Schedules'; $adminLayout = true; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="admin-layout antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/admin-sidebar.php'; ?>
    
    <main class="p-4 sm:ml-64 pt-10">
    <div class="p-4 border-2 border-dashed border-slate-200 rounded-lg bg-white min-h-[80vh]">
    <div class="main-content">
        <div class="admin-navbar">
            <div class="admin-navbar-brand">Assistant Schedules</div>
            <div class="admin-navbar-actions">
                <a href="<?= url('/admin/assistant-schedules/create') ?>" class="btn btn-primary">+ Add Schedule</a>
            </div>
        </div>
        
        <div class="admin-content">
            <?php displayFlash(); ?>
            
            <div class="card">
                <?php if (!empty($schedules)): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Assistant</th>
                                <th>Day</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($schedules as $schedule): ?>
                                <tr>
                                    <td><?= $schedule['id'] ?></td>
                                    <td><?= e($schedule['assistant_name']) ?></td>
                                    <td><?= $schedule['day'] ?></td>
                                    <td><?= formatTime($schedule['start_time']) ?></td>
                                    <td><?= formatTime($schedule['end_time']) ?></td>
                                    <td><?= getStatusBadge($schedule['status']) ?></td>
                                    <td>
                                        <a href="<?= url('/admin/assistant-schedules/' . $schedule['id'] . '/edit') ?>" class="btn btn-sm btn-primary">Edit</a>
                                        <form method="POST" action="<?= url('/admin/assistant-schedules/' . $schedule['id'] . '/delete') ?>" style="display: inline;">
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="empty-state">No assistant schedules found. <a href="<?= url('/admin/assistant-schedules/create') ?>">Create one</a></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    </div>
    <?php include APP_PATH . '/views/layouts/footer.php'; ?>
    </main>
</div>


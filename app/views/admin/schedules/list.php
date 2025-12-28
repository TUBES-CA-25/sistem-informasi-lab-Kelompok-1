<?php $title = 'Lab Schedules'; $adminLayout = true; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="admin-layout">
    <?php include APP_PATH . '/views/layouts/admin-sidebar.php'; ?>
    
    <div class="main-content">
        <div class="admin-navbar">
            <div class="admin-navbar-brand">Lab Schedules</div>
            <div class="admin-navbar-profile">
                <span><?= e(getUserName()) ?></span>
            </div>
        </div>
        
        <div class="admin-content">
            <?php displayFlash(); ?>
            
            <div style="margin-bottom: 1.5rem;">
                <a href="<?= url('/admin/schedules/create') ?>" class="btn btn-primary">Add New Schedule</a>
            </div>
            
            <div class="card">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Day</th>
                            <th>Time</th>
                            <th>Laboratory</th>
                            <th>Course</th>
                            <th>Lecturer</th>
                            <th>Assistant</th>
                            <th>Participants</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($schedules)): ?>
                            <?php foreach ($schedules as $schedule): ?>
                                <tr>
                                    <td><?= getDayName($schedule['day']) ?></td>
                                    <td><?= formatTime($schedule['start_time']) ?> - <?= formatTime($schedule['end_time']) ?></td>
                                    <td><?= e($schedule['lab_name']) ?><br><small><?= e($schedule['location']) ?></small></td>
                                    <td><?= e($schedule['course']) ?></td>
                                    <td><?= e($schedule['lecturer']) ?></td>
                                    <td><?= e($schedule['assistant']) ?></td>
                                    <td><?= e($schedule['participant_count']) ?></td>
                                    <td>
                                        <a href="<?= url('/admin/schedules/' . $schedule['id'] . '/edit') ?>" class="btn btn-primary" style="padding: 0.375rem 0.75rem; font-size: 0.75rem;">Edit</a>
                                        <form method="POST" action="<?= url('/admin/schedules/' . $schedule['id'] . '/delete') ?>" style="display: inline;" onsubmit="return confirmDelete()">
                                            <button type="submit" class="btn btn-danger" style="padding: 0.375rem 0.75rem; font-size: 0.75rem;">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 2rem; color: #64748b;">No schedules found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>

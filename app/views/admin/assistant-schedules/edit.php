<?php $title = 'Edit Assistant Schedule'; $adminLayout = true; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="admin-layout">
    <?php include APP_PATH . '/views/layouts/admin-sidebar.php'; ?>
    
    <div class="main-content">
        <div class="admin-navbar">
            <div class="admin-navbar-brand">Edit Assistant Schedule</div>
            <div class="admin-navbar-actions">
                <a href="<?= url('/admin/assistant-schedules') ?>" class="btn btn-secondary">Back</a>
            </div>
        </div>
        
        <div class="admin-content">
            <?php displayFlash(); ?>
            
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="<?= url('/admin/assistant-schedules/' . $schedule['id'] . '/edit') ?>">
                        <div class="form-group">
                            <label for="user_id">Assistant *</label>
                            <select name="user_id" id="user_id" class="form-control" required>
                                <option value="">-- Select Assistant --</option>
                                <?php foreach ($assistants as $assistant): ?>
                                    <option value="<?= $assistant['id'] ?>" <?= $schedule['user_id'] == $assistant['id'] ? 'selected' : '' ?>>
                                        <?= e($assistant['name']) ?> (<?= e($assistant['email']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="day">Day *</label>
                            <select name="day" id="day" class="form-control" required>
                                <option value="">-- Select Day --</option>
                                <option value="Monday" <?= $schedule['day'] == 'Monday' ? 'selected' : '' ?>>Monday</option>
                                <option value="Tuesday" <?= $schedule['day'] == 'Tuesday' ? 'selected' : '' ?>>Tuesday</option>
                                <option value="Wednesday" <?= $schedule['day'] == 'Wednesday' ? 'selected' : '' ?>>Wednesday</option>
                                <option value="Thursday" <?= $schedule['day'] == 'Thursday' ? 'selected' : '' ?>>Thursday</option>
                                <option value="Friday" <?= $schedule['day'] == 'Friday' ? 'selected' : '' ?>>Friday</option>
                                <option value="Saturday" <?= $schedule['day'] == 'Saturday' ? 'selected' : '' ?>>Saturday</option>
                                <option value="Sunday" <?= $schedule['day'] == 'Sunday' ? 'selected' : '' ?>>Sunday</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="start_time">Start Time *</label>
                            <input type="time" name="start_time" id="start_time" class="form-control" value="<?= e($schedule['start_time']) ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="end_time">End Time *</label>
                            <input type="time" name="end_time" id="end_time" class="form-control" value="<?= e($schedule['end_time']) ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="status">Status *</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="scheduled" <?= $schedule['status'] == 'scheduled' ? 'selected' : '' ?>>Scheduled</option>
                                <option value="completed" <?= $schedule['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
                                <option value="cancelled" <?= $schedule['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Schedule</button>
                        <a href="<?= url('/admin/assistant-schedules') ?>" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>

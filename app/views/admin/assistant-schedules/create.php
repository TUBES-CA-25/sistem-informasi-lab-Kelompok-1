<?php $title = 'Create Assistant Schedule'; $adminLayout = true; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="admin-layout antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>
    
    <main class="p-4 sm:ml-64 pt-10">
    <div class="max-w-3xl mx-auto">
    <div class="main-content">
        <div class="admin-navbar">
            <div class="admin-navbar-brand">Create Assistant Schedule</div>
            <div class="admin-navbar-actions">
                <a href="<?= url('/admin/assistant-schedules') ?>" class="btn btn-secondary">Back</a>
            </div>
        </div>
        
        <div class="admin-content">
            <?php displayFlash(); ?>
            
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="<?= url('/admin/assistant-schedules/create') ?>">
                        <div class="form-group">
                            <label for="user_id">Assistant *</label>
                            <select name="user_id" id="user_id" class="form-control" required>
                                <option value="">-- Select Assistant --</option>
                                <?php foreach ($assistants as $assistant): ?>
                                    <option value="<?= $assistant['id'] ?>"><?= e($assistant['name']) ?> (<?= e($assistant['email']) ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="day">Day *</label>
                            <select name="day" id="day" class="form-control" required>
                                <option value="">-- Select Day --</option>
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                                <option value="Saturday">Saturday</option>
                                <option value="Sunday">Sunday</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="start_time">Start Time *</label>
                            <input type="time" name="start_time" id="start_time" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="end_time">End Time *</label>
                            <input type="time" name="end_time" id="end_time" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="status">Status *</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="scheduled">Scheduled</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Create Schedule</button>
                        <a href="<?= url('/admin/assistant-schedules') ?>" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    </main>
</div>


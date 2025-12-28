<?php $title = 'Create Schedule'; $adminLayout = true; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="admin-layout">
    <?php include APP_PATH . '/views/layouts/admin-sidebar.php'; ?>
    
    <div class="main-content">
        <div class="admin-navbar">
            <div class="admin-navbar-brand">Create Schedule</div>
            <div class="admin-navbar-profile">
                <span><?= e(getUserName()) ?></span>
            </div>
        </div>
        
        <div class="admin-content">
            <?php displayFlash(); ?>
            
            <div class="card" style="max-width: 600px;">
                <form method="POST" action="<?= url('/admin/schedules/create') ?>">
                    <div class="form-group">
                        <label class="form-label">Laboratory *</label>
                        <select name="laboratory_id" class="form-control" required>
                            <option value="">Select Laboratory</option>
                            <?php foreach ($laboratories as $lab): ?>
                                <option value="<?= $lab['id'] ?>"><?= e($lab['lab_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Day *</label>
                        <select name="day" class="form-control" required>
                            <option value="">Select Day</option>
                            <option value="Monday">Senin</option>
                            <option value="Tuesday">Selasa</option>
                            <option value="Wednesday">Rabu</option>
                            <option value="Thursday">Kamis</option>
                            <option value="Friday">Jumat</option>
                            <option value="Saturday">Sabtu</option>
                            <option value="Sunday">Minggu</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Start Time *</label>
                        <input type="time" name="start_time" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">End Time *</label>
                        <input type="time" name="end_time" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Course *</label>
                        <input type="text" name="course" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Lecturer</label>
                        <input type="text" name="lecturer" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Assistant</label>
                        <input type="text" name="assistant" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Participant Count</label>
                        <input type="number" name="participant_count" class="form-control" value="0">
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Create Schedule</button>
                        <a href="<?= url('/admin/schedules') ?>" class="btn" style="background: #64748b; color: white;">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>

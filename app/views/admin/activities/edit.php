<?php $title = 'Edit Lab Activity'; $adminLayout = true; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="admin-layout">
    <?php include APP_PATH . '/views/layouts/admin-sidebar.php'; ?>
    
    <div class="main-content">
        <div class="admin-navbar">
            <div class="admin-navbar-brand">Edit Lab Activity</div>
            <div class="admin-navbar-actions">
                <a href="<?= url('/admin/activities') ?>" class="btn btn-secondary">Back</a>
            </div>
        </div>
        
        <div class="admin-content">
            <?php displayFlash(); ?>
            
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="<?= url('/admin/activities/' . $activity['id'] . '/edit') ?>">
                        <div class="form-group">
                            <label for="title">Title *</label>
                            <input type="text" name="title" id="title" class="form-control" value="<?= e($activity['title']) ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="activity_type">Activity Type *</label>
                            <select name="activity_type" id="activity_type" class="form-control" required>
                                <option value="">-- Select Type --</option>
                                <option value="praktikum" <?= $activity['activity_type'] == 'praktikum' ? 'selected' : '' ?>>Praktikum</option>
                                <option value="workshop" <?= $activity['activity_type'] == 'workshop' ? 'selected' : '' ?>>Workshop</option>
                                <option value="seminar" <?= $activity['activity_type'] == 'seminar' ? 'selected' : '' ?>>Seminar</option>
                                <option value="maintenance" <?= $activity['activity_type'] == 'maintenance' ? 'selected' : '' ?>>Maintenance</option>
                                <option value="other" <?= $activity['activity_type'] == 'other' ? 'selected' : '' ?>>Other</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="activity_date">Activity Date *</label>
                            <input type="date" name="activity_date" id="activity_date" class="form-control" value="<?= e($activity['activity_date']) ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="location">Location *</label>
                            <input type="text" name="location" id="location" class="form-control" value="<?= e($activity['location']) ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="4"><?= e($activity['description']) ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="status">Status *</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="draft" <?= $activity['status'] == 'draft' ? 'selected' : '' ?>>Draft</option>
                                <option value="published" <?= $activity['status'] == 'published' ? 'selected' : '' ?>>Published</option>
                                <option value="cancelled" <?= $activity['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Activity</button>
                        <a href="<?= url('/admin/activities') ?>" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>

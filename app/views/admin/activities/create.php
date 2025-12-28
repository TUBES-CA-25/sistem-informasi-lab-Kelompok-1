<?php $title = 'Create Lab Activity'; $adminLayout = true; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="admin-layout">
    <?php include APP_PATH . '/views/layouts/admin-sidebar.php'; ?>
    
    <div class="main-content">
        <div class="admin-navbar">
            <div class="admin-navbar-brand">Create Lab Activity</div>
            <div class="admin-navbar-actions">
                <a href="<?= url('/admin/activities') ?>" class="btn btn-secondary">Back</a>
            </div>
        </div>
        
        <div class="admin-content">
            <?php displayFlash(); ?>
            
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="<?= url('/admin/activities/create') ?>">
                        <div class="form-group">
                            <label for="title">Title *</label>
                            <input type="text" name="title" id="title" class="form-control" required placeholder="e.g., Workshop Python Programming">
                        </div>

                        <div class="form-group">
                            <label for="activity_type">Activity Type *</label>
                            <select name="activity_type" id="activity_type" class="form-control" required>
                                <option value="">-- Select Type --</option>
                                <option value="praktikum">Praktikum</option>
                                <option value="workshop">Workshop</option>
                                <option value="seminar">Seminar</option>
                                <option value="maintenance">Maintenance</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="activity_date">Activity Date *</label>
                            <input type="date" name="activity_date" id="activity_date" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="location">Location *</label>
                            <input type="text" name="location" id="location" class="form-control" required placeholder="e.g., Lab Komputer 1">
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="4" placeholder="Activity description..."></textarea>
                        </div>

                        <div class="form-group">
                            <label for="status">Status *</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Create Activity</button>
                        <a href="<?= url('/admin/activities') ?>" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>

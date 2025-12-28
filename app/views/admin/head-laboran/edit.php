<?php $title = 'Edit Head Laboran'; $adminLayout = true; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="admin-layout">
    <?php include APP_PATH . '/views/layouts/admin-sidebar.php'; ?>
    
    <div class="main-content">
        <div class="admin-navbar">
            <div class="admin-navbar-brand">Edit Head Laboran</div>
            <div class="admin-navbar-actions">
                <a href="<?= url('/admin/head-laboran') ?>" class="btn btn-secondary">Back</a>
            </div>
        </div>
        
        <div class="admin-content">
            <?php displayFlash(); ?>
            
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="<?= url('/admin/head-laboran/' . $headLaboran['id'] . '/edit') ?>" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="user_id">User (Coordinator) *</label>
                            <select name="user_id" id="user_id" class="form-control" required>
                                <option value="">-- Select User --</option>
                                <?php foreach ($users as $user): ?>
                                    <option value="<?= $user['id'] ?>" <?= $headLaboran['user_id'] == $user['id'] ? 'selected' : '' ?>>
                                        <?= e($user['name']) ?> (<?= e($user['email']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="photo">Photo</label>
                            <?php if (!empty($headLaboran['photo'])): ?>
                                <div style="margin-bottom: 1rem;">
                                    <img src="<?= asset($headLaboran['photo']) ?>" alt="Current Photo" style="width: 150px; height: 150px; border-radius: 8px; object-fit: cover;">
                                    <p style="margin-top: 0.5rem; color: #64748b; font-size: 0.875rem;">Current photo</p>
                                </div>
                            <?php endif; ?>
                            <input type="file" name="photo" id="photo" class="form-control" accept="image/*">
                            <small class="text-muted">Upload new photo to replace (JPG, PNG, max 2MB)</small>
                        </div>

                        <div class="form-group">
                            <label for="location">Location *</label>
                            <input type="text" name="location" id="location" class="form-control" value="<?= e($headLaboran['location']) ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="time_in">Time In *</label>
                            <input type="time" name="time_in" id="time_in" class="form-control" value="<?= e($headLaboran['time_in']) ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="status">Status *</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="active" <?= $headLaboran['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                                <option value="inactive" <?= $headLaboran['status'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Head Laboran</button>
                        <a href="<?= url('/admin/head-laboran') ?>" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>

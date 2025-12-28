<?php $title = 'Create Head Laboran'; $adminLayout = true; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="admin-layout">
    <?php include APP_PATH . '/views/layouts/admin-sidebar.php'; ?>
    
    <div class="main-content">
        <div class="admin-navbar">
            <div class="admin-navbar-brand">Create Head Laboran</div>
            <div class="admin-navbar-actions">
                <a href="<?= url('/admin/head-laboran') ?>" class="btn btn-secondary">Back</a>
            </div>
        </div>
        
        <div class="admin-content">
            <?php displayFlash(); ?>
            
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="<?= url('/admin/head-laboran/create') ?>" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="user_id">User (Coordinator) *</label>
                            <select name="user_id" id="user_id" class="form-control" required>
                                <option value="">-- Select User --</option>
                                <?php foreach ($users as $user): ?>
                                    <option value="<?= $user['id'] ?>"><?= e($user['name']) ?> (<?= e($user['email']) ?>)</option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-muted">Select a coordinator to be head laboran</small>
                        </div>

                        <div class="form-group">
                            <label for="photo">Photo</label>
                            <input type="file" name="photo" id="photo" class="form-control" accept="image/*">
                            <small class="text-muted">Upload photo (JPG, PNG, max 2MB)</small>
                        </div>

                        <div class="form-group">
                            <label for="location">Location *</label>
                            <input type="text" name="location" id="location" class="form-control" required placeholder="e.g., Lab Komputer 1">
                        </div>

                        <div class="form-group">
                            <label for="time_in">Time In *</label>
                            <input type="time" name="time_in" id="time_in" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="status">Status *</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Create Head Laboran</button>
                        <a href="<?= url('/admin/head-laboran') ?>" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>

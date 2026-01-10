<?php $title = 'Create Laboratory'; $adminLayout = true; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="admin-layout antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>
    
    <main class="p-4 sm:ml-64 pt-10">
    <div class="max-w-4xl mx-auto">
    <div class="main-content">
        <div class="admin-navbar">
            <div class="admin-navbar-brand">Create Laboratory</div>
            <div class="admin-navbar-profile">
                <span><?= e(getUserName()) ?></span>
            </div>
        </div>
        
        <div class="admin-content">
            <?php displayFlash(); ?>
            
            <div class="card" style="max-width: 600px;">
                <form method="POST" action="<?= url('/admin/laboratories/create') ?>">
                    <div class="form-group">
                        <label class="form-label">Laboratory Name *</label>
                        <input type="text" name="lab_name" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Location *</label>
                        <input type="text" name="location" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Create Laboratory</button>
                        <a href="<?= url('/admin/laboratories') ?>" class="btn" style="background: #64748b; color: white;">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </main>
</div>


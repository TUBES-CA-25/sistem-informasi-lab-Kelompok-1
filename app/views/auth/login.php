<?php $title = 'Login'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="container" style="max-width: 450px; margin-top: 100px;">
    <div class="card">
        <div class="card-header text-center">
            <h2>ICLABS Login</h2>
            <p>Laboratory Information System</p>
        </div>
        
        <?php displayFlash(); ?>
        
        <form method="POST" action="<?= url('/auth/login') ?>">
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>
            </div>
        </form>
        
        <div class="text-center" style="margin-top: 1rem;">
            <a href="<?= url('/') ?>">Back to Home</a>
        </div>
    </div>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>

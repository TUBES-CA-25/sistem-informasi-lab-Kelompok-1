<?php $title = 'Report Problem'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div style="display: flex; min-height: 100vh;">
    <div style="width: 250px; background: #1e293b; color: white; padding: 1.5rem;">
        <div style="font-size: 1.5rem; font-weight: bold; margin-bottom: 2rem;">ICLABS</div>
        <ul style="list-style: none; padding: 0;">
            <li style="margin-bottom: 0.5rem;"><a href="<?= url('/asisten/dashboard') ?>" style="color: #cbd5e1; text-decoration: none; display: block; padding: 0.5rem;">Dashboard</a></li>
            <li style="margin-bottom: 0.5rem;"><a href="<?= url('/asisten/report-problem') ?>" style="color: white; text-decoration: none; display: block; padding: 0.5rem; background: #334155; border-radius: 0.25rem;">Report Problem</a></li>
            <li style="margin-bottom: 0.5rem;"><a href="<?= url('/asisten/my-reports') ?>" style="color: #cbd5e1; text-decoration: none; display: block; padding: 0.5rem;">My Reports</a></li>
            <li><a href="<?= url('/logout') ?>" style="color: #cbd5e1; text-decoration: none; display: block; padding: 0.5rem;">Logout</a></li>
        </ul>
    </div>
    
    <div style="flex: 1; background: #f8fafc;">
        <div style="background: white; padding: 1rem 2rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <h2>Report Problem</h2>
        </div>
        
        <div style="padding: 2rem;">
            <?php displayFlash(); ?>
            
            <div class="card" style="max-width: 600px;">
                <form method="POST" action="<?= url('/asisten/report-problem') ?>">
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
                        <label class="form-label">PC Number</label>
                        <input type="text" name="pc_number" class="form-control" placeholder="e.g., PC-01">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Problem Type *</label>
                        <select name="problem_type" class="form-control" required>
                            <option value="">Select Type</option>
                            <option value="hardware">Hardware</option>
                            <option value="software">Software</option>
                            <option value="network">Network</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Description *</label>
                        <textarea name="description" class="form-control" rows="5" required minlength="10"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Submit Report</button>
                        <a href="<?= url('/asisten/dashboard') ?>" class="btn" style="background: #64748b; color: white;">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>

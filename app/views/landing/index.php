<?php $title = 'Home'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<!-- Hero Section -->
<section style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 4rem 0; text-align: center;">
    <div class="container">
        <h1 style="font-size: 3rem; margin-bottom: 1rem;">ICLABS</h1>
        <p style="font-size: 1.25rem; margin-bottom: 2rem;">Laboratory Information System</p>
        <a href="<?= url('/schedule') ?>" class="btn" style="background: white; color: #667eea;">View Schedules</a>
    </div>
</section>

<!-- Today's Schedule -->
<section style="padding: 3rem 0;">
    <div class="container">
        <h2 style="text-align: center; margin-bottom: 2rem;">Jadwal Hari Ini</h2>
        
        <?php if (!empty($todaySchedules)): ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                <?php foreach ($todaySchedules as $schedule): ?>
                    <div class="card">
                        <h3><?= e($schedule['course']) ?></h3>
                        <p><strong>Lab:</strong> <?= e($schedule['lab_name']) ?></p>
                        <p><strong>Waktu:</strong> <?= formatTime($schedule['start_time']) ?> - <?= formatTime($schedule['end_time']) ?></p>
                        <p><strong>Dosen:</strong> <?= e($schedule['lecturer']) ?></p>
                        <p><strong>Asisten:</strong> <?= e($schedule['assistant']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p style="text-align: center; color: #64748b;">Tidak ada jadwal hari ini</p>
        <?php endif; ?>
    </div>
</section>

<!-- Laboratory Management -->
<section id="laboratory-management" style="background: #f8fafc; padding: 3rem 0;">
    <div class="container">
        <h2 style="text-align: center; margin-bottom: 2rem;">Laboratory Management</h2>
        
        <!-- Head Laboran -->
        <div style="margin-bottom: 3rem;">
            <h3 style="margin-bottom: 1.5rem;">Head Laboran</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                <?php if (!empty($headLaboran)): ?>
                    <?php foreach ($headLaboran as $head): ?>
                        <div class="card" style="text-align: center;">
                            <?php if (!empty($head['photo'])): ?>
                                <img src="<?= url($head['photo']) ?>" alt="<?= e($head['name']) ?>" style="width: 100px; height: 100px; border-radius: 50%; margin: 0 auto 1rem;">
                            <?php else: ?>
                                <div style="width: 100px; height: 100px; border-radius: 50%; background: #e2e8f0; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: #64748b;">
                                    <?= strtoupper(substr($head['name'], 0, 1)) ?>
                                </div>
                            <?php endif; ?>
                            <h4><?= e($head['name']) ?></h4>
                            <p><?= getStatusBadge($head['status']) ?></p>
                            <?php if (!empty($head['location'])): ?>
                                <p><small><?= e($head['location']) ?></small></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: #64748b;">No head laboran available</p>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Recent Activities -->
        <div>
            <h3 style="margin-bottom: 1.5rem;">Kegiatan Laboratorium</h3>
            <?php if (!empty($recentActivities)): ?>
                <div style="display: grid; gap: 1rem;">
                    <?php foreach ($recentActivities as $activity): ?>
                        <div class="card">
                            <h4><?= e($activity['title']) ?></h4>
                            <p><strong>Jenis:</strong> <?= getActivityTypeLabel($activity['activity_type']) ?></p>
                            <p><strong>Tanggal:</strong> <?= formatDate($activity['activity_date']) ?></p>
                            <p><strong>Lokasi:</strong> <?= e($activity['location']) ?></p>
                            <p><?= e($activity['description']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p style="color: #64748b;">No recent activities</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Footer -->
<footer style="background: #1e293b; color: white; padding: 2rem 0; text-align: center;">
    <div class="container">
        <p>&copy; <?= date('Y') ?> ICLABS - Laboratory Information System</p>
    </div>
</footer>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>

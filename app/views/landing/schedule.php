<?php $title = 'Laboratory Schedule'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="container" style="padding: 2rem 0;">
    <h1 style="margin-bottom: 2rem;">Laboratory Schedule</h1>
    
    <?php if (!empty($schedules)): ?>
        <div class="card">
            <table class="table">
                <thead>
                    <tr>
                        <th>Day</th>
                        <th>Time</th>
                        <th>Laboratory</th>
                        <th>Course</th>
                        <th>Lecturer</th>
                        <th>Assistant</th>
                        <th>Participants</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($schedules as $schedule): ?>
                        <tr>
                            <td><?= getDayName($schedule['day']) ?></td>
                            <td><?= formatTime($schedule['start_time']) ?> - <?= formatTime($schedule['end_time']) ?></td>
                            <td><?= e($schedule['lab_name']) ?><br><small><?= e($schedule['location']) ?></small></td>
                            <td><?= e($schedule['course']) ?></td>
                            <td><?= e($schedule['lecturer']) ?></td>
                            <td><?= e($schedule['assistant']) ?></td>
                            <td><?= e($schedule['participant_count']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="card">
            <p style="text-align: center; color: #64748b;">No schedules available</p>
        </div>
    <?php endif; ?>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>

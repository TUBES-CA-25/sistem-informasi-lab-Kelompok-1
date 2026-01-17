<?php $title = 'Jadwal Piket'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-6">
            <h1 class="text-3xl font-extrabold text-slate-900">Jadwal Piket Asisten</h1>
            <p class="text-slate-500 mt-1">Jadwal piket semua asisten laboratorium minggu ini</p>
        </div>

        <?php displayFlash(); ?>

        <!-- Schedule Grid -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm border-collapse">
                    <thead>
                        <tr class="bg-gradient-to-r from-emerald-500 to-emerald-600 text-white">
                            <th class="px-4 py-3 text-left font-bold border-r border-emerald-400">TUGAS</th>
                            <?php
                            $days = ['Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'];
                            foreach ($days as $dayEn => $dayId):
                            ?>
                                <th class="px-4 py-3 text-center font-bold border-r border-emerald-400"><?= $dayId ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Group schedules by task and day
                        $scheduleGrid = [];
                        foreach ($allSchedules as $schedule) {
                            $task = $schedule['task_description'] ?? 'Piket Laboratorium';
                            $day = $schedule['day'];
                            $assistant = $schedule['assistant_name'];
                            $time = date('H:i', strtotime($schedule['start_time'])) . '-' . date('H:i', strtotime($schedule['end_time']));
                            
                            if (!isset($scheduleGrid[$task])) {
                                $scheduleGrid[$task] = [];
                            }
                            if (!isset($scheduleGrid[$task][$day])) {
                                $scheduleGrid[$task][$day] = [];
                            }
                            $scheduleGrid[$task][$day][] = [
                                'name' => $assistant,
                                'time' => $time,
                                'user_id' => $schedule['user_id']
                            ];
                        }
                        
                        // If no schedule data, create default rows
                        if (empty($scheduleGrid)) {
                            $scheduleGrid = [
                                'Piket Laboratorium' => [],
                                'Maintenance PC' => [],
                                'Cleaning Lab' => []
                            ];
                        }
                        
                        foreach ($scheduleGrid as $taskName => $taskDays):
                        ?>
                            <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                                <td class="px-4 py-3 font-bold text-slate-700 bg-slate-50 border-r border-slate-200">
                                    <i class="bi bi-clipboard-check text-emerald-600 mr-1"></i>
                                    <?= e($taskName) ?>
                                </td>
                                <?php foreach ($days as $dayEn => $dayId): ?>
                                    <td class="px-2 py-3 text-center border-r border-slate-100 align-top">
                                        <?php if (isset($taskDays[$dayEn]) && !empty($taskDays[$dayEn])): ?>
                                            <?php foreach ($taskDays[$dayEn] as $assignment): ?>
                                                <?php
                                                $isCurrentUser = ($assignment['user_id'] == getUserId());
                                                $badgeClass = $isCurrentUser 
                                                    ? 'bg-emerald-100 text-emerald-700 border-emerald-300 font-bold' 
                                                    : 'bg-slate-100 text-slate-600 border-slate-200';
                                                ?>
                                                <div class="inline-block mb-1">
                                                    <span class="px-2 py-1 rounded-lg text-xs border <?= $badgeClass ?> block">
                                                        <?php if ($isCurrentUser): ?>
                                                            <i class="bi bi-star-fill text-emerald-500"></i>
                                                        <?php endif; ?>
                                                        <?= e($assignment['name']) ?>
                                                    </span>
                                                    <span class="text-[10px] text-slate-400 font-mono"><?= $assignment['time'] ?></span>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <span class="text-slate-300 text-xs">-</span>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Legend -->
        <div class="mt-6 bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200 rounded-xl p-4">
            <div class="flex flex-wrap items-center gap-6">
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1.5 bg-emerald-100 text-emerald-700 border border-emerald-300 rounded-lg text-xs font-bold">
                        <i class="bi bi-star-fill text-emerald-500"></i> Nama Anda
                    </span>
                    <span class="text-sm text-slate-600">= Jadwal piket Anda</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1.5 bg-slate-100 text-slate-600 border border-slate-200 rounded-lg text-xs">
                        Nama Lain
                    </span>
                    <span class="text-sm text-slate-600">= Jadwal asisten lain</span>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>
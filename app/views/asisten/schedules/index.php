<?php $title = 'Jadwal Piket Saya'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-[95%] mx-auto px-4">

        <div class="mb-8">
            <h1 class="text-2xl font-bold text-slate-800">Jadwal Piket Laboratorium</h1>
            <p class="text-slate-500 mt-1">Berikut adalah jadwal piket mingguan dan rincian tugas.</p>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-center border-collapse">
                    <thead class="bg-slate-100 text-slate-700 border-b-2 border-slate-200 uppercase text-xs font-bold">
                        <tr>
                            <th class="px-4 py-4 w-1/6 border-r border-slate-200 bg-slate-200">Tugas / Role</th>
                            <?php foreach ($days as $day): ?>
                            <?php
                                $dayNames = ['Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'];
                                ?>
                            <th class="px-2 py-3 border-r border-slate-200 min-w-[120px]"><?= $dayNames[$day] ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200">
                        <?php foreach (['Putri', 'Putra'] as $role): ?>
                        <?php
                            $theme = ($role == 'Putri') ? 'bg-rose-50 border-rose-100 text-rose-900' : 'bg-emerald-50 border-emerald-100 text-emerald-900';
                            $jobText = $masterJob[$role];
                            ?>
                        <tr>
                            <td
                                class="p-4 border-r border-slate-200 border-b border-slate-100 align-middle text-left <?= $theme ?>">
                                <span
                                    class="font-bold text-sm uppercase tracking-wider mb-2 border-b border-black/10 pb-1 w-fit block">
                                    Tugas <?= $role ?>
                                </span>
                                <p class="text-xs font-medium leading-relaxed whitespace-pre-line text-slate-700">
                                    <?= e($jobText) ?>
                                </p>
                            </td>

                            <?php foreach ($days as $day): ?>
                            <td class="p-2 align-top border-r border-slate-100 border-b border-slate-100 h-full">
                                <div class="flex flex-col gap-2 h-full">
                                    <?php if (!empty($matrix[$role][$day])): ?>
                                    <?php foreach ($matrix[$role][$day] as $sched): ?>
                                    <?php
                                                    // Highlight jika ini jadwal user yang sedang login
                                                    $isMe = ($sched['user_id'] == $currentUserId);
                                                    $cardClass = $isMe
                                                        ? 'bg-sky-100 border-sky-300 shadow-md transform scale-105 z-10'
                                                        : 'bg-white border-slate-200 hover:border-slate-300';
                                                    ?>

                                    <div
                                        class="relative border rounded-lg p-2 transition-all text-left <?= $cardClass ?>">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center text-[10px] font-bold text-slate-500 border border-slate-200">
                                                <?= substr($sched['assistant_name'], 0, 1) ?>
                                            </div>
                                            <div class="overflow-hidden">
                                                <span class="text-xs font-semibold text-slate-700 truncate block">
                                                    <?= explode(' ', $sched['assistant_name'])[0] ?>
                                                </span>
                                                <?php if ($isMe): ?>
                                                <span
                                                    class="text-[9px] font-bold text-sky-600 bg-sky-50 px-1 rounded uppercase tracking-wide">
                                                    It's You
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <span class="text-slate-200 text-2xl font-light mt-4 block">-</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <?php endforeach; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 flex items-center gap-2 text-xs text-slate-500">
            <span class="w-3 h-3 bg-sky-100 border border-sky-300 rounded block"></span>
            <span>Menandakan jadwal piket Anda.</span>
        </div>

    </div>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>
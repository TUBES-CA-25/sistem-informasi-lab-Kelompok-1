<?php
$title = 'Status Kehadiran Laboran';

// LOGIC: Memisahkan Kepala Lab dan Staff
$leaders = [];
$staff = [];

if (!empty($presenceList)) {
    foreach ($presenceList as $person) {
        // Filter berdasarkan kata "Kepala" pada jabatan
        if (stripos($person['position'], 'Kepala') !== false) {
            $leaders[] = $person;
        } else {
            $staff[] = $person;
        }
    }
}
?>

<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-slate-50 min-h-screen pb-20">
    <div class="bg-white border-b border-slate-200 pt-10 pb-8 mb-10 text-center">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-2">Management Presence</h1>
            <p class="text-slate-500 max-w-2xl mx-auto">Pantau ketersediaan Kepala Laboratorium dan Staff Laboran secara real-time.</p>
        </div>
    </div>

    <div class="container mx-auto px-4">

        <div class="mb-16 text-center">
            <div class="flex items-center justify-center mb-8">
                <span class="h-px w-12 bg-slate-300"></span>
                <h2 class="px-4 text-lg font-bold text-slate-400 uppercase tracking-widest">Kepala Laboratorium</h2>
                <span class="h-px w-12 bg-slate-300"></span>
            </div>

            <div class="flex flex-wrap justify-center gap-8">
                <?php if (!empty($leaders)): ?>
                    <?php foreach ($leaders as $person): renderPresenceCard($person, true);
                    endforeach; ?>
                <?php else: ?>
                    <p class="text-slate-400 italic">Data Kepala Lab belum tersedia.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="text-center">
            <div class="flex items-center justify-center mb-8">
                <span class="h-px w-12 bg-slate-300"></span>
                <h2 class="px-4 text-lg font-bold text-slate-400 uppercase tracking-widest">Staff & Laboran</h2>
                <span class="h-px w-12 bg-slate-300"></span>
            </div>

            <div class="flex flex-wrap justify-center gap-6">
                <?php if (!empty($staff)): ?>
                    <?php foreach ($staff as $person): renderPresenceCard($person, false);
                    endforeach; ?>
                <?php else: ?>
                    <div class="w-full text-center py-10">
                        <p class="text-slate-400 italic">Data Staff belum tersedia.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<?php
// FUNGSI RENDER CARD
function renderPresenceCard($person, $isLeader)
{
    $isAvailable = ($person['status'] === 'active');

    // Warna & Style Berdasarkan Status
    $statusColor = $isAvailable ? 'emerald' : 'rose'; // Hijau / Merah
    $cardBorder = $isAvailable ? 'border-emerald-400 shadow-emerald-100 ring-1 ring-emerald-50' : 'border-slate-200';
    $statusText = $isAvailable ? 'READY' : 'TIDAK DI TEMPAT';
    $statusIcon = $isAvailable ? 'bi-check-circle-fill' : 'bi-x-circle-fill';

    // Ukuran Card & Avatar (DIPERBESAR)
    // Leader: w-32 (128px), Staff: w-24 (96px)
    $avatarSize = $isLeader ? 'w-32 h-32 text-5xl' : 'w-24 h-24 text-3xl';
    $cardWidth = 'w-full sm:w-[320px]'; // Lebar kartu fixed agar rapi saat berjejer

?>
    <div class="<?= $cardWidth ?> relative group bg-white rounded-2xl border-t-4 <?= $cardBorder ?> shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col items-center">

        <div class="absolute top-0 right-0 z-10">
            <div class="bg-<?= $statusColor ?>-50 text-<?= $statusColor ?>-600 text-[10px] font-bold px-3 py-1 rounded-bl-xl border-l border-b border-<?= $statusColor ?>-100 uppercase tracking-wide flex items-center shadow-sm">
                <i class="bi <?= $statusIcon ?> mr-1.5 text-xs"></i> <?= $statusText ?>
            </div>
        </div>

        <div class="p-6 w-full text-center flex flex-col items-center">
            <div class="<?= $avatarSize ?> rounded-full bg-slate-50 border-4 border-white shadow-lg flex items-center justify-center text-slate-300 font-bold mb-5 group-hover:scale-105 transition-transform duration-300 relative">
                <?php if (!empty($person['photo'])): ?>
                    <img src="<?= e($person['photo']) ?>" alt="<?= e($person['name']) ?>" class="w-full h-full rounded-full object-cover">
                <?php else: ?>
                    <?= strtoupper(substr($person['name'], 0, 1)) ?>
                <?php endif; ?>

                <div class="absolute bottom-1 right-1 w-5 h-5 bg-<?= $statusColor ?>-500 border-4 border-white rounded-full"></div>
            </div>

            <h3 class="text-xl font-bold text-slate-800 mb-1 leading-tight px-2"><?= e($person['name']) ?></h3>
            <p class="text-sm font-medium text-sky-600 mb-5 bg-sky-50 px-3 py-1 rounded-full inline-block">
                <?= e($person['position']) ?>
            </p>

            <div class="w-full space-y-3 text-left bg-slate-50 p-4 rounded-xl border border-slate-100 text-sm">
                <div class="flex items-start justify-center text-center">
                    <div class="text-slate-600 font-medium flex items-center gap-2">
                        <i class="bi bi-geo-alt-fill text-slate-400"></i>
                        <?= e($person['location'] ?? '-') ?>
                    </div>
                </div>

                <div class="border-t border-slate-200 my-2"></div>

                <?php if ($isAvailable): ?>
                    <div class="flex flex-col items-center text-center">
                        <span class="text-xs text-slate-400 mb-1">Jam Masuk</span>
                        <div class="font-bold text-emerald-600 text-lg flex items-center gap-1">
                            <i class="bi bi-clock-history"></i>
                            <?= !empty($person['time_in']) ? formatTime($person['time_in']) : '-' ?>
                        </div>
                    </div>
                    <div class="text-center mt-2">
                        <p class="text-xs text-slate-500 italic bg-white px-2 py-1 rounded border border-slate-100 inline-block">
                            "<?= e($person['notes'] ?? 'Standby di ruangan') ?>"
                        </p>
                    </div>
                <?php else: ?>
                    <div class="flex flex-col items-center text-center">
                        <span class="text-xs text-slate-400 mb-1">Estimasi Kembali</span>
                        <div class="font-bold text-rose-500 text-md flex items-center gap-1">
                            <i class="bi bi-calendar-event"></i>
                            <?= !empty($person['return_time']) ? formatDate($person['return_time']) : 'Belum ditentukan' ?>
                        </div>
                    </div>
                    <div class="text-center mt-2">
                        <p class="text-xs text-slate-500 italic bg-white px-2 py-1 rounded border border-slate-100 inline-block">
                            "<?= e($person['notes'] ?? 'Sedang tidak di tempat') ?>"
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="w-full bg-white px-6 py-4 border-t border-slate-100">
            <a href="mailto:<?= e($person['email']) ?>" class="w-full flex items-center justify-center gap-2 text-slate-600 hover:text-white hover:bg-sky-500 border border-slate-200 hover:border-sky-500 font-semibold rounded-lg text-sm px-4 py-2.5 transition-all duration-300">
                <i class="bi bi-envelope"></i> Hubungi
            </a>
        </div>
    </div>
<?php
}
?>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>
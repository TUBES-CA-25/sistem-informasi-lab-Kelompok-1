<?php
$title = 'Tim Laboratorium';

// LOGIC: Memisahkan Kepala Lab dan Staff berdasarkan Kategori Database
$leaders = [];
$staff = [];

// Helper Function untuk format nomor WA
function formatWaNumber($phone)
{
    if (empty($phone)) return null;
    $phone = preg_replace('/[^0-9]/', '', $phone);
    if (substr($phone, 0, 1) == '0') {
        $phone = '62' . substr($phone, 1);
    } elseif (substr($phone, 0, 2) != '62') {
        $phone = '62' . $phone;
    }
    return $phone;
}

if (!empty($presenceList)) {
    foreach ($presenceList as $person) {
        // LOGIKA BARU: Gunakan kolom 'category' dari database
        // Jika data lama belum punya category, anggap sebagai 'staff'
        $category = $person['category'] ?? 'staff';

        // Filter Strict
        if ($category === 'head') {
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
    <div class="bg-white border-b border-slate-200 pt-16 pb-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <span
                class="inline-block py-1 px-3 rounded-full bg-blue-50 text-blue-600 text-xs font-bold uppercase tracking-wider mb-4 border border-blue-100">
                Kontak & Kehadiran
            </span>
            <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-4 tracking-tight">
                Tim Laboratorium
            </h1>
            <p class="text-lg text-slate-500 max-w-2xl mx-auto leading-relaxed">
                Pantau ketersediaan Kepala Laboratorium dan Staff Laboran secara real-time.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 -mt-8">

        <div class="mb-16">
            <div class="flex items-center justify-center mb-8">
                <span class="h-px w-12 bg-slate-300"></span>
                <h2 class="px-4 text-lg font-bold text-slate-400 uppercase tracking-widest text-center">Kepala
                    Laboratorium</h2>
                <span class="h-px w-12 bg-slate-300"></span>
            </div>

            <div class="flex flex-wrap justify-center -mx-4">
                <?php if (!empty($leaders)): ?>
                <?php foreach ($leaders as $person): ?>
                <div class="w-full md:w-1/2 lg:w-1/3 px-4 mb-8">
                    <?php renderPresenceCard($person, true); ?>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <div
                    class="w-full text-center text-slate-400 italic py-10 bg-white rounded-xl border border-dashed border-slate-300 mx-4">
                    <i class="bi bi-people text-2xl mb-2 block"></i>
                    Data Kepala Lab belum diinput oleh Admin.
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div>
            <div class="flex items-center justify-center mb-8">
                <span class="h-px w-12 bg-slate-300"></span>
                <h2 class="px-4 text-lg font-bold text-slate-400 uppercase tracking-widest text-center">Staff & Laboran
                </h2>
                <span class="h-px w-12 bg-slate-300"></span>
            </div>

            <div class="flex flex-wrap justify-center -mx-3">
                <?php if (!empty($staff)): ?>
                <?php foreach ($staff as $person): ?>
                <div class="w-full md:w-1/2 lg:w-1/4 px-3 mb-6">
                    <?php renderPresenceCard($person, false); ?>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <div
                    class="w-full text-center text-slate-400 italic py-10 bg-white rounded-xl border border-dashed border-slate-300 mx-3">
                    <i class="bi bi-person-badge text-2xl mb-2 block"></i>
                    Data Staff belum diinput oleh Admin.
                </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<?php
/**
 * FUNGSI RENDER KARTU PRESENSI
 * @param array $person Data staff/kepala
 * @param bool $isLeader Apakah dia kategori pimpinan?
 */
function renderPresenceCard($person, $isLeader)
{
    $isAvailable = ($person['status'] === 'active');

    // Style Status
    $statusColor = $isAvailable ? 'emerald' : 'rose';
    $cardBorder = $isAvailable ? 'border-emerald-400 shadow-emerald-100 ring-1 ring-emerald-50' : 'border-slate-200';
    $statusText = $isAvailable ? 'READY' : 'OFFLINE';
    $statusIcon = $isAvailable ? 'bi-check-circle-fill' : 'bi-x-circle-fill';

    // Link WhatsApp Generator
    $phone = formatWaNumber($person['phone']);
    $hasPhone = !empty($phone);

    // Pesan WA berbeda untuk Kepala vs Staff
    $msg = $isLeader
        ? "Assalamu'alaikum " . $person['name'] . ", saya mahasiswa ingin berkonsultasi perihal..."
        : "Assalamu'alaikum " . $person['name'] . ", saya ingin bertanya teknis laboratorium.";

    $waLink = $hasPhone ? "https://wa.me/" . $phone . "?text=" . urlencode($msg) : "#";

    // Ukuran Avatar: Leader lebih besar
    $avatarSize = $isLeader ? 'w-32 h-32 text-5xl' : 'w-24 h-24 text-3xl';
?>
<div
    class="h-full group bg-white rounded-2xl border-t-4 <?= $cardBorder ?> shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col items-center relative">

    <div class="absolute top-0 right-0 z-10">
        <div
            class="bg-<?= $statusColor ?>-50 text-<?= $statusColor ?>-600 text-[10px] font-bold px-3 py-1 rounded-bl-xl border-l border-b border-<?= $statusColor ?>-100 uppercase tracking-wide flex items-center shadow-sm">
            <i class="bi <?= $statusIcon ?> mr-1.5 text-xs"></i> <?= $statusText ?>
        </div>
    </div>

    <div class="p-6 w-full text-center flex flex-col items-center flex-1">

        <div
            class="<?= $avatarSize ?> rounded-full bg-slate-50 border-4 border-white shadow-lg flex items-center justify-center text-slate-300 font-bold mb-5 group-hover:scale-105 transition-transform duration-300 relative">
            <?php
                $imgSrc = 'https://ui-avatars.com/api/?name=' . urlencode($person['name']) . '&background=random&color=fff';
                if (!empty($person['photo'])) {
                    // Cek apakah link di database sudah mengandung http/https
                    $imgSrc = (strpos($person['photo'], 'http') === 0) ? $person['photo'] : BASE_URL . $person['photo'];
                }
                ?>
            <img src="<?= $imgSrc ?>" alt="<?= e($person['name']) ?>" class="w-full h-full rounded-full object-cover">

            <div
                class="absolute bottom-1 right-1 w-5 h-5 bg-<?= $statusColor ?>-500 border-4 border-white rounded-full">
                <?php if ($isAvailable): ?><span
                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span><?php endif; ?>
            </div>
        </div>

        <h3
            class="text-lg font-bold text-slate-800 mb-1 leading-tight px-2 min-h-[50px] flex items-center justify-center line-clamp-2">
            <?= e($person['name']) ?>
        </h3>

        <div class="mb-5">
            <?php if ($isLeader): ?>
            <span
                class="text-sm font-bold text-amber-600 bg-amber-50 px-3 py-1 rounded-full border border-amber-100 shadow-sm">
                <i class="bi bi-star-fill text-xs mr-1"></i> <?= e($person['position']) ?>
            </span>
            <?php else: ?>
            <span class="text-sm font-medium text-sky-600 bg-sky-50 px-3 py-1 rounded-full border border-sky-100">
                <?= e($person['position']) ?>
            </span>
            <?php endif; ?>
        </div>

        <div class="w-full space-y-3 text-left bg-slate-50 p-4 rounded-xl border border-slate-100 text-sm mt-auto">
            <div class="flex items-center justify-center text-center gap-2 text-slate-600 font-medium">
                <i class="bi bi-geo-alt-fill text-slate-400"></i>
                <?= e($person['location'] ?? '-') ?>
            </div>

            <?php if ($isAvailable): ?>
            <div class="text-center text-xs text-slate-400 pt-2 border-t border-slate-200">
                Masuk: <?= !empty($person['time_in']) ? date('H:i', strtotime($person['time_in'])) : '-' ?>
            </div>
            <?php else: ?>
            <div class="text-center text-xs text-rose-400 pt-2 border-t border-rose-100">
                Kembali:
                <?= !empty($person['return_time']) ? date('H:i', strtotime($person['return_time'])) : 'Belum ditentukan' ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="w-full bg-white px-6 py-4 border-t border-slate-100 mt-auto">
        <?php if ($hasPhone): ?>
        <a href="<?= $waLink ?>" target="_blank"
            class="w-full flex items-center justify-center gap-2 text-white bg-emerald-500 hover:bg-emerald-600 border border-transparent shadow-lg shadow-emerald-500/30 font-bold rounded-xl text-sm px-4 py-3 transition-all duration-300 transform hover:scale-[1.02]">
            <i class="bi bi-whatsapp text-lg"></i> Hubungi
        </a>
        <?php else: ?>
        <button disabled
            class="w-full flex items-center justify-center gap-2 text-slate-400 bg-slate-100 border border-slate-200 font-bold rounded-xl text-sm px-4 py-3 cursor-not-allowed">
            <i class="bi bi-telephone-x text-lg"></i> Tidak Ada Nomor
        </button>
        <?php endif; ?>
    </div>
</div>
<?php
}
?>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>
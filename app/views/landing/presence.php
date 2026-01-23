<?php
$title = 'Tim Laboratorium';

// LOGIC: Memisahkan Kepala Lab dan Staff dari Database
$leaders = [];
$staff = [];

// Helper Function untuk format nomor WA
function formatWaNumber($phone)
{
    if (empty($phone)) return null;

    // Hapus karakter non-angka
    $phone = preg_replace('/[^0-9]/', '', $phone);

    // Jika diawali 0, ganti jadi 62
    if (substr($phone, 0, 1) == '0') {
        $phone = '62' . substr($phone, 1);
    }
    // Jika diawali 62, biarkan
    // Jika tidak diawali 62 (misal input 812...), tambahkan 62
    elseif (substr($phone, 0, 2) != '62') {
        $phone = '62' . $phone;
    }

    return $phone;
}

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
                <h2 class="px-4 text-lg font-bold text-slate-400 uppercase tracking-widest">Kepala Laboratorium</h2>
                <span class="h-px w-12 bg-slate-300"></span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 justify-center">
                <?php if (!empty($leaders)): ?>
                <?php foreach ($leaders as $person): renderPresenceCard($person, true);
                    endforeach; ?>
                <?php else: ?>
                <div class="col-span-3 text-center text-slate-400 italic py-10">Data Kepala Lab belum diinput oleh
                    Admin.</div>
                <?php endif; ?>
            </div>
        </div>

        <div>
            <div class="flex items-center justify-center mb-8">
                <span class="h-px w-12 bg-slate-300"></span>
                <h2 class="px-4 text-lg font-bold text-slate-400 uppercase tracking-widest">Staff & Laboran</h2>
                <span class="h-px w-12 bg-slate-300"></span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 justify-center">
                <?php if (!empty($staff)): ?>
                <?php foreach ($staff as $person): renderPresenceCard($person, false);
                    endforeach; ?>
                <?php else: ?>
                <div class="col-span-4 text-center text-slate-400 italic py-10">Data Staff belum diinput oleh Admin.
                </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<?php
// FUNGSI RENDER CARD (DINAMIS DARI DB)
function renderPresenceCard($person, $isLeader)
{
    $isAvailable = ($person['status'] === 'active');

    // Style Status
    $statusColor = $isAvailable ? 'emerald' : 'rose';
    $cardBorder = $isAvailable ? 'border-emerald-400 shadow-emerald-100 ring-1 ring-emerald-50' : 'border-slate-200';
    $statusText = $isAvailable ? 'READY' : 'OFFLINE';
    $statusIcon = $isAvailable ? 'bi-check-circle-fill' : 'bi-x-circle-fill';

    // Link WhatsApp Generator (Dari Database)
    $phone = formatWaNumber($person['phone']);
    $hasPhone = !empty($phone);

    $waLink = $hasPhone
        ? "https://wa.me/" . $phone . "?text=" . urlencode("Assalamu'alaikum " . $person['name'] . ", saya ingin bertanya perihal Laboratorium.")
        : "#";

    // Ukuran Avatar
    $avatarSize = $isLeader ? 'w-32 h-32 text-5xl' : 'w-24 h-24 text-3xl';
?>
<div
    class="group bg-white rounded-2xl border-t-4 <?= $cardBorder ?> shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col items-center relative">

    <div class="absolute top-0 right-0 z-10">
        <div
            class="bg-<?= $statusColor ?>-50 text-<?= $statusColor ?>-600 text-[10px] font-bold px-3 py-1 rounded-bl-xl border-l border-b border-<?= $statusColor ?>-100 uppercase tracking-wide flex items-center shadow-sm">
            <i class="bi <?= $statusIcon ?> mr-1.5 text-xs"></i> <?= $statusText ?>
        </div>
    </div>

    <div class="p-6 w-full text-center flex flex-col items-center">

        <div
            class="<?= $avatarSize ?> rounded-full bg-slate-50 border-4 border-white shadow-lg flex items-center justify-center text-slate-300 font-bold mb-5 group-hover:scale-105 transition-transform duration-300 relative">
            <?php if (!empty($person['photo'])): ?>
            <img src="<?= e($person['photo']) ?>" alt="<?= e($person['name']) ?>"
                class="w-full h-full rounded-full object-cover">
            <?php else: ?>
            <img src="https://ui-avatars.com/api/?name=<?= urlencode($person['name']) ?>&background=random&color=fff"
                class="w-full h-full rounded-full object-cover">
            <?php endif; ?>

            <div
                class="absolute bottom-1 right-1 w-5 h-5 bg-<?= $statusColor ?>-500 border-4 border-white rounded-full">
                <?php if ($isAvailable): ?><span
                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span><?php endif; ?>
            </div>
        </div>

        <h3
            class="text-lg font-bold text-slate-800 mb-1 leading-tight px-2 min-h-[50px] flex items-center justify-center">
            <?= e($person['name']) ?>
        </h3>
        <p
            class="text-sm font-medium text-sky-600 mb-5 bg-sky-50 px-3 py-1 rounded-full inline-block border border-sky-100">
            <?= e($person['position']) ?>
        </p>

        <div class="w-full space-y-3 text-left bg-slate-50 p-4 rounded-xl border border-slate-100 text-sm">
            <div class="flex items-center justify-center text-center gap-2 text-slate-600 font-medium">
                <i class="bi bi-geo-alt-fill text-slate-400"></i>
                <?= e($person['location'] ?? '-') ?>
            </div>

            <?php if ($isAvailable): ?>
            <div class="text-center text-xs text-slate-400 pt-2 border-t border-slate-200">
                Masuk: <?= !empty($person['time_in']) ? date('H:i', strtotime($person['time_in'])) : '-' ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="w-full bg-white px-6 py-4 border-t border-slate-100 mt-auto">
        <?php if ($hasPhone): ?>
        <a href="<?= $waLink ?>" target="_blank"
            class="w-full flex items-center justify-center gap-2 text-white bg-emerald-500 hover:bg-emerald-600 border border-transparent shadow-lg shadow-emerald-500/30 font-bold rounded-xl text-sm px-4 py-3 transition-all duration-300 transform hover:scale-[1.02]">
            <i class="bi bi-whatsapp text-lg"></i> Hubungi via WhatsApp
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
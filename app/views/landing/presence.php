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
        $category = $person['category'] ?? 'staff';
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
            <span class="inline-block py-1 px-3 rounded-full bg-blue-50 text-blue-600 text-xs font-bold uppercase tracking-wider mb-4 border border-blue-100">
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

    <div class="max-w-7xl mx-auto px-4 mt-8 md:mt-12">

        <div class="mb-12 md:mb-16">
            <div class="flex items-center justify-center mb-6 md:mb-8">
                <span class="h-px w-8 md:w-12 bg-slate-300"></span>
                <h2 class="px-4 text-sm md:text-lg font-bold text-slate-400 uppercase tracking-widest text-center">Kepala Laboratorium</h2>
                <span class="h-px w-8 md:w-12 bg-slate-300"></span>
            </div>

            <div class="flex flex-wrap justify-center -mx-4">
                <?php if (!empty($leaders)): ?>
                    <?php foreach ($leaders as $person): ?>
                        <div class="w-full md:w-1/2 lg:w-1/3 px-4 mb-6">
                            <?php renderPresenceCard($person, true); ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="w-full px-4">
                        <div class="text-center text-slate-400 italic py-10 bg-white rounded-xl border border-dashed border-slate-300">
                            <i class="bi bi-people text-2xl mb-2 block"></i>
                            Data Kepala Lab belum diinput oleh Admin.
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div>
            <div class="flex items-center justify-center mb-6 md:mb-8">
                <span class="h-px w-8 md:w-12 bg-slate-300"></span>
                <h2 class="px-4 text-sm md:text-lg font-bold text-slate-400 uppercase tracking-widest text-center">Staff & Laboran</h2>
                <span class="h-px w-8 md:w-12 bg-slate-300"></span>
            </div>

            <div class="flex flex-wrap justify-center -mx-4">
                <?php if (!empty($staff)): ?>
                    <?php foreach ($staff as $person): ?>
                        <div class="w-full md:w-1/2 lg:w-1/3 px-4 mb-6">
                            <?php renderPresenceCard($person, false); ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="w-full px-4">
                        <div class="text-center text-slate-400 italic py-10 bg-white rounded-xl border border-dashed border-slate-300">
                            <i class="bi bi-person-badge text-2xl mb-2 block"></i>
                            Data Staff belum diinput oleh Admin.
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<?php
/**
 * FUNGSI RENDER KARTU PRESENSI (RESPONSIVE)
 */
function renderPresenceCard($person, $isLeader)
{
    $isAvailable = ($person['status'] === 'active');
    
    // Style Variables
    $statusColor = $isAvailable ? 'emerald' : 'rose';
    $statusText = $isAvailable ? 'READY' : 'OFFLINE';
    $statusIcon = $isAvailable ? 'bi-check-lg' : 'bi-x-lg';
    $statusDotColor = $isAvailable ? 'bg-emerald-500' : 'bg-rose-500'; 
    
    // Mobile Border Logic (Hijau jika Ready, Abu jika Offline)
    $mobileBorder = $isAvailable ? 'border-emerald-400' : 'border-slate-200';

    // Desktop Border
    $cardBorder = $isAvailable ? 'border-emerald-400 shadow-emerald-100 ring-1 ring-emerald-50' : 'border-slate-200';

    // WA Logic
    $phone = formatWaNumber($person['phone']);
    $hasPhone = !empty($phone);
    $msg = $isLeader ? "Assalamu'alaikum " . $person['name'] . ", saya mahasiswa ingin berkonsultasi perihal..." : "Assalamu'alaikum " . $person['name'] . ", saya ingin bertanya teknis laboratorium.";
    $waLink = $hasPhone ? "https://wa.me/" . $phone . "?text=" . urlencode($msg) : "#";
    
    // Avatar Src
    $imgSrc = 'https://ui-avatars.com/api/?name=' . urlencode($person['name']) . '&background=random&color=fff';
    if (!empty($person['photo'])) {
        $imgSrc = (strpos($person['photo'], 'http') === 0) ? $person['photo'] : BASE_URL . $person['photo'];
    }

    // Role Style
    if ($isLeader) {
        $roleClass = "text-amber-600 bg-amber-50 border-amber-100";
    } else {
        $roleClass = "text-sky-600 bg-sky-50 border-sky-100";
    }
?>

    <div class="relative flex items-center p-5 bg-white rounded-3xl border-2 <?= $mobileBorder ?> shadow-sm md:hidden overflow-hidden">
        
        <div class="absolute top-0 right-0 z-10">
            <div class="bg-<?= $statusColor ?>-50 text-<?= $statusColor ?>-600 text-[10px] font-bold px-3 py-1 rounded-bl-2xl border-l border-b border-<?= $statusColor ?>-100 uppercase tracking-wide flex items-center">
                <i class="bi <?= $statusIcon ?> mr-1"></i> <?= $statusText ?>
            </div>
        </div>

        <div class="relative shrink-0 mr-4 self-center">
            <div class="w-16 h-16 rounded-full p-1 bg-white border border-slate-100 shadow-sm">
                <img src="<?= $imgSrc ?>" alt="<?= e($person['name']) ?>" class="w-full h-full rounded-full object-cover">
            </div>
            <div class="absolute bottom-1 right-0 w-4 h-4 <?= $statusDotColor ?> border-2 border-white rounded-full">
                <?php if ($isAvailable): ?><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span><?php endif; ?>
            </div>
        </div>

        <div class="flex-1 min-w-0 pr-2 pt-2">
            <h3 class="text-sm font-bold text-slate-900 truncate pr-4">
                <?= e($person['name']) ?>
            </h3>
            
            <div class="mt-1 mb-2">
                <span class="inline-block text-[10px] font-bold px-2 py-0.5 rounded border <?= $roleClass ?>">
                    <?= e($person['position']) ?>
                </span>
            </div>

            <div class="relative flex items-center bg-slate-50 rounded-lg px-2 py-1.5 border border-slate-100 max-w-[180px]">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center text-[10px] text-slate-500 font-medium truncate border-b border-slate-200 pb-0.5 mb-0.5">
                        <i class="bi bi-geo-alt-fill text-slate-400 mr-1"></i>
                        <?= e($person['location'] ?? '-') ?>
                    </div>
                    <div class="text-[10px] text-slate-400">
                        <?php if ($isAvailable): ?>
                            Masuk: <?= !empty($person['time_in']) ? date('H:i', strtotime($person['time_in'])) : '-' ?>
                        <?php else: ?>
                            Kembali: <?= !empty($person['return_time']) ? date('H:i', strtotime($person['return_time'])) : '-' ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute bottom-4 right-4">
            <?php if ($hasPhone): ?>
                <a href="<?= $waLink ?>" target="_blank" class="flex items-center justify-center w-9 h-9 bg-slate-50 text-slate-400 rounded-full border border-slate-200 shadow-sm active:scale-95 transition-transform hover:bg-emerald-500 hover:text-white hover:border-emerald-600">
                    <i class="bi bi-telephone-fill text-xs"></i>
                </a>
            <?php else: ?>
                <button disabled class="flex items-center justify-center w-9 h-9 bg-slate-50 text-slate-300 rounded-full border border-slate-100 cursor-not-allowed">
                    <i class="bi bi-telephone-x text-xs"></i>
                </button>
            <?php endif; ?>
        </div>
    </div>


    <div class="hidden md:flex h-full group bg-white rounded-2xl border-t-4 <?= $cardBorder ?> shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex-col items-center relative">
        <div class="absolute top-0 right-0 z-10">
            <div class="bg-<?= $statusColor ?>-50 text-<?= $statusColor ?>-600 text-[10px] font-bold px-3 py-1 rounded-bl-xl border-l border-b border-<?= $statusColor ?>-100 uppercase tracking-wide flex items-center shadow-sm">
                <i class="bi <?= $statusIcon ?> mr-1.5 text-xs"></i> <?= $statusText ?>
            </div>
        </div>
        <div class="p-6 w-full text-center flex flex-col items-center flex-1">
            <div class="w-32 h-32 text-5xl rounded-full bg-slate-50 border-4 border-white shadow-lg flex items-center justify-center text-slate-300 font-bold mb-5 group-hover:scale-105 transition-transform duration-300 relative">
                <img src="<?= $imgSrc ?>" alt="<?= e($person['name']) ?>" class="w-full h-full rounded-full object-cover">
                <div class="absolute bottom-1 right-1 w-5 h-5 bg-<?= $statusColor ?>-500 border-4 border-white rounded-full">
                    <?php if ($isAvailable): ?><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span><?php endif; ?>
                </div>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-1 leading-tight px-2 min-h-[50px] flex items-center justify-center line-clamp-2">
                <?= e($person['name']) ?>
            </h3>
            <div class="mb-5">
                <span class="text-sm font-bold px-3 py-1 rounded-full border shadow-sm <?= $roleClass ?>">
                    <?= $isLeader ? '<i class="bi bi-star-fill text-xs mr-1"></i>' : '' ?> <?= e($person['position']) ?>
                </span>
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
                    Kembali: <?= !empty($person['return_time']) ? date('H:i', strtotime($person['return_time'])) : 'Belum ditentukan' ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="w-full bg-white px-6 py-4 border-t border-slate-100 mt-auto">
            <?php if ($hasPhone): ?>
            <a href="<?= $waLink ?>" target="_blank" class="w-full flex items-center justify-center gap-2 text-white bg-emerald-500 hover:bg-emerald-600 border border-transparent shadow-lg shadow-emerald-500/30 font-bold rounded-xl text-sm px-4 py-3 transition-all duration-300 transform hover:scale-[1.02]">
                <i class="bi bi-whatsapp text-lg"></i> Hubungi
            </a>
            <?php else: ?>
            <button disabled class="w-full flex items-center justify-center gap-2 text-slate-400 bg-slate-100 border border-slate-200 font-bold rounded-xl text-sm px-4 py-3 cursor-not-allowed">
                <i class="bi bi-telephone-x text-lg"></i> Tidak Ada Nomor
            </button>
            <?php endif; ?>
        </div>
    </div>
<?php } ?>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>
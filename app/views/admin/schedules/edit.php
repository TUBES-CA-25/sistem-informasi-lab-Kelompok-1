<?php
// Pastikan variabel pendukung tersedia
$title = 'Edit Jadwal Master';
$lecturers = $lecturers ?? [];
$assistants = $assistants ?? [];
$laboratories = $laboratories ?? [];
?>

<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-8 transition-all duration-300">
        <div class="max-w-6xl mx-auto">

            <div class="flex items-center gap-4 mb-8">
                <a href="<?= url('/admin/schedules') ?>"
                    class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-primary-600 hover:border-primary-200 shadow-sm transition-all"
                    title="Kembali ke Daftar">
                    <i class="bi bi-arrow-left text-lg"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Edit Jadwal Master</h1>
                    <div class="flex items-center gap-2 text-sm text-slate-500 mt-1">
                        <span>Manajemen Jadwal</span>
                        <i class="bi bi-chevron-right text-xs"></i>
                        <span class="text-primary-600 font-medium">Plan ID #<?= $schedule['id'] ?></span>
                    </div>
                </div>
            </div>

            <?php displayFlash(); ?>

            <form action="<?= url('/admin/schedules/' . $schedule['id'] . '/edit') ?>" method="POST"
                enctype="multipart/form-data">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <div class="lg:col-span-2 space-y-6">

                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                            <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                                <i class="bi bi-journal-bookmark text-primary-600"></i> Detail Mata Kuliah
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="col-span-2">
                                    <label class="block mb-2 text-sm font-bold text-slate-700">Lokasi
                                        Laboratorium</label>
                                    <select name="laboratory_id"
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-100"
                                        required>
                                        <?php foreach ($laboratories as $lab): ?>
                                        <option value="<?= $lab['id'] ?>"
                                            <?= $schedule['laboratory_id'] == $lab['id'] ? 'selected' : '' ?>>
                                            <?= $lab['lab_name'] ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-slate-700">Mata Kuliah</label>
                                    <input type="text" name="course_name" value="<?= e($schedule['course_name']) ?>"
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-100"
                                        required>
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-slate-700">Kode Kelas</label>
                                    <input type="text" name="class_code" value="<?= e($schedule['class_code']) ?>"
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-100"
                                        required>
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-slate-700">Program Studi</label>
                                    <select name="program_study"
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-100">
                                        <option value="Teknik Informatika"
                                            <?= $schedule['program_study'] == 'Teknik Informatika' ? 'selected' : '' ?>>
                                            Teknik Informatika</option>
                                        <option value="Sistem Informasi"
                                            <?= $schedule['program_study'] == 'Sistem Informasi' ? 'selected' : '' ?>>
                                            Sistem Informasi</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-slate-700">Semester</label>
                                    <input type="number" name="semester" value="<?= e($schedule['semester']) ?>"
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-100"
                                        min="1" max="8" required>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                            <h2 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                                <i class="bi bi-people text-primary-600"></i> Dosen & Asisten
                            </h2>

                            <div class="mb-6 p-4 bg-slate-50 rounded-xl border border-slate-100">
                                <label class="block mb-3 text-sm font-bold text-slate-700">Dosen Pengampu</label>
                                <div class="flex items-start gap-4">
                                    <div class="shrink-0">
                                        <img id="preview_lecturer" src="<?= $schedule['lecturer_photo'] ?>"
                                            class="w-14 h-14 rounded-full object-cover border-2 border-white shadow-md">
                                    </div>
                                    <div class="flex-1">
                                        <select name="lecturer_id" id="lecturer_id" onchange="updatePhoto('lecturer')"
                                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-100 cursor-pointer">
                                            <option value="" data-image="" data-name="Dosen">-- Pilih Dosen --</option>
                                            <?php foreach ($lecturers as $dosen): ?>
                                            <option value="<?= $dosen['id'] ?>"
                                                data-image="<?= !empty($dosen['image']) ? $dosen['image'] : '' ?>"
                                                data-name="<?= $dosen['name'] ?>"
                                                <?= $schedule['lecturer_id'] == $dosen['id'] ? 'selected' : '' ?>>
                                                <?= $dosen['name'] ?> (<?= ucfirst($dosen['role_name'] ?? 'user') ?>)
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                                    <label class="block mb-3 text-sm font-bold text-slate-700">Asisten 1 (Utama)</label>
                                    <div class="flex items-start gap-3">
                                        <div class="shrink-0">
                                            <img id="preview_asst1" src="<?= $schedule['assistant_1_photo'] ?>"
                                                class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-md">
                                        </div>
                                        <div class="flex-1">
                                            <select name="assistant_1_id" id="assistant_1_id"
                                                onchange="updatePhoto('assistant_1')"
                                                class="w-full px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm">
                                                <option value="" data-image="" data-name="A1">-- Pilih --</option>
                                                <?php foreach ($assistants as $ast): ?>
                                                <option value="<?= $ast['id'] ?>"
                                                    data-image="<?= !empty($ast['image']) ? $ast['image'] : '' ?>"
                                                    data-name="<?= $ast['name'] ?>"
                                                    <?= $schedule['assistant_1_id'] == $ast['id'] ? 'selected' : '' ?>>
                                                    <?= $ast['name'] ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                                    <label class="block mb-3 text-sm font-bold text-slate-700">Asisten 2
                                        (Opsional)</label>
                                    <div class="flex items-start gap-3">
                                        <div class="shrink-0">
                                            <img id="preview_asst2" src="<?= $schedule['assistant_2_photo'] ?>"
                                                class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-md">
                                        </div>
                                        <div class="flex-1">
                                            <select name="assistant_2_id" id="assistant_2_id"
                                                onchange="updatePhoto('assistant_2')"
                                                class="w-full px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm">
                                                <option value="" data-image="" data-name="A2">-- Kosong --</option>
                                                <?php foreach ($assistants as $ast): ?>
                                                <option value="<?= $ast['id'] ?>"
                                                    data-image="<?= !empty($ast['image']) ? $ast['image'] : '' ?>"
                                                    data-name="<?= $ast['name'] ?>"
                                                    <?= $schedule['assistant_2_id'] == $ast['id'] ? 'selected' : '' ?>>
                                                    <?= $ast['name'] ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                            <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                                <i class="bi bi-clock text-primary-600"></i> Waktu & Sesi
                            </h2>
                            <div class="space-y-4">
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-slate-700">Hari (Master)</label>
                                    <select name="day"
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-100">
                                        <?php $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']; ?>
                                        <?php foreach ($days as $day): ?>
                                        <option value="<?= $day ?>" <?= $schedule['day'] == $day ? 'selected' : '' ?>>
                                            <?= getDayName($day) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block mb-2 text-sm font-bold text-slate-700">Jam Mulai</label>
                                        <input type="time" name="start_time" value="<?= $schedule['start_time'] ?>"
                                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-100"
                                            required>
                                    </div>
                                    <div>
                                        <label class="block mb-2 text-sm font-bold text-slate-700">Jam Selesai</label>
                                        <input type="time" name="end_time" value="<?= $schedule['end_time'] ?>"
                                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-100"
                                            required>
                                    </div>
                                </div>
                                <div class="pt-2">
                                    <div
                                        class="p-3 bg-primary-50 rounded-xl border border-primary-100 text-xs text-primary-700 leading-relaxed">
                                        <i class="bi bi-info-circle-fill mr-1"></i> Mengubah jam master akan memperbarui
                                        waktu pada semua sesi praktikum yang berstatus <strong>scheduled</strong>.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                            <h2 class="text-sm font-bold text-slate-800 mb-3 flex items-center gap-2">
                                <i class="bi bi-camera text-primary-600"></i> Snapshot Saat Ini
                            </h2>
                            <p class="text-[11px] text-slate-500 italic">Data nama/foto di bawah ini adalah yang
                                tersimpan di jadwal (snapshot) saat ini:</p>
                            <div class="mt-3 space-y-2 text-xs">
                                <div class="flex justify-between border-b border-slate-50 pb-1">
                                    <span class="text-slate-500">Dosen:</span>
                                    <span class="font-medium text-slate-800"><?= e($schedule['lecturer_name']) ?></span>
                                </div>
                                <div class="flex justify-between pt-1">
                                    <span class="text-slate-500">Asisten:</span>
                                    <span
                                        class="font-medium text-slate-800"><?= e($schedule['assistant_1_name']) ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit"
                                class="w-full py-3.5 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl shadow-lg shadow-primary-500/30 transition-all flex items-center justify-center gap-2 transform active:scale-95">
                                <i class="bi bi-check2-circle"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </main>
</div>

<?php include APP_PATH . '/views/admin/layouts/footer.php'; ?>

<script>
/**
 * Update pratinjau foto secara real-time berdasarkan pilihan dropdown
 */
function updatePhoto(roleKey) {
    let selectId, imgId;
    if (roleKey === 'lecturer') {
        selectId = 'lecturer_id';
        imgId = 'preview_lecturer';
    } else if (roleKey === 'assistant_1') {
        selectId = 'assistant_1_id';
        imgId = 'preview_asst1';
    } else if (roleKey === 'assistant_2') {
        selectId = 'assistant_2_id';
        imgId = 'preview_asst2';
    }

    const select = document.getElementById(selectId);
    const img = document.getElementById(imgId);

    if (!select || !img || select.selectedIndex === -1) return;

    const selectedOption = select.options[select.selectedIndex];
    const photoUrl = selectedOption.getAttribute('data-image');
    const name = selectedOption.getAttribute('data-name') || 'User';

    if (photoUrl && photoUrl.trim() !== '') {
        img.src = photoUrl;
    } else {
        // Gunakan UI Avatars jika foto tidak tersedia
        const encodedName = encodeURIComponent(name);
        img.src = `https://ui-avatars.com/api/?name=${encodedName}&background=e2e8f0&color=64748b`;
    }
}

/**
 * Jalankan updatePhoto saat halaman pertama kali dimuat 
 * agar foto dari data yang sudah ada muncul otomatis
 */
document.addEventListener('DOMContentLoaded', function() {
    updatePhoto('lecturer');
    updatePhoto('assistant_1');
    updatePhoto('assistant_2');
});
</script>
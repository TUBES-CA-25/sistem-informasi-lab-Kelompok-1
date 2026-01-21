<?php $title = 'Edit Jadwal'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-8 transition-all duration-300">
        <div class="max-w-6xl mx-auto">

            <div class="flex items-center gap-4 mb-8">
                <a href="<?= url('/admin/schedules') ?>"
                    class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-primary-600 hover:border-primary-200 shadow-sm transition-all"
                    title="Kembali">
                    <i class="bi bi-arrow-left text-lg"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Edit Jadwal Praktikum</h1>
                    <div class="flex items-center gap-2 text-sm text-slate-500 mt-1">
                        <span>Manajemen Jadwal</span>
                        <i class="bi bi-chevron-right text-xs"></i>
                        <span class="text-primary-600 font-medium">Edit #<?= $schedule['id'] ?></span>
                    </div>
                </div>
            </div>

            <?php displayFlash(); ?>

            <form method="POST" action="<?= url('/admin/schedules/' . $schedule['id'] . '/edit') ?>"
                enctype="multipart/form-data">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <div class="lg:col-span-2 space-y-6">

                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                            <h2
                                class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-6 pb-2 border-b border-slate-100 flex items-center gap-2">
                                <i class="bi bi-clock-history text-primary-500"></i> Waktu & Lokasi
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-slate-700">Laboratorium <span
                                            class="text-rose-500">*</span></label>
                                    <div class="relative">
                                        <select name="laboratory_id"
                                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block appearance-none"
                                            required>
                                            <?php foreach ($laboratories as $lab): ?>
                                            <option value="<?= $lab['id'] ?>"
                                                <?= $lab['id'] == $schedule['laboratory_id'] ? 'selected' : '' ?>>
                                                <?= e($lab['lab_name']) ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div
                                            class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                                            <i class="bi bi-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-slate-700">Hari <span
                                            class="text-rose-500">*</span></label>
                                    <div class="relative">
                                        <select name="day"
                                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block appearance-none"
                                            required>
                                            <?php
                                            $days = ['Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];
                                            foreach ($days as $en => $id):
                                            ?>
                                            <option value="<?= $en ?>" <?= $schedule['day'] == $en ? 'selected' : '' ?>>
                                                <?= $id ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div
                                            class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                                            <i class="bi bi-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-slate-700">Jam Mulai</label>
                                    <input type="time" name="start_time" value="<?= e($schedule['start_time']) ?>"
                                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block"
                                        required>
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-slate-700">Jam Selesai</label>
                                    <input type="time" name="end_time" value="<?= e($schedule['end_time']) ?>"
                                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block"
                                        required>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                            <h2
                                class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-6 pb-2 border-b border-slate-100 flex items-center gap-2">
                                <i class="bi bi-book text-violet-500"></i> Informasi Akademik
                            </h2>

                            <div class="mb-6">
                                <label class="block mb-2 text-sm font-semibold text-slate-700">Mata Kuliah <span
                                        class="text-rose-500">*</span></label>
                                <input type="text" name="course" value="<?= e($schedule['course_name']) ?>"
                                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block font-medium"
                                    required>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-slate-700">Program Studi</label>
                                    <input type="text" name="program_study" value="<?= e($schedule['program_study']) ?>"
                                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-slate-700">Semester</label>
                                    <input type="number" name="semester" value="<?= e($schedule['semester']) ?>"
                                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block"
                                        required>
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-slate-700">Kode Kelas</label>
                                    <input type="text" name="class_code" value="<?= e($schedule['class_code']) ?>"
                                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block"
                                        required>
                                </div>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-semibold text-slate-700">Deskripsi
                                    Tambahan</label>
                                <textarea name="description" rows="3"
                                    class="w-full p-4 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block resize-none"><?= e($schedule['description']) ?></textarea>
                            </div>
                        </div>

                    </div>

                    <div class="lg:col-span-1 space-y-6">

                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sticky top-6">
                            <h2
                                class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-6 pb-2 border-b border-slate-100 flex items-center gap-2">
                                <i class="bi bi-people-fill text-emerald-500"></i> Tim Pengajar
                            </h2>

                            <div class="mb-6 p-4 bg-primary-50/50 rounded-xl border border-primary-100">
                                <label class="block mb-2 text-xs font-bold text-primary-700 uppercase">Dosen Pengampu
                                    *</label>
                                <div class="flex items-center gap-4 mb-3">
                                    <div
                                        class="w-12 h-12 rounded-full overflow-hidden bg-white border border-slate-200 shrink-0">
                                        <img src="<?= !empty($schedule['lecturer_photo']) ? e($schedule['lecturer_photo']) : '#' ?>"
                                            class="w-full h-full object-cover">
                                    </div>
                                    <div class="w-full">
                                        <input type="text" name="lecturer" value="<?= e($schedule['lecturer_name']) ?>"
                                            class="w-full px-3 py-2 bg-white border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-2 focus:ring-primary-100 block"
                                            required>
                                    </div>
                                </div>
                                <input
                                    class="block w-full text-xs text-slate-500 border border-slate-200 rounded-lg cursor-pointer bg-white"
                                    type="file" name="lecturer_photo_file" accept="image/*">
                            </div>

                            <div class="mb-6 p-4 bg-emerald-50/50 rounded-xl border border-emerald-100">
                                <label class="block mb-2 text-xs font-bold text-emerald-700 uppercase">Asisten 1
                                    (Utama)</label>
                                <div class="flex items-center gap-4 mb-3">
                                    <div
                                        class="w-12 h-12 rounded-full overflow-hidden bg-white border border-slate-200 shrink-0">
                                        <img src="<?= !empty($schedule['assistant_1_photo']) ? e($schedule['assistant_1_photo']) : '#' ?>"
                                            class="w-full h-full object-cover">
                                    </div>
                                    <div class="w-full">
                                        <input type="text" name="assistant"
                                            value="<?= e($schedule['assistant_1_name']) ?>"
                                            class="w-full px-3 py-2 bg-white border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-2 focus:ring-emerald-100 block"
                                            required>
                                    </div>
                                </div>
                                <input
                                    class="block w-full text-xs text-slate-500 border border-slate-200 rounded-lg cursor-pointer bg-white"
                                    type="file" name="assistant_photo_file" accept="image/*">
                            </div>

                            <div class="mb-8 p-4 bg-violet-50/50 rounded-xl border border-violet-100">
                                <label class="block mb-2 text-xs font-bold text-violet-700 uppercase">Asisten 2
                                    (Opsional)</label>
                                <div class="flex items-center gap-4 mb-3">
                                    <div
                                        class="w-12 h-12 rounded-full overflow-hidden bg-white border border-slate-200 shrink-0">
                                        <img src="<?= !empty($schedule['assistant_2_photo']) ? e($schedule['assistant_2_photo']) : '#' ?>"
                                            class="w-full h-full object-cover">
                                    </div>
                                    <div class="w-full">
                                        <input type="text" name="assistant_2"
                                            value="<?= e($schedule['assistant_2_name']) ?>"
                                            class="w-full px-3 py-2 bg-white border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-2 focus:ring-violet-100 block">
                                    </div>
                                </div>
                                <input
                                    class="block w-full text-xs text-slate-500 border border-slate-200 rounded-lg cursor-pointer bg-white"
                                    type="file" name="assistant2_photo_file" accept="image/*">
                            </div>

                            <div class="flex flex-col gap-3">
                                <button type="submit"
                                    class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 font-semibold rounded-xl text-sm px-5 py-3 transition-all shadow-lg shadow-primary-500/30 flex justify-center items-center gap-2">
                                    <i class="bi bi-check-lg"></i>
                                    Update Jadwal
                                </button>
                                <a href="<?= url('/admin/schedules') ?>"
                                    class="w-full text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 hover:text-slate-900 font-medium rounded-xl text-sm px-5 py-3 text-center transition-all">
                                    Batal
                                </a>
                            </div>

                        </div>
                    </div>

                </div>
            </form>
        </div>
    </main>
</div>
<?php $title = 'Edit Jadwal Piket'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-8 flex items-center gap-3">
            <a href="<?= url('/koordinator/assistant-schedules') ?>" class="text-slate-400 hover:text-slate-600"><i
                    class="bi bi-arrow-left text-xl"></i></a>
            <h1 class="text-3xl font-bold text-slate-800">Edit Jadwal Piket</h1>
        </div>

        <?php displayFlash(); ?>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8">
            <form method="POST" action="<?= url('/koordinator/assistant-schedules/' . $schedule['id'] . '/edit') ?>"
                class="space-y-6">

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">1. Nama Asisten <span
                            class="text-red-500">*</span></label>
                    <select name="user_id" required
                        class="block w-full px-4 py-3 border border-slate-300 rounded-lg cursor-pointer">
                        <option value="">-- Pilih Asisten --</option>
                        <?php foreach ($assistants as $asisten): ?>
                        <option value="<?= $asisten['id'] ?>"
                            <?= $schedule['user_id'] == $asisten['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($asisten['name']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">2. Hari Piket <span
                            class="text-red-500">*</span></label>
                    <select name="day" required
                        class="block w-full px-4 py-3 border border-slate-300 rounded-lg cursor-pointer">
                        <option value="">-- Pilih Hari --</option>
                        <?php foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day): ?>
                        <option value="<?= $day ?>" <?= $schedule['day'] == $day ? 'selected' : '' ?>>
                            <?php $dayNames = ['Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'];
                                echo $dayNames[$day]; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-3">3. Kategori Tugas <span
                            class="text-red-500">*</span></label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="cursor-pointer group">
                            <input type="radio" name="job_role" value="Putra" class="peer sr-only" required
                                <?= $schedule['job_role'] == 'Putra' ? 'checked' : '' ?>>
                            <div
                                class="p-4 border-2 border-slate-100 rounded-xl peer-checked:border-emerald-500 peer-checked:bg-emerald-50 text-center font-bold text-slate-700 peer-checked:text-emerald-700 hover:bg-slate-50">
                                Putra</div>
                        </label>
                        <label class="cursor-pointer group">
                            <input type="radio" name="job_role" value="Putri" class="peer sr-only" required
                                <?= $schedule['job_role'] == 'Putri' ? 'checked' : '' ?>>
                            <div
                                class="p-4 border-2 border-slate-100 rounded-xl peer-checked:border-rose-500 peer-checked:bg-rose-50 text-center font-bold text-slate-700 peer-checked:text-rose-700 hover:bg-slate-50">
                                Putri</div>
                        </label>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-200 flex gap-3">
                    <button type="submit"
                        class="flex-1 px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white font-bold rounded-lg shadow-lg">Simpan
                        Perubahan</button>
                    <a href="<?= url('/koordinator/assistant-schedules') ?>"
                        class="flex-1 px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-lg text-center">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include APP_PATH . '/views/layouts/footer.php'; ?>
<?php $title = 'Buat Laporan Masalah'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <a href="<?= url('/koordinator/problems') ?>" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <i class="bi bi-arrow-left text-xl"></i>
                </a>
                <h1 class="text-3xl font-bold text-slate-800">Buat Laporan Masalah</h1>
            </div>
            <p class="text-slate-500">Buat laporan permasalahan hardware atau software di laboratorium.</p>
        </div>

        <?php displayFlash(); ?>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8">
            <form method="POST" action="<?= url('/koordinator/problems/create') ?>" class="space-y-6">

                <!-- Laboratory Selection -->
                <div>
                    <label for="laboratory_id" class="block text-sm font-medium text-slate-700 mb-2">
                        Laboratorium <span class="text-red-500">*</span>
                    </label>
                    <select id="laboratory_id" name="laboratory_id" required class="block w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        <option value="">Pilih Laboratorium</option>
                        <?php foreach ($laboratories as $lab): ?>
                            <option value="<?= $lab['id'] ?>"><?= htmlspecialchars($lab['lab_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- PC Number -->
                <div>
                    <label for="pc_number" class="block text-sm font-medium text-slate-700 mb-2">
                        Nomor PC
                    </label>
                    <input type="text" id="pc_number" name="pc_number" placeholder="Contoh: 01, 02, Server, dll." class="block w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                    <p class="mt-1 text-sm text-slate-500">Kosongkan jika masalah bukan pada PC tertentu</p>
                </div>

                <!-- Problem Type -->
                <div>
                    <label for="problem_type" class="block text-sm font-medium text-slate-700 mb-2">
                        Jenis Masalah <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="relative flex items-center p-4 border-2 border-slate-200 rounded-lg cursor-pointer hover:border-emerald-500 transition-colors">
                            <input type="radio" name="problem_type" value="hardware" class="sr-only peer" required>
                            <div class="flex items-center gap-3 peer-checked:text-emerald-600">
                                <div class="w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center peer-checked:bg-red-100">
                                    <i class="bi bi-cpu text-xl text-red-600"></i>
                                </div>
                                <div>
                                    <div class="font-medium">Hardware</div>
                                    <div class="text-xs text-slate-500">Kerusakan fisik</div>
                                </div>
                            </div>
                            <div class="absolute top-2 right-2 w-5 h-5 bg-white border-2 border-slate-300 rounded-full peer-checked:border-emerald-500 peer-checked:bg-emerald-500"></div>
                        </label>

                        <label class="relative flex items-center p-4 border-2 border-slate-200 rounded-lg cursor-pointer hover:border-emerald-500 transition-colors">
                            <input type="radio" name="problem_type" value="software" class="sr-only peer" required>
                            <div class="flex items-center gap-3 peer-checked:text-emerald-600">
                                <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center peer-checked:bg-blue-100">
                                    <i class="bi bi-code-slash text-xl text-blue-600"></i>
                                </div>
                                <div>
                                    <div class="font-medium">Software</div>
                                    <div class="text-xs text-slate-500">Aplikasi/sistem</div>
                                </div>
                            </div>
                            <div class="absolute top-2 right-2 w-5 h-5 bg-white border-2 border-slate-300 rounded-full peer-checked:border-emerald-500 peer-checked:bg-emerald-500"></div>
                        </label>

                        <label class="relative flex items-center p-4 border-2 border-slate-200 rounded-lg cursor-pointer hover:border-emerald-500 transition-colors">
                            <input type="radio" name="problem_type" value="network" class="sr-only peer">
                            <div class="flex items-center gap-3 peer-checked:text-emerald-600">
                                <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center peer-checked:bg-purple-100">
                                    <i class="bi bi-wifi text-xl text-purple-600"></i>
                                </div>
                                <div>
                                    <div class="font-medium">Network</div>
                                    <div class="text-xs text-slate-500">Koneksi/jaringan</div>
                                </div>
                            </div>
                            <div class="absolute top-2 right-2 w-5 h-5 bg-white border-2 border-slate-300 rounded-full peer-checked:border-emerald-500 peer-checked:bg-emerald-500"></div>
                        </label>

                        <label class="relative flex items-center p-4 border-2 border-slate-200 rounded-lg cursor-pointer hover:border-emerald-500 transition-colors">
                            <input type="radio" name="problem_type" value="other" class="sr-only peer">
                            <div class="flex items-center gap-3 peer-checked:text-emerald-600">
                                <div class="w-10 h-10 bg-slate-50 rounded-lg flex items-center justify-center peer-checked:bg-slate-100">
                                    <i class="bi bi-three-dots text-xl text-slate-600"></i>
                                </div>
                                <div>
                                    <div class="font-medium">Lainnya</div>
                                    <div class="text-xs text-slate-500">Masalah lain</div>
                                </div>
                            </div>
                            <div class="absolute top-2 right-2 w-5 h-5 bg-white border-2 border-slate-300 rounded-full peer-checked:border-emerald-500 peer-checked:bg-emerald-500"></div>
                        </label>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 mb-2">
                        Deskripsi Masalah <span class="text-red-500">*</span>
                    </label>
                    <textarea id="description" name="description" rows="5" required placeholder="Jelaskan masalah secara detail..." class="block w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500"></textarea>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 pt-4 border-t border-slate-200">
                    <a href="<?= url('/koordinator/problems') ?>" class="flex-1 px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-lg transition-colors text-center">
                        Batal
                    </a>
                    <button type="submit" class="flex-1 px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white font-medium rounded-lg shadow-lg shadow-sky-500/30 transition-all">
                        Buat Laporan
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>

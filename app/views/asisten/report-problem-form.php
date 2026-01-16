<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
    <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-emerald-50 to-white">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-exclamation-triangle text-emerald-600 text-xl"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold text-slate-800">Form Laporan Masalah</h2>
                <p class="text-sm text-slate-500">Isi formulir di bawah dengan detail masalah</p>
            </div>
        </div>
    </div>

    <form method="POST" action="<?= url('/asisten/report-problem') ?>" class="p-6 space-y-6">
        
        <!-- Laboratory Selection -->
        <div>
            <label for="laboratory_id" class="block text-sm font-semibold text-slate-700 mb-2">
                Laboratorium <span class="text-rose-500">*</span>
            </label>
            <select name="laboratory_id" id="laboratory_id" required
                class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all bg-white">
                <option value="">-- Pilih Laboratorium --</option>
                <?php if (!empty($laboratories)): ?>
                    <?php foreach ($laboratories as $lab): ?>
                        <option value="<?= $lab['id'] ?>"><?= e($lab['name']) ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <!-- PC Number -->
        <div>
            <label for="pc_number" class="block text-sm font-semibold text-slate-700 mb-2">
                Nomor PC <span class="text-rose-500">*</span>
            </label>
            <input type="text" name="pc_number" id="pc_number" required
                placeholder="Contoh: PC-01, PC-15"
                class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all">
        </div>

        <!-- Problem Type -->
        <div>
            <label for="problem_type" class="block text-sm font-semibold text-slate-700 mb-2">
                Jenis Masalah <span class="text-rose-500">*</span>
            </label>
            <select name="problem_type" id="problem_type" required
                class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all bg-white">
                <option value="">-- Pilih Jenis Masalah --</option>
                <option value="hardware">Hardware (Perangkat Keras)</option>
                <option value="software">Software (Perangkat Lunak)</option>
                <option value="network">Network (Jaringan)</option>
                <option value="other">Lainnya</option>
            </select>
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">
                Deskripsi Masalah <span class="text-rose-500">*</span>
            </label>
            <textarea name="description" id="description" rows="6" required
                placeholder="Jelaskan masalah secara detail (minimal 10 karakter)..."
                class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all resize-none"></textarea>
            <p class="text-xs text-slate-500 mt-2">
                <i class="bi bi-info-circle"></i>
                Berikan informasi sejelas mungkin agar masalah dapat ditangani dengan cepat
            </p>
        </div>

        <!-- Submit Buttons -->
        <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-slate-100">
            <button type="submit" 
                class="flex-1 px-6 py-3 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white font-bold rounded-lg hover:from-emerald-700 hover:to-emerald-800 transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                <i class="bi bi-send-fill"></i>
                Submit Laporan
            </button>
            <a href="<?= url('/asisten/problems') ?>" 
                class="flex-1 px-6 py-3 bg-slate-100 text-slate-700 font-bold rounded-lg hover:bg-slate-200 transition-all text-center flex items-center justify-center gap-2">
                <i class="bi bi-x-circle"></i>
                Batal
            </a>
        </div>

    </form>
</div>

<!-- Info Card -->
<div class="bg-gradient-to-br from-sky-50 to-blue-50 border border-sky-200 rounded-2xl p-6 mt-6">
    <div class="flex items-start gap-4">
        <div class="w-12 h-12 bg-sky-100 rounded-full flex items-center justify-center flex-shrink-0">
            <i class="bi bi-lightbulb text-sky-600 text-2xl"></i>
        </div>
        <div>
            <h3 class="font-bold text-slate-800 mb-2">Tips Melaporkan Masalah</h3>
            <ul class="space-y-2 text-sm text-slate-600">
                <li class="flex items-start gap-2">
                    <i class="bi bi-check-circle-fill text-emerald-500 mt-0.5"></i>
                    <span>Pastikan nomor PC sudah benar sesuai dengan label di komputer</span>
                </li>
                <li class="flex items-start gap-2">
                    <i class="bi bi-check-circle-fill text-emerald-500 mt-0.5"></i>
                    <span>Jelaskan gejala masalah dengan spesifik (error message, masalah fisik, dll)</span>
                </li>
                <li class="flex items-start gap-2">
                    <i class="bi bi-check-circle-fill text-emerald-500 mt-0.5"></i>
                    <span>Laporan Anda akan segera ditinjau oleh koordinator laboratorium</span>
                </li>
            </ul>
        </div>
    </div>
</div>

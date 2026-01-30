<?php $title = 'Detail Masalah'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-8 transition-all duration-300">
        <div class="max-w-6xl mx-auto">

            <div class="flex items-center gap-4 mb-6">
                <a href="<?= url('/admin/problems') ?>"
                    class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-primary-600 hover:border-primary-200 shadow-sm transition-all"
                    title="Kembali ke Daftar">
                    <i class="bi bi-arrow-left text-lg"></i>
                </a>
                <div class="flex-1">
                    <div class="flex items-center gap-2 text-sm text-slate-500 mb-1">
                        <span>Reports</span>
                        <i class="bi bi-chevron-right text-xs"></i>
                        <span class="font-mono">#<?= $problem['id'] ?></span>
                    </div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Detail Masalah</h1>
                </div>

                <a href="<?= url('/admin/problems/' . $problem['id'] . '/edit') ?>"
                    class="px-4 py-2 bg-white border border-slate-200 text-slate-700 font-bold rounded-lg hover:text-amber-600 hover:border-amber-200 shadow-sm transition-all flex items-center gap-2">
                    <i class="bi bi-pencil-square"></i>
                    <span class="hidden sm:inline">Edit Data</span>
                </a>

                <?php
                $statusColor = match ($problem['status']) {
                    'reported' => 'bg-rose-100 text-rose-700 border-rose-200',
                    'in_progress' => 'bg-amber-100 text-amber-700 border-amber-200',
                    'resolved' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                    default => 'bg-slate-100 text-slate-700'
                };
                $statusIcon = match ($problem['status']) {
                    'reported' => 'bi-exclamation-circle-fill',
                    'in_progress' => 'bi-arrow-repeat',
                    'resolved' => 'bi-check-circle-fill',
                    default => 'bi-circle-fill'
                };
                ?>
                <div
                    class="px-4 py-2 rounded-lg border font-bold text-sm flex items-center gap-2 shadow-sm <?= $statusColor ?>">
                    <i class="bi <?= $statusIcon ?>"></i>
                    <?= ucfirst(str_replace('_', ' ', $problem['status'])) ?>
                </div>
            </div>

            <?php displayFlash(); ?>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-2 space-y-6">

                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                        <div
                            class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                            <h3 class="font-bold text-slate-800 flex items-center gap-2">
                                <i class="bi bi-info-circle text-primary-500"></i> Informasi Masalah
                            </h3>
                            <span class="text-xs text-slate-400">
                                <?= date('d M Y, H:i', strtotime($problem['reported_at'])) ?>
                            </span>
                        </div>

                        <div class="p-6 space-y-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Perangkat
                                        Terdampak</p>
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-primary-600 shadow-sm">
                                            <i class="bi bi-pc-display text-xl"></i>
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-800"><?= e($problem['lab_name']) ?></p>
                                            <p class="text-xs text-slate-500 font-mono">
                                                PC-<?= e($problem['pc_number']) ?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Kategori
                                    </p>
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-violet-600 shadow-sm">
                                            <i class="bi bi-tags text-xl"></i>
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-800"><?= ucfirst($problem['problem_type']) ?>
                                            </p>
                                            <p class="text-xs text-slate-500">Jenis Kerusakan</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Deskripsi</p>
                                <div
                                    class="bg-slate-50 rounded-xl p-4 border border-slate-100 text-slate-700 leading-relaxed text-sm">
                                    <?= nl2br(e($problem['description'])) ?>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                                <div
                                    class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-xs font-bold text-slate-600">
                                    <?= strtoupper(substr($problem['reporter_name'], 0, 1)) ?>
                                </div>
                                <div class="text-sm">
                                    <span class="text-slate-500">Dilaporkan oleh</span>
                                    <span
                                        class="font-bold text-slate-800 ml-1"><?= e($problem['reporter_name']) ?></span>
                                    <span class="text-slate-400 mx-1">&bull;</span>
                                    <span class="text-slate-400"><?= e($problem['reporter_email']) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                            <h3 class="font-bold text-slate-800 flex items-center gap-2">
                                <i class="bi bi-clock-history text-primary-500"></i> Riwayat Perbaikan
                            </h3>
                        </div>

                        <div class="p-6">
                            <?php if (!empty($histories)): ?>
                            <div class="relative pl-4 border-l-2 border-slate-100 space-y-8">
                                <?php foreach ($histories as $history): ?>
                                <div class="relative">
                                    <div
                                        class="absolute -left-[21px] top-1 w-3 h-3 rounded-full border-2 border-white 
                                                <?= $history['status'] == 'resolved' ? 'bg-emerald-500' : ($history['status'] == 'in_progress' ? 'bg-amber-500' : 'bg-slate-300') ?> ring-2 ring-slate-50">
                                    </div>

                                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-1 mb-1">
                                        <div class="font-bold text-slate-800 text-sm">
                                            Status berubah:
                                            <span
                                                class="<?= $history['status'] == 'resolved' ? 'text-emerald-600' : 'text-slate-600' ?>">
                                                <?= ucfirst(str_replace('_', ' ', $history['status'])) ?>
                                            </span>
                                        </div>
                                        <div class="text-xs text-slate-400 whitespace-nowrap">
                                            <?= date('d M Y, H:i', strtotime($history['updated_at'])) ?>
                                        </div>
                                    </div>

                                    <?php if (!empty($history['note'])): ?>
                                    <div
                                        class="text-sm text-slate-600 bg-slate-50 p-3 rounded-lg border border-slate-100 mt-2">
                                        <?= e($history['note']) ?>
                                    </div>
                                    <?php endif; ?>

                                    <div class="text-xs text-slate-400 mt-1 flex items-center gap-1">
                                        <i class="bi bi-person"></i> Updated by <?= e($history['updater_name']) ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <?php else: ?>
                            <div class="text-center py-8 text-slate-400 text-sm italic">
                                Belum ada update status.
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>

                <div class="lg:col-span-1 space-y-6">

                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="p-1 bg-gradient-to-r from-violet-500 to-fuchsia-600"></div>
                        <div class="p-6">
                            <h3 class="font-bold text-slate-800 mb-4 text-lg">Tugaskan Asisten</h3>

                            <?php if (!empty($problem['assigned_to_name'])): ?>
                            <div
                                class="p-3 bg-violet-50 text-violet-700 rounded-lg text-sm mb-4 border border-violet-100 flex items-center gap-2">
                                <i class="bi bi-person-check-fill"></i>
                                <div>
                                    <span class="text-xs uppercase font-bold text-violet-400 block">Petugas Saat
                                        Ini</span>
                                    <strong><?= e($problem['assigned_to_name']) ?></strong>
                                </div>
                            </div>
                            <?php endif; ?>

                            <form method="POST" action="<?= url('/admin/problems/' . $problem['id'] . '/assign') ?>">
                                <div class="mb-4">
                                    <label class="block mb-2 text-xs font-bold text-slate-500 uppercase">Pilih
                                        Asisten</label>
                                    <div class="relative">
                                        <select name="assigned_to"
                                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-violet-100 focus:border-violet-500 block appearance-none"
                                            required>
                                            <option value="">-- Pilih Asisten --</option>
                                            <?php if (isset($assistants)): ?>
                                            <?php foreach ($assistants as $asisten): ?>
                                            <option value="<?= $asisten['id'] ?>"
                                                <?= $problem['assigned_to'] == $asisten['id'] ? 'selected' : '' ?>>
                                                <?= e($asisten['name']) ?>
                                            </option>
                                            <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                        <div
                                            class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                                            <i class="bi bi-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit"
                                    class="w-full text-white bg-violet-600 hover:bg-violet-700 font-semibold rounded-xl text-sm px-5 py-3 transition-all flex justify-center items-center gap-2 shadow-lg shadow-violet-500/30">
                                    <i class="bi bi-person-plus-fill"></i> Tugaskan
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 sticky top-6 overflow-hidden">
                        <div class="p-1 bg-gradient-to-r from-primary-500 to-indigo-600"></div>
                        <div class="p-6">
                            <h3 class="font-bold text-slate-800 mb-4 text-lg">Update Status</h3>

                            <form method="POST"
                                action="<?= url('/admin/problems/' . $problem['id'] . '/update-status') ?>">
                                <div class="mb-4">
                                    <label class="block mb-2 text-xs font-bold text-slate-500 uppercase">Status
                                        Baru</label>
                                    <div class="relative">
                                        <select name="status"
                                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block appearance-none"
                                            required>
                                            <option value="reported"
                                                <?= $problem['status'] == 'reported' ? 'selected' : '' ?>>Reported
                                            </option>
                                            <option value="in_progress"
                                                <?= $problem['status'] == 'in_progress' ? 'selected' : '' ?>>In Progress
                                            </option>
                                            <option value="resolved"
                                                <?= $problem['status'] == 'resolved' ? 'selected' : '' ?>>Resolved
                                            </option>
                                        </select>
                                        <div
                                            class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                                            <i class="bi bi-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="block mb-2 text-xs font-bold text-slate-500 uppercase">Catatan
                                        Perbaikan</label>
                                    <textarea name="note" rows="4"
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block resize-none placeholder:text-slate-400"
                                        placeholder="Jelaskan tindakan yang diambil..."></textarea>
                                </div>

                                <button type="submit"
                                    class="w-full text-white bg-slate-800 hover:bg-slate-900 focus:ring-4 focus:ring-slate-200 font-semibold rounded-xl text-sm px-5 py-3 transition-all flex justify-center items-center gap-2">
                                    <i class="bi bi-save"></i>
                                    Simpan Update
                                </button>
                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </main>
</div>

<?php include APP_PATH . '/views/admin/layouts/footer.php'; ?>
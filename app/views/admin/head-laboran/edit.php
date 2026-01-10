<?php $title = 'Edit Staff'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-8 transition-all duration-300">
        <div class="max-w-5xl mx-auto">

            <div class="flex items-center gap-4 mb-8">
                <a href="<?= url('/admin/head-laboran') ?>" 
                   class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-primary-600 hover:border-primary-200 shadow-sm transition-all"
                   title="Kembali">
                    <i class="bi bi-arrow-left text-lg"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Edit Data Staff</h1>
                    <div class="flex items-center gap-2 text-sm text-slate-500 mt-1">
                        <span>Manajemen Staff</span>
                        <i class="bi bi-chevron-right text-xs"></i>
                        <span class="text-primary-600 font-medium"><?= e($user_name) ?></span>
                    </div>
                </div>
            </div>

            <?php displayFlash(); ?>

            <form method="POST" action="<?= url('/admin/head-laboran/' . $staff['id'] . '/edit') ?>" enctype="multipart/form-data">
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-6 pb-2 border-b border-slate-100">
                                Profil & Identitas
                            </h2>

                            <div class="mb-6 flex flex-col items-center">
                                <div class="relative group">
                                    <div class="w-32 h-32 rounded-full border-4 border-slate-50 shadow-md overflow-hidden bg-slate-100 relative">
                                        <img id="photo-preview" 
                                             src="<?= !empty($staff['photo']) ? e($staff['photo']) : 'https://ui-avatars.com/api/?name='.urlencode($user_name).'&background=random' ?>" 
                                             class="w-full h-full object-cover">
                                        
                                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer" onclick="document.getElementById('photo_file').click()">
                                            <i class="bi bi-camera text-white text-2xl"></i>
                                        </div>
                                    </div>
                                    
                                    <button type="button" onclick="document.getElementById('photo_file').click()" class="absolute bottom-1 right-1 w-8 h-8 bg-white text-slate-600 rounded-full shadow border border-slate-200 flex items-center justify-center hover:text-primary-600 hover:border-primary-200 transition-colors">
                                        <i class="bi bi-pencil-fill text-xs"></i>
                                    </button>
                                </div>
                                
                                <input type="file" name="photo_file" id="photo_file" class="hidden" accept="image/*" onchange="previewImage(this)">
                                <p class="text-xs text-slate-400 mt-3 text-center">Klik foto untuk mengganti.<br>JPG, PNG, max 2MB.</p>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block mb-2 text-xs font-semibold text-slate-500 uppercase">Nama Staff</label>
                                    <input type="text" value="<?= e($user_name) ?>" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-500 text-sm rounded-xl cursor-not-allowed" disabled>
                                </div>

                                <div>
                                    <label class="block mb-2 text-xs font-semibold text-slate-700 uppercase">Jabatan / Posisi <span class="text-rose-500">*</span></label>
                                    <input type="text" name="position" value="<?= e($staff['position']) ?>" 
                                           class="w-full px-4 py-2.5 bg-white border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block transition-all" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-6 pb-2 border-b border-slate-100 flex items-center gap-2">
                                <i class="bi bi-activity text-primary-500"></i> Update Status Kehadiran
                            </h2>

                            <div class="mb-6">
                                <label class="block mb-2 text-sm font-semibold text-slate-700">Status Saat Ini <span class="text-rose-500">*</span></label>
                                <div class="grid grid-cols-2 gap-4">
                                    <label class="relative flex items-center justify-between p-4 bg-white border rounded-xl cursor-pointer hover:bg-slate-50 transition-all focus-within:ring-2 focus-within:ring-emerald-500 <?= $staff['status'] == 'active' ? 'border-emerald-500 ring-1 ring-emerald-500 bg-emerald-50/30' : 'border-slate-200' ?>">
                                        <div class="flex items-center gap-3">
                                            <div class="flex items-center justify-center w-5 h-5 border-2 rounded-full <?= $staff['status'] == 'active' ? 'border-emerald-500' : 'border-slate-300' ?>">
                                                <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 <?= $staff['status'] == 'active' ? 'block' : 'hidden' ?>"></div>
                                            </div>
                                            <div>
                                                <span class="block text-sm font-bold text-slate-800">Active</span>
                                                <span class="block text-xs text-slate-500">Sedang Hadir / Standby</span>
                                            </div>
                                        </div>
                                        <input type="radio" name="status" value="active" class="hidden" <?= $staff['status'] == 'active' ? 'checked' : '' ?> onclick="toggleReturnTime(false)">
                                    </label>

                                    <label class="relative flex items-center justify-between p-4 bg-white border rounded-xl cursor-pointer hover:bg-slate-50 transition-all focus-within:ring-2 focus-within:ring-rose-500 <?= $staff['status'] == 'inactive' ? 'border-rose-500 ring-1 ring-rose-500 bg-rose-50/30' : 'border-slate-200' ?>">
                                        <div class="flex items-center gap-3">
                                            <div class="flex items-center justify-center w-5 h-5 border-2 rounded-full <?= $staff['status'] == 'inactive' ? 'border-rose-500' : 'border-slate-300' ?>">
                                                <div class="w-2.5 h-2.5 rounded-full bg-rose-500 <?= $staff['status'] == 'inactive' ? 'block' : 'hidden' ?>"></div>
                                            </div>
                                            <div>
                                                <span class="block text-sm font-bold text-slate-800">Inactive</span>
                                                <span class="block text-xs text-slate-500">Sedang Keluar / Izin</span>
                                            </div>
                                        </div>
                                        <input type="radio" name="status" value="inactive" class="hidden" <?= $staff['status'] == 'inactive' ? 'checked' : '' ?> onclick="toggleReturnTime(true)">
                                    </label>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-slate-700">Lokasi Terkini</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none text-slate-400">
                                            <i class="bi bi-geo-alt"></i>
                                        </div>
                                        <input type="text" name="location" value="<?= e($staff['location']) ?>" 
                                               class="w-full ps-10 p-2.5 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block transition-all"
                                               placeholder="Contoh: Lab Komputer 1">
                                    </div>
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-slate-700">Jam Masuk</label>
                                    <input type="time" name="time_in" value="<?= e($staff['time_in']) ?>" 
                                           class="w-full p-2.5 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block transition-all">
                                </div>
                            </div>

                            <div class="mb-6">
                                <label class="block mb-2 text-sm font-semibold text-slate-700">Catatan / Keterangan</label>
                                <textarea name="notes" rows="3" 
                                          class="w-full p-3 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block transition-all resize-none"
                                          placeholder="Tambahkan catatan aktivitas atau alasan keluar..."><?= e($staff['notes']) ?></textarea>
                            </div>

                            <div id="return-time-container" class="transition-all duration-300 <?= $staff['status'] == 'inactive' ? 'opacity-100' : 'opacity-50 grayscale' ?>">
                                <div class="p-4 bg-rose-50 rounded-xl border border-rose-100">
                                    <div class="flex items-center gap-2 mb-2 text-rose-700">
                                        <i class="bi bi-clock-history"></i>
                                        <label class="text-sm font-bold">Estimasi Kembali</label>
                                    </div>
                                    <p class="text-xs text-rose-600/70 mb-3">Wajib diisi jika status staff sedang "Inactive" atau keluar.</p>
                                    <input type="datetime-local" name="return_time" 
                                           value="<?= !empty($staff['return_time']) ? date('Y-m-d\TH:i', strtotime($staff['return_time'])) : '' ?>" 
                                           class="bg-white border border-rose-200 text-slate-900 text-sm rounded-lg block w-full p-2.5 focus:border-rose-500 focus:ring-rose-200">
                                </div>
                            </div>

                        </div>

                        <div class="flex items-center gap-4 pt-4">
                            <button type="submit" class="flex-1 text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 font-semibold rounded-xl text-sm px-5 py-3 transition-all shadow-lg shadow-primary-500/30 flex justify-center items-center gap-2">
                                <i class="bi bi-check-lg"></i>
                                Simpan Perubahan
                            </button>
                            <a href="<?= url('/admin/head-laboran') ?>" class="text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 hover:text-slate-900 font-medium rounded-xl text-sm px-6 py-3 transition-all">
                                Batal
                            </a>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </main>
</div>

<script>
    // Preview Image Logic
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('photo-preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Toggle Visual Logic for Return Time
    function toggleReturnTime(isInactive) {
        const container = document.getElementById('return-time-container');
        if (isInactive) {
            container.classList.remove('opacity-50', 'grayscale');
            container.classList.add('opacity-100');
        } else {
            container.classList.add('opacity-50', 'grayscale');
            container.classList.remove('opacity-100');
        }
    }
</script>
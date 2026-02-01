<?php $title = 'Tambah User Baru';
$adminLayout = true; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-8 transition-all duration-300">
        <div class="max-w-4xl mx-auto">

            <div class="flex items-center gap-4 mb-8">
                <a href="<?= url('/admin/users') ?>"
                    class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-primary-600 hover:border-primary-200 shadow-sm transition-all"
                    title="Kembali">
                    <i class="bi bi-arrow-left text-lg"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Tambah User Baru</h1>
                    <p class="text-slate-500 text-sm mt-1">Registrasi akun Dosen, Asisten, atau Staff baru.</p>
                </div>
            </div>

            <?php displayFlash(); ?>

            <form action="<?= url('/admin/users/create') ?>" method="POST" enctype="multipart/form-data">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <div class="lg:col-span-1">
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 text-center">
                            <label class="block text-sm font-bold text-slate-700 mb-4">Foto Profil</label>

                            <div class="relative w-40 h-40 mx-auto mb-4 group">
                                <div
                                    class="w-full h-full rounded-full overflow-hidden border-4 border-slate-100 shadow-inner bg-slate-50 flex items-center justify-center relative">
                                    <img id="preview-img" src="" class="w-full h-full object-cover hidden">
                                    <div id="placeholder-icon" class="text-slate-300">
                                        <i class="bi bi-person-fill text-6xl"></i>
                                    </div>

                                    <div class="absolute inset-0 bg-black/40 hidden group-hover:flex items-center justify-center transition-all cursor-pointer"
                                        onclick="document.getElementById('image-input').click()">
                                        <i class="bi bi-camera-fill text-white text-2xl"></i>
                                    </div>
                                </div>

                                <button type="button" onclick="document.getElementById('image-input').click()"
                                    class="absolute bottom-2 right-2 w-8 h-8 bg-primary-600 text-white rounded-full border-2 border-white shadow-sm flex items-center justify-center hover:bg-primary-700 transition-all">
                                    <i class="bi bi-pencil-fill text-xs"></i>
                                </button>
                            </div>

                            <input type="file" name="image" id="image-input" class="hidden" accept="image/*"
                                onchange="previewImage(this)">

                            <p class="text-xs text-slate-400 mt-2">
                                Format: JPG, PNG (Max 2MB).<br>Disarankan rasio 1:1 (Persegi).
                            </p>
                        </div>
                    </div>

                    <div class="lg:col-span-2">
                        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200 space-y-6">

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="bi bi-person text-slate-400"></i>
                                    </div>
                                    <input type="text" name="name" required
                                        class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 transition-all"
                                        placeholder="Contoh: Ir. Dosen Fasilkom">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Email Address</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="bi bi-envelope text-slate-400"></i>
                                    </div>
                                    <input type="email" name="email" required
                                        class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 transition-all"
                                        placeholder="nama@iclabs.com">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Role / Jabatan</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="bi bi-shield-check text-slate-400"></i>
                                        </div>
                                        <select name="role_id" required
                                            class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 appearance-none">
                                            <option value="">-- Pilih Role --</option>
                                            <?php foreach ($roles as $role): ?>
                                            <option value="<?= $role['id'] ?>"><?= ucfirst($role['role_name']) ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <i
                                            class="bi bi-chevron-down absolute right-4 top-3.5 text-slate-400 text-xs pointer-events-none"></i>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Status Akun</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="bi bi-toggle-on text-slate-400"></i>
                                        </div>
                                        <select name="status"
                                            class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 appearance-none">
                                            <option value="active">Active (Bisa Login)</option>
                                            <option value="inactive">Inactive (Dibekukan)</option>
                                        </select>
                                        <i
                                            class="bi bi-chevron-down absolute right-4 top-3.5 text-slate-400 text-xs pointer-events-none"></i>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Password</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="bi bi-key text-slate-400"></i>
                                    </div>
                                    <input type="password" name="password" id="password" required
                                        class="w-full pl-11 pr-12 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 transition-all"
                                        placeholder="••••••••">
                                    <button type="button" onclick="togglePassword()"
                                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600">
                                        <i class="bi bi-eye" id="toggleIcon"></i>
                                    </button>
                                </div>
                                <p class="text-xs text-slate-400 mt-1">*Minimal 6 karakter.</p>
                            </div>

                            <div class="pt-6 flex gap-4">
                                <button type="submit"
                                    class="flex-1 bg-primary-600 hover:bg-primary-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-primary-500/30 transition-all flex items-center justify-center gap-2">
                                    <i class="bi bi-check-lg"></i> Simpan User
                                </button>
                                <a href="<?= url('/admin/users') ?>"
                                    class="px-6 py-3.5 bg-white border border-slate-300 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all">
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

<?php include APP_PATH . '/views/admin/layouts/footer.php'; ?>

<script>
// Preview Image Logic
function previewImage(input) {
    const preview = document.getElementById('preview-img');
    const placeholder = document.getElementById('placeholder-icon');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        }

        reader.readAsDataURL(input.files[0]);
    }
}

// Toggle Password Visibility
function togglePassword() {
    const input = document.getElementById('password');
    const icon = document.getElementById('toggleIcon');

    if (input.type === "password") {
        input.type = "text";
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        input.type = "password";
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
}
</script>
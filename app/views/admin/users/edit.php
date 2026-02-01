<?php
$title = 'Edit User';
$adminLayout = true;
?>
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
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Edit User</h1>
                    <div class="flex items-center gap-2 text-sm text-slate-500 mt-1">
                        <span>Management</span>
                        <i class="bi bi-chevron-right text-xs"></i>
                        <span class="text-primary-600 font-medium"><?= e($user['name']) ?></span>
                    </div>
                </div>
            </div>

            <?php displayFlash(); ?>

            <form action="<?= url('/admin/users/' . $user['id'] . '/edit') ?>" method="POST"
                enctype="multipart/form-data">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 h-fit">
                        <div class="flex flex-col items-center mb-6">

                            <div class="relative group cursor-pointer w-32 h-32">
                                <div
                                    class="w-32 h-32 rounded-full overflow-hidden border-4 border-white shadow-lg bg-slate-100 relative">

                                    <?php
                                    // LOGIKA: Cek apakah user punya foto?
                                    $hasPhoto = !empty($user['image']);
                                    // Jika ada foto, pakai URL-nya. Jika tidak, pakai placeholder
                                    $photoSrc = $hasPhoto ? $user['image'] : '';
                                    ?>

                                    <img id="preview-img" src="<?= $photoSrc ?>"
                                        class="w-full h-full object-cover <?= $hasPhoto ? '' : 'hidden' ?>"
                                        alt="Foto Profil">

                                    <div id="placeholder-icon"
                                        class="absolute inset-0 flex items-center justify-center text-slate-300 <?= $hasPhoto ? 'hidden' : '' ?>">
                                        <i class="bi bi-person-fill text-6xl"></i>
                                    </div>

                                </div>

                                <div class="absolute inset-0 bg-black/40 rounded-full opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center"
                                    onclick="document.getElementById('image').click()">
                                    <i class="bi bi-camera-fill text-white text-2xl"></i>
                                </div>

                                <input type="file" name="image" id="image" class="hidden" accept="image/*"
                                    onchange="previewImage(this)">
                            </div>

                            <p class="text-xs text-slate-500 mt-3 text-center">Klik foto untuk mengganti.<br>Format:
                                JPG, PNG (Max 2MB)</p>
                        </div>

                        <div class="border-t border-slate-100 pt-4 text-center">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Status Akun</span>
                            <div class="mt-1">
                                <?php if ($user['status'] == 'active'): ?>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Active
                                </span>
                                <?php else: ?>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Inactive
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-2 space-y-6">
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                            <h2 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                                <i class="bi bi-person-vcard text-primary-600"></i> Informasi Pengguna
                            </h2>

                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-slate-700">Nama Lengkap</label>
                                    <input type="text" name="name" value="<?= e($user['name']) ?>"
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 transition-all"
                                        placeholder="Contoh: Ahmad Fauzi" required>
                                </div>

                                <div>
                                    <label class="block mb-2 text-sm font-bold text-slate-700">Alamat Email</label>
                                    <input type="email" name="email" value="<?= e($user['email']) ?>"
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 transition-all"
                                        placeholder="nama@email.com" required>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block mb-2 text-sm font-bold text-slate-700">Role (Peran)</label>
                                        <select name="role_id"
                                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 cursor-pointer">
                                            <?php foreach ($roles as $role): ?>
                                            <option value="<?= $role['id'] ?>"
                                                <?= $user['role_id'] == $role['id'] ? 'selected' : '' ?>>
                                                <?= ucfirst($role['role_name']) ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block mb-2 text-sm font-bold text-slate-700">Status</label>
                                        <select name="status"
                                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 cursor-pointer">
                                            <option value="active" <?= $user['status'] == 'active' ? 'selected' : '' ?>>
                                                Active</option>
                                            <option value="inactive"
                                                <?= $user['status'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="pt-4 border-t border-slate-100">
                                    <label class="block mb-2 text-sm font-bold text-slate-700">
                                        Password Baru <span class="text-slate-400 font-normal text-xs">(Opsional)</span>
                                    </label>
                                    <div class="relative">
                                        <input type="password" name="password" id="password"
                                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 transition-all"
                                            placeholder="Kosongkan jika tidak ingin mengubah password">
                                        <button type="button" onclick="togglePassword()"
                                            class="absolute inset-y-0 right-0 px-4 text-slate-400 hover:text-slate-600">
                                            <i class="bi bi-eye" id="toggleIcon"></i>
                                        </button>
                                    </div>
                                    <p class="text-xs text-slate-500 mt-2">Minimal 6 karakter. Gunakan kombinasi huruf
                                        dan angka.</p>
                                </div>
                            </div>

                            <div class="mt-8 flex gap-3">
                                <button type="submit"
                                    class="px-6 py-3.5 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl shadow-lg shadow-primary-500/30 transition-all transform active:scale-95">
                                    Simpan Perubahan
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
// Logic: Preview Gambar saat file dipilih
function previewImage(input) {
    const preview = document.getElementById('preview-img');
    const placeholder = document.getElementById('placeholder-icon');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            // Tampilkan elemen img, sembunyikan placeholder
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        }

        reader.readAsDataURL(input.files[0]);
    }
}

// Logic: Lihat Password
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
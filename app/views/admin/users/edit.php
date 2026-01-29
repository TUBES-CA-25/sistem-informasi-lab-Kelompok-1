<?php $title = 'Edit User'; $adminLayout = true; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="admin-layout antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>
    
    <main class="p-4 sm:ml-64 pt-8 transition-all duration-300">
        <div class="max-w-2xl mx-auto">
            
            <div class="flex items-center gap-4 mb-8">
                <a href="<?= url('/admin/users') ?>" 
                   class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-primary-600 hover:border-primary-200 shadow-sm transition-all"
                   title="Back to List">
                    <i class="bi bi-arrow-left text-lg"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Edit User</h1>
                    <div class="flex items-center gap-2 text-sm text-slate-500 mt-1">
                        <span>Users Management</span>
                        <i class="bi bi-chevron-right text-xs"></i>
                        <span class="text-primary-600 font-medium">Edit #<?= $user['id'] ?></span>
                    </div>
                </div>
            </div>
            
            <?php displayFlash(); ?>
            
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200">
                
                <form method="POST" action="<?= url('/admin/users/' . $user['id'] . '/edit') ?>">
                    
                    <div class="flex justify-center mb-8">
                        <div class="w-24 h-24 rounded-full bg-gradient-to-br from-slate-100 to-slate-200 border-4 border-white shadow-sm flex items-center justify-center text-slate-500 font-bold text-3xl">
                            <?= strtoupper(substr($user['name'], 0, 1)) ?>
                        </div>
                    </div>

                    <div class="space-y-6">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block mb-2 text-sm font-semibold text-slate-700">Full Name <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none text-slate-400">
                                        <i class="bi bi-person text-lg"></i>
                                    </div>
                                    <input type="text" name="name" id="name" value="<?= e($user['name']) ?>"
                                           class="w-full ps-11 p-3 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block transition-all" 
                                           placeholder="John Doe" required>
                                </div>
                            </div>
                            <div>
                                <label for="email" class="block mb-2 text-sm font-semibold text-slate-700">Email Address <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none text-slate-400">
                                        <i class="bi bi-envelope text-lg"></i>
                                    </div>
                                    <input type="email" name="email" id="email" value="<?= e($user['email']) ?>"
                                           class="w-full ps-11 p-3 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block transition-all" 
                                           placeholder="john@example.com" required>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 bg-amber-50 rounded-xl border border-amber-100">
                            <label for="password" class="block mb-2 text-sm font-semibold text-slate-700">Change Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none text-amber-500/70">
                                    <i class="bi bi-key text-lg"></i>
                                </div>
                                <input type="password" name="password" id="password" minlength="6"
                                       class="w-full ps-11 pe-12 p-3 bg-white border border-amber-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-amber-200 focus:border-amber-500 block transition-all placeholder:text-slate-400" 
                                       placeholder="Leave blank to keep current password">
                                <button type="button" onclick="togglePassword()" class="absolute inset-y-0 end-0 flex items-center pe-4 text-slate-400 hover:text-slate-600 transition-colors">
                                    <i class="bi bi-eye-slash" id="toggleIcon"></i>
                                </button>
                            </div>
                            <p class="mt-2 text-xs text-amber-600/80 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle-fill"></i> Only fill this if you want to reset the user's password.
                            </p>
                        </div>

                        <div>
                            <label for="role_id" class="block mb-2 text-sm font-semibold text-slate-700">User Role <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <select name="role_id" id="role_id" 
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block appearance-none cursor-pointer" required>
                                    <option value="">-- Select System Role --</option>
                                    <?php foreach ($roles as $role): ?>
                                        <option value="<?= $role['id'] ?>" <?= $role['id'] == $user['role_id'] ? 'selected' : '' ?>>
                                            <?= e($role['role_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                                    <i class="bi bi-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-semibold text-slate-700">Account Status</label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="group relative flex items-center p-4 bg-white border rounded-xl cursor-pointer hover:bg-slate-50 transition-all border-slate-200 has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50/30 has-[:checked]:ring-1 has-[:checked]:ring-emerald-500">
                                    <div class="flex items-center gap-3">
                                        <div class="w-4 h-4 rounded-full border border-slate-300 flex items-center justify-center bg-white group-has-[:checked]:border-emerald-500">
                                            <div class="w-2 h-2 rounded-full bg-emerald-500 hidden group-has-[:checked]:block"></div>
                                        </div>
                                        <span class="text-sm font-medium text-slate-700">Active</span>
                                    </div>
                                    <input type="radio" name="status" value="active" class="hidden" 
                                        <?= strtolower($user['status']) == 'active' ? 'checked' : '' ?>>
                                </label>

                                <label class="group relative flex items-center p-4 bg-white border rounded-xl cursor-pointer hover:bg-slate-50 transition-all border-slate-200 has-[:checked]:border-slate-500 has-[:checked]:bg-slate-50 has-[:checked]:ring-1 has-[:checked]:ring-slate-500">
                                    <div class="flex items-center gap-3">
                                        <div class="w-4 h-4 rounded-full border border-slate-300 flex items-center justify-center bg-white group-has-[:checked]:border-slate-500">
                                            <div class="w-2 h-2 rounded-full bg-slate-500 hidden group-has-[:checked]:block"></div>
                                        </div>
                                        <span class="text-sm font-medium text-slate-700">Inactive</span>
                                    </div>
                                    <input type="radio" name="status" value="inactive" class="hidden"
                                        <?= strtolower($user['status']) == 'inactive' ? 'checked' : '' ?>>
                                </label>
                            </div>
                        </div>

                    </div>

                    <div class="flex flex-col sm:flex-row items-center gap-4 mt-8 pt-6 border-t border-slate-100">
                        <button type="submit" class="w-full sm:flex-1 text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 font-semibold rounded-xl text-sm px-5 py-3 transition-all shadow-lg shadow-primary-500/30 flex justify-center items-center gap-2 group">
                            <i class="bi bi-check-lg group-hover:scale-110 transition-transform"></i>
                            Save Changes
                        </button>
                        
                        <a href="<?= url('/admin/users') ?>" class="w-full sm:flex-1 text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 hover:text-slate-900 focus:ring-4 focus:ring-slate-100 font-medium rounded-xl text-sm px-5 py-3 text-center transition-all">
                            Cancel
                        </a>
                    </div>

                </form>
            </div>
            
            <div class="mt-6 text-center">
                <p class="text-xs text-slate-400">
                    User created at: <span class="font-mono"><?= formatDate($user['created_at']) ?></span>
                </p>
            </div>

        </div>
    </main>
</div>

<?php include APP_PATH . '/views/admin/layouts/footer.php'; ?>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const icon = document.getElementById('toggleIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        }
    }
</script>
<?php $title = 'User Management';
$adminLayout = true; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-8 transition-all duration-300">
        <div class="max-w-7xl mx-auto">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">User Management</h1>
                    <p class="text-slate-500 text-sm mt-1">Kelola data pengguna, dosen, dan asisten laboratorium.</p>
                </div>

                <div class="flex gap-2">
                    <a href="<?= url('/admin/users/import') ?>"
                        class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium px-4 py-2.5 rounded-xl shadow-sm transition-all">
                        <i class="bi bi-file-earmark-arrow-up"></i>
                        <span class="hidden sm:inline">Import</span>
                    </a>

                    <a href="<?= url('/admin/users/export') ?>"
                        class="inline-flex items-center gap-2 bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 text-sm font-medium px-4 py-2.5 rounded-xl shadow-sm transition-all">
                        <i class="bi bi-download"></i>
                        <span class="hidden sm:inline">Export</span>
                    </a>

                    <a href="<?= url('/admin/users/create') ?>"
                        class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium px-5 py-2.5 rounded-xl shadow-lg shadow-primary-500/30 transition-all">
                        <i class="bi bi-person-plus-fill"></i>
                        <span>Tambah</span>
                    </a>
                </div>
            </div>

            <?php displayFlash(); ?>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

                <div
                    class="p-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white">
                    <div class="text-sm font-medium text-slate-500">
                        Total Users: <span class="font-bold text-slate-800"><?= $totalUsers ?></span>
                    </div>

                    <form action="" method="GET" class="relative w-full sm:w-64">
                        <div
                            class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                            <i class="bi bi-search"></i>
                        </div>
                        <input type="text" name="q" value="<?= e($keyword ?? '') ?>"
                            class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2.5 transition-all"
                            placeholder="Cari nama atau email...">
                    </form>
                </div>

                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-600">
                        <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-semibold">User Profile</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Role</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Status</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Joined Date</th>
                                <th scope="col" class="px-6 py-4 font-semibold text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php if (!empty($users)): ?>
                                <?php foreach ($users as $user): ?>
                                    <tr class="hover:bg-slate-50/80 transition-colors duration-150 group">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="relative">
                                                    <?php
                                                    $photo = !empty($user['image']) ? $user['image'] : 'https://ui-avatars.com/api/?name=' . urlencode($user['name']) . '&background=random';
                                                    ?>
                                                    <img class="w-10 h-10 rounded-full object-cover border border-slate-200 group-hover:border-primary-200 transition-colors"
                                                        src="<?= $photo ?>" alt="<?= e($user['name']) ?>">
                                                    <div
                                                        class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full">
                                                    </div>
                                                </div>
                                                <div>
                                                    <div
                                                        class="font-bold text-slate-900 group-hover:text-primary-600 transition-colors">
                                                        <?= e($user['name']) ?></div>
                                                    <div class="text-xs text-slate-500"><?= e($user['email']) ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                                <?= ucfirst($user['role_name']) ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <?php if ($user['status'] == 'active'): ?>
                                                <span
                                                    class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-100">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Active
                                                </span>
                                            <?php else: ?>
                                                <span
                                                    class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-500 border border-slate-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Inactive
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 text-xs font-mono text-slate-500">
                                            <?= date('d M Y', strtotime($user['created_at'])) ?>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div
                                                class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <a href="<?= url('/admin/users/' . $user['id'] . '/edit') ?>"
                                                    class="p-2 bg-white border border-slate-200 rounded-lg text-slate-600 hover:text-primary-600 hover:border-primary-200 shadow-sm transition-all"
                                                    title="Edit User">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <form action="<?= url('/admin/users/' . $user['id'] . '/delete') ?>"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                    <button type="submit"
                                                        class="p-2 bg-white border border-slate-200 rounded-lg text-slate-600 hover:text-red-600 hover:border-red-200 shadow-sm transition-all"
                                                        title="Delete User">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-400 bg-slate-50/50">
                                        <div
                                            class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                            <i class="bi bi-search text-2xl"></i>
                                        </div>
                                        <p class="font-medium">Tidak ada user ditemukan.</p>
                                        <p class="text-xs mt-1">Coba kata kunci lain atau tambah user baru.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($totalPages > 1): ?>
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex items-center justify-between">
                        <div class="text-xs text-slate-500">
                            Halaman <span class="font-bold text-slate-700"><?= $currentPage ?></span> dari <span
                                class="font-bold text-slate-700"><?= $totalPages ?></span>
                        </div>

                        <div class="flex gap-2">
                            <?php if ($currentPage > 1): ?>
                                <a href="?page=<?= $currentPage - 1 ?>&q=<?= $keyword ?>"
                                    class="px-3 py-1.5 bg-white border border-slate-300 rounded-lg text-xs font-bold text-slate-600 hover:bg-slate-50 hover:text-primary-600 transition-colors shadow-sm">
                                    <i class="bi bi-chevron-left mr-1"></i> Prev
                                </a>
                            <?php else: ?>
                                <span
                                    class="px-3 py-1.5 bg-slate-100 border border-slate-200 rounded-lg text-xs font-bold text-slate-400 cursor-not-allowed">
                                    <i class="bi bi-chevron-left mr-1"></i> Prev
                                </span>
                            <?php endif; ?>

                            <?php if ($currentPage < $totalPages): ?>
                                <a href="?page=<?= $currentPage + 1 ?>&q=<?= $keyword ?>"
                                    class="px-3 py-1.5 bg-white border border-slate-300 rounded-lg text-xs font-bold text-slate-600 hover:bg-slate-50 hover:text-primary-600 transition-colors shadow-sm">
                                    Next <i class="bi bi-chevron-right ml-1"></i>
                                </a>
                            <?php else: ?>
                                <span
                                    class="px-3 py-1.5 bg-slate-100 border border-slate-200 rounded-lg text-xs font-bold text-slate-400 cursor-not-allowed">
                                    Next <i class="bi bi-chevron-right ml-1"></i>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>

        </div>
    </main>
</div>

<?php include APP_PATH . '/views/admin/layouts/footer.php'; ?>
<?php $title = 'Manajemen Pengguna';
$adminLayout = true; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-8 transition-all duration-300">
        <div class="max-w-7xl mx-auto">

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Manajemen Pengguna</h1>
                    <p class="text-slate-500 text-sm mt-1">Kelola data Dosen, Asisten, dan Staff Laboratorium.</p>
                </div>

                <a href="<?= url('/admin/users/create') ?>"
                    class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium px-5 py-2.5 rounded-xl shadow-lg shadow-primary-500/30 transition-all transform hover:-translate-y-0.5 focus:ring-4 focus:ring-primary-100">
                    <i class="bi bi-person-plus-fill text-lg"></i>
                    <span>Tambah User Baru</span>
                </a>
            </div>

            <?php displayFlash(); ?>

            <div class="mb-6 border-b border-slate-200">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-slate-500">
                    <li class="mr-2">
                        <a href="<?= url('/admin/users') ?>"
                            class="inline-block p-4 border-b-2 rounded-t-lg hover:text-slate-600 hover:border-slate-300 <?= !$currentRole ? 'text-primary-600 border-primary-600 active' : 'border-transparent' ?>">
                            Semua
                            <span
                                class="bg-slate-100 text-slate-600 text-xs font-semibold px-2 py-0.5 rounded-full ml-1">
                                <?= $total_users ?? 0 ?>
                            </span>
                        </a>
                    </li>

                    <?php if (!empty($roles)): ?>
                    <?php foreach ($roles as $role): ?>
                    <li class="mr-2">
                        <a href="<?= url('/admin/users?role=' . $role['role_name']) ?>"
                            class="inline-block p-4 border-b-2 rounded-t-lg hover:text-slate-600 hover:border-slate-300 capitalize <?= $currentRole === $role['role_name'] ? 'text-primary-600 border-primary-600 active' : 'border-transparent' ?>">
                            <?= $role['role_name'] ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-500">
                        <thead class="bg-slate-50 text-slate-700 uppercase text-xs font-bold tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Nama User</th>
                                <th class="px-6 py-4">Role / Jabatan</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php if (!empty($users)): ?>
                            <?php foreach ($users as $u): ?>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-lg font-bold text-slate-500 overflow-hidden">
                                            <?php if (!empty($u['image'])): ?>
                                            <img src="<?= htmlspecialchars($u['image']) ?>" alt="User"
                                                class="w-full h-full object-cover">
                                            <?php else: ?>
                                            <?= strtoupper(substr($u['name'], 0, 1)) ?>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-900"><?= htmlspecialchars($u['name']) ?>
                                            </div>
                                            <div class="text-xs text-slate-400"><?= htmlspecialchars($u['email']) ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <?php
                                            // Warna Badge Berdasarkan Role
                                            $roleColor = 'bg-slate-100 text-slate-600';
                                            if ($u['role_name'] === 'admin') $roleColor = 'bg-rose-100 text-rose-700 border-rose-200';
                                            elseif ($u['role_name'] === 'koordinator') $roleColor = 'bg-purple-100 text-purple-700 border-purple-200';
                                            elseif ($u['role_name'] === 'asisten') $roleColor = 'bg-sky-100 text-sky-700 border-sky-200';
                                            elseif ($u['role_name'] === 'dosen') $roleColor = 'bg-amber-100 text-amber-700 border-amber-200';
                                            ?>
                                    <span
                                        class="px-2.5 py-0.5 rounded-full text-xs font-bold border <?= $roleColor ?> uppercase tracking-wide">
                                        <?= htmlspecialchars($u['role_name']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <?php if ($u['status'] === 'active'): ?>
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                    </span>
                                    <?php else: ?>
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-500 border border-slate-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Inactive
                                    </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="<?= url('/admin/users/' . $u['id'] . '/edit') ?>"
                                            class="p-2 bg-white border border-slate-200 text-slate-600 rounded-lg hover:bg-slate-50 hover:text-blue-600 transition-colors"
                                            title="Edit User">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <?php if ($u['id'] != getUserId()): // Cegah hapus diri sendiri 
                                                ?>
                                        <form action="<?= url('/admin/users/' . $u['id'] . '/delete') ?>" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                            <button type="submit"
                                                class="p-2 bg-white border border-slate-200 text-slate-600 rounded-lg hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 transition-colors"
                                                title="Hapus User">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-3 border border-slate-100">
                                            <i class="bi bi-people text-3xl"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-slate-900">Tidak ada user ditemukan</h3>
                                        <p class="text-slate-500 max-w-sm mt-1 text-sm">Coba ganti filter atau tambahkan
                                            user baru.</p>
                                    </div>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<?php include APP_PATH . '/views/admin/layouts/footer.php'; ?>
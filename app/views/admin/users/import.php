<?php $title = 'Import User Massal'; $adminLayout = true; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-8 transition-all duration-300">
        <div class="max-w-3xl mx-auto">

            <div class="flex items-center gap-4 mb-8">
                <a href="<?= url('/admin/users') ?>"
                    class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-primary-600 hover:border-primary-200 shadow-sm transition-all">
                    <i class="bi bi-arrow-left text-lg"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Import User Massal</h1>
                    <p class="text-slate-500 text-sm mt-1">Upload file Excel untuk mendaftarkan user sekaligus.</p>
                </div>
            </div>

            <?php displayFlash(); ?>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-8">

                    <form action="<?= url('/admin/users/import') ?>" method="POST" enctype="multipart/form-data">
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-bold text-slate-700">File Excel / CSV</label>

                            <div class="flex items-center justify-center w-full">
                                <label for="dropzone-file"
                                    class="flex flex-col items-center justify-center w-full h-48 border-2 border-slate-300 border-dashed rounded-2xl cursor-pointer bg-slate-50 hover:bg-slate-100 transition-all">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <i class="bi bi-cloud-arrow-up text-4xl text-slate-400 mb-3"></i>
                                        <p class="mb-2 text-sm text-slate-500"><span class="font-semibold">Klik untuk
                                                upload</span> atau drag and drop</p>
                                        <p class="text-xs text-slate-400">XLSX, XLS, atau CSV (MAX. 5MB)</p>
                                    </div>
                                    <input id="dropzone-file" name="file" type="file" class="hidden"
                                        accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                        onchange="showFileName(this)" required />
                                </label>
                            </div>
                            <p id="file-name" class="mt-2 text-sm text-primary-600 font-medium text-center hidden"></p>
                        </div>

                        <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-8">
                            <h4 class="font-bold text-blue-800 text-sm mb-2 flex items-center gap-2">
                                <i class="bi bi-info-circle-fill"></i> Ketentuan Import:
                            </h4>
                            <ul class="list-disc list-inside text-xs text-blue-700 space-y-1 ml-1">
                                <li>Pastikan header kolom sesuai template: <strong>Nama, Email, Role, Status,
                                        Password</strong>.</li>
                                <li>Sistem akan melewati baris jika <strong>Email</strong> sudah terdaftar.</li>
                                <li>Penulisan Role tidak case-sensitive (misal: "Admin", "admin", "ADMIN" dianggap
                                    sama).</li>
                                <li>Password akan otomatis di-enkripsi oleh sistem.</li>
                            </ul>
                        </div>

                        <div class="flex gap-3">
                            <button type="submit"
                                class="flex-1 bg-primary-600 hover:bg-primary-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-primary-500/30 transition-all">
                                <i class="bi bi-file-earmark-spreadsheet mr-2"></i> Proses Import
                            </button>
                            <a href="<?= url('/admin/users') ?>"
                                class="px-6 py-3.5 bg-white border border-slate-300 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all">
                                Batal
                            </a>
                        </div>
                    </form>

                </div>

                <div class="bg-slate-50 px-8 py-4 border-t border-slate-200 flex justify-between items-center">
                    <span class="text-xs text-slate-500">Butuh template?</span>
                    <a href="#" onclick="alert('Gunakan file user.xlsx yang Anda miliki.')"
                        class="text-xs font-bold text-primary-600 hover:underline">
                        Download Template User
                    </a>
                </div>
            </div>

        </div>
    </main>
</div>

<?php include APP_PATH . '/views/admin/layouts/footer.php'; ?>

<script>
function showFileName(input) {
    const fileName = input.files[0]?.name;
    const label = document.getElementById('file-name');
    if (fileName) {
        label.textContent = "File terpilih: " + fileName;
        label.classList.remove('hidden');
    }
}
</script>
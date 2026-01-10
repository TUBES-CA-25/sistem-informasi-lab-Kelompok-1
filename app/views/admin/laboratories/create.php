<?php $title = 'Create Laboratory'; $adminLayout = true; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="admin-layout antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>
    
    <main class="p-4 sm:ml-64 pt-8 transition-all duration-300">
        <div class="max-w-2xl mx-auto">
            
            <div class="flex items-center gap-4 mb-8">
                <a href="<?= url('/admin/laboratories') ?>" 
                   class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-primary-600 hover:border-primary-200 shadow-sm transition-all"
                   title="Back to List">
                    <i class="bi bi-arrow-left text-lg"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Add New Laboratory</h1>
                    <p class="text-slate-500 text-sm mt-1">Register a new computer lab facility or room.</p>
                </div>
            </div>
            
            <?php displayFlash(); ?>
            
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200">
                
                <form method="POST" action="<?= url('/admin/laboratories/create') ?>">
                    
                    <div class="space-y-6">
                        
                        <div>
                            <label for="lab_name" class="block mb-2 text-sm font-semibold text-slate-700">
                                Laboratory Name <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none text-slate-400">
                                    <i class="bi bi-pc-display-horizontal text-lg"></i>
                                </div>
                                <input type="text" name="lab_name" id="lab_name" 
                                       class="w-full ps-11 p-3 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block transition-all placeholder:text-slate-400" 
                                       placeholder="e.g. Multimedia Lab 01" required>
                            </div>
                        </div>

                        <div>
                            <label for="location" class="block mb-2 text-sm font-semibold text-slate-700">
                                Location / Building <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none text-slate-400">
                                    <i class="bi bi-geo-alt text-lg"></i>
                                </div>
                                <input type="text" name="location" id="location" 
                                       class="w-full ps-11 p-3 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block transition-all placeholder:text-slate-400" 
                                       placeholder="e.g. Building A, 2nd Floor" required>
                            </div>
                        </div>

                        <div>
                            <label for="description" class="block mb-2 text-sm font-semibold text-slate-700">
                                Description & Facilities
                            </label>
                            <textarea name="description" id="description" rows="4" 
                                      class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block transition-all resize-none placeholder:text-slate-400"
                                      placeholder="Briefly describe the lab's purpose or list main facilities (e.g. 30 PCs, Projector, AC)..."></textarea>
                        </div>

                    </div>

                    <div class="flex items-center gap-4 mt-8 pt-6 border-t border-slate-100">
                        <button type="submit" class="flex-1 text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 font-semibold rounded-xl text-sm px-5 py-3 transition-all shadow-lg shadow-primary-500/30 flex justify-center items-center gap-2 group">
                            <i class="bi bi-plus-lg group-hover:scale-110 transition-transform"></i>
                            Create Laboratory
                        </button>
                        
                        <a href="<?= url('/admin/laboratories') ?>" class="flex-1 text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 hover:text-slate-900 focus:ring-4 focus:ring-slate-100 font-medium rounded-xl text-sm px-5 py-3 text-center transition-all">
                            Cancel
                        </a>
                    </div>

                </form>
            </div>
            
        </div>
    </main>
</div>
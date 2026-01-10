<?php $title = 'Edit Assistant Schedule'; $adminLayout = true; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="admin-layout antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>
    
    <main class="p-4 sm:ml-64 pt-8 transition-all duration-300">
        <div class="max-w-2xl mx-auto">
            
            <div class="flex items-center gap-4 mb-8">
                <a href="<?= url('/admin/assistant-schedules') ?>" 
                   class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-primary-600 hover:border-primary-200 shadow-sm transition-all"
                   title="Back to List">
                    <i class="bi bi-arrow-left text-lg"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Edit Schedule</h1>
                    <div class="flex items-center gap-2 text-sm text-slate-500 mt-1">
                        <span>Schedules</span>
                        <i class="bi bi-chevron-right text-xs"></i>
                        <span class="text-primary-600 font-medium">Edit #<?= $schedule['id'] ?></span>
                    </div>
                </div>
            </div>
            
            <?php displayFlash(); ?>
            
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200">
                
                <form method="POST" action="<?= url('/admin/assistant-schedules/' . $schedule['id'] . '/edit') ?>">
                    
                    <div class="space-y-6">
                        
                        <div>
                            <label for="user_id" class="block mb-2 text-sm font-semibold text-slate-700">
                                <i class="bi bi-person mr-1 text-slate-400"></i> Assistant Name <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="user_id" id="user_id" 
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block appearance-none transition-all cursor-pointer" required>
                                    <option value="">-- Select Assistant --</option>
                                    <?php foreach ($assistants as $assistant): ?>
                                        <option value="<?= $assistant['id'] ?>" <?= $schedule['user_id'] == $assistant['id'] ? 'selected' : '' ?>>
                                            <?= e($assistant['name']) ?> &mdash; <?= e($assistant['email']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                                    <i class="bi bi-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="day" class="block mb-2 text-sm font-semibold text-slate-700">
                                <i class="bi bi-calendar-event mr-1 text-slate-400"></i> Day <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="day" id="day" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block appearance-none transition-all cursor-pointer" required>
                                    <option value="">-- Select Day --</option>
                                    <?php 
                                    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                    foreach ($days as $day): 
                                    ?>
                                        <option value="<?= $day ?>" <?= $schedule['day'] == $day ? 'selected' : '' ?>><?= $day ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                                    <i class="bi bi-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label for="start_time" class="block mb-2 text-sm font-semibold text-slate-700">Start Time <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none text-slate-400">
                                        <i class="bi bi-clock"></i>
                                    </div>
                                    <input type="time" name="start_time" id="start_time" value="<?= e($schedule['start_time']) ?>" 
                                           class="w-full ps-11 p-3 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block transition-all" required>
                                </div>
                            </div>
                            
                            <div>
                                <label for="end_time" class="block mb-2 text-sm font-semibold text-slate-700">End Time <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none text-slate-400">
                                        <i class="bi bi-clock-history"></i>
                                    </div>
                                    <input type="time" name="end_time" id="end_time" value="<?= e($schedule['end_time']) ?>" 
                                           class="w-full ps-11 p-3 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block transition-all" required>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-slate-100 my-6"></div>

                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                            <label for="status" class="block mb-2 text-sm font-semibold text-slate-700">Schedule Status</label>
                            <div class="flex flex-col sm:flex-row gap-4">
                                <div class="relative w-full">
                                    <select name="status" id="status" class="w-full px-4 py-3 bg-white border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block appearance-none" required>
                                        <option value="active" <?= (strtolower($schedule['status']) == 'active') ? 'selected' : '' ?>>Active</option>
                                        <option value="inactive" <?= (strtolower($schedule['status']) == 'inactive') ? 'selected' : '' ?>>Inactive</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                                        <i class="bi bi-chevron-down text-xs"></i>
                                    </div>
                                </div>
                                <div class="text-xs text-slate-500 flex items-center">
                                    <i class="bi bi-info-circle mr-2"></i>
                                    Inactive schedules will be hidden from the main dashboard view.
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="flex items-center gap-4 mt-8 pt-6 border-t border-slate-100">
                        <button type="submit" class="flex-1 text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 font-semibold rounded-xl text-sm px-5 py-3 transition-all shadow-lg shadow-primary-500/30 flex justify-center items-center gap-2">
                            <i class="bi bi-check-lg"></i>
                            Update Schedule
                        </button>
                        
                        <a href="<?= url('/admin/assistant-schedules') ?>" class="flex-1 text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 hover:text-slate-900 focus:ring-4 focus:ring-slate-100 font-medium rounded-xl text-sm px-5 py-3 text-center transition-all">
                            Cancel
                        </a>
                    </div>

                </form>
            </div>
            
        </div>
    </main>
</div>
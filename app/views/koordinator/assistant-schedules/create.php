<?php $title = 'Create Assistant Schedule'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex items-center gap-4 mb-8">
            <a href="<?= url('/koordinator/assistant-schedules') ?>"
               class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-primary-600 hover:border-primary-200 shadow-sm transition-all"
               title="Back to List">
                <i class="bi bi-arrow-left text-lg"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">Add New Schedule</h1>
                <p class="text-slate-500 text-sm mt-1">Assign a new shift to a laboratory assistant.</p>
            </div>
        </div>

        <?php displayFlash(); ?>

        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200">

            <form method="POST" action="<?= url('/koordinator/assistant-schedules/create') ?>">

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
                                    <option value="<?= $assistant['id'] ?>"><?= e($assistant['name']) ?> (<?= e($assistant['email']) ?>)</option>
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
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                                <option value="Saturday">Saturday</option>
                                <option value="Sunday">Sunday</option>
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
                                <input type="time" name="start_time" id="start_time"
                                       class="w-full ps-11 p-3 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block transition-all" required>
                            </div>
                        </div>

                        <div>
                            <label for="end_time" class="block mb-2 text-sm font-semibold text-slate-700">End Time <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none text-slate-400">
                                    <i class="bi bi-clock-history"></i>
                                </div>
                                <input type="time" name="end_time" id="end_time"
                                       class="w-full ps-11 p-3 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block transition-all" required>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-slate-100 my-2"></div>

                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                        <label for="status" class="block mb-2 text-sm font-semibold text-slate-700">Initial Status</label>
                        <div class="relative">
                            <select name="status" id="status" class="w-full px-4 py-3 bg-white border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block appearance-none transition-all cursor-pointer" required>
                                <option value="scheduled" selected>Scheduled (Default)</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                                <i class="bi bi-chevron-down text-xs"></i>
                            </div>
                        </div>
                        <p class="mt-2 text-xs text-slate-500">
                            <i class="bi bi-info-circle mr-1"></i>
                            'Scheduled' means the assistant is expected to be present.
                        </p>
                    </div>

                </div>

                <div class="flex items-center gap-4 mt-8 pt-6 border-t border-slate-100">
                    <button type="submit" class="flex-1 text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 font-semibold rounded-xl text-sm px-5 py-3 transition-all shadow-lg shadow-primary-500/30 flex justify-center items-center gap-2">
                        <i class="bi bi-plus-lg"></i>
                        Create Schedule
                    </button>

                    <a href="<?= url('/koordinator/assistant-schedules') ?>" class="flex-1 text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 hover:text-slate-900 focus:ring-4 focus:ring-slate-100 font-medium rounded-xl text-sm px-5 py-3 text-center transition-all">
                        Cancel
                    </a>
                </div>

            </form>
        </div>

    </div>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>

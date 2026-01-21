<?php $title = 'Kalender Akademik';
$adminLayout = true; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>

<div class="admin-layout antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-8 transition-all duration-300">
        <div class="max-w-7xl mx-auto">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Kalender Akademik</h1>
                    <p class="text-slate-500 text-sm mt-1">Pantau slot kosong dan jadwal penggunaan laboratorium.</p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <div class="relative">
                        <select id="labFilter"
                            class="bg-white border border-slate-300 text-slate-700 text-sm rounded-xl focus:ring-sky-500 focus:border-sky-500 block w-full pl-3 pr-8 py-2.5 shadow-sm">
                            <option value="">Semua Laboratorium</option>
                            <?php foreach ($laboratories as $lab): ?>
                            <option value="<?= $lab['id'] ?>"><?= $lab['lab_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <a href="<?= url('/admin/schedules/create') ?>"
                        class="inline-flex items-center gap-2 bg-sky-600 hover:bg-sky-700 text-white text-sm font-medium px-5 py-2.5 rounded-xl shadow-lg shadow-sky-500/30 transition-all">
                        <i class="bi bi-plus-lg"></i> Buat Jadwal
                    </a>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <div id='calendar' class="min-h-[750px]"></div>
            </div>

        </div>
    </main>
</div>

<div id="eventModal"
    class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform scale-100 transition-all">

        <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-slate-800" id="modalTitle">Detail Jadwal</h3>
            <button onclick="closeModal()" class="text-slate-400 hover:text-rose-500 transition-colors">
                <i class="bi bi-x-lg text-lg"></i>
            </button>
        </div>

        <div class="p-6 space-y-4">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                    <i class="bi bi-pc-display text-xl"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase">Laboratorium</p>
                    <p class="text-base font-semibold text-slate-800" id="modalLab">-</p>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <div
                    class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <i class="bi bi-clock text-xl"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase">Waktu</p>
                    <p class="text-base font-semibold text-slate-800 font-mono" id="modalTime">-</p>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <div
                    class="w-10 h-10 rounded-lg bg-violet-50 text-violet-600 flex items-center justify-center shrink-0">
                    <i class="bi bi-person-badge text-xl"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase">Dosen Pengampu</p>
                    <p class="text-base font-semibold text-slate-800" id="modalLecturer">-</p>
                </div>
            </div>
        </div>

        <div class="bg-slate-50 px-6 py-4 border-t border-slate-100 flex gap-3">
            <a href="#" id="btnEdit"
                class="flex-1 bg-amber-500 hover:bg-amber-600 text-white text-center font-bold py-2.5 rounded-xl shadow-md shadow-amber-500/20 transition-all">
                <i class="bi bi-pencil-square mr-1"></i> Edit
            </a>
            <form id="formDelete" method="POST" action="#" class="flex-1"
                onsubmit="return confirm('Hapus jadwal ini?');">
                <button type="submit"
                    class="w-full bg-rose-500 hover:bg-rose-600 text-white text-center font-bold py-2.5 rounded-xl shadow-md shadow-rose-500/20 transition-all">
                    <i class="bi bi-trash mr-1"></i> Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var labFilter = document.getElementById('labFilter');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek', // Tampilan Mingguan (Senin-Minggu)
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        slotMinTime: '07:00:00', // Jam mulai 07:00
        slotMaxTime: '18:00:00', // Jam selesai 18:00
        allDaySlot: false,
        locale: 'id', // Bahasa Indonesia
        firstDay: 1, // Mulai Senin
        expandRows: true, // Isi tinggi penuh
        height: 'auto',

        // Sumber Data
        events: '<?= url('/admin/calendar/data') ?>',

        // Klik Slot Kosong -> Redirect ke Create Jadwal (dengan pre-fill tanggal)
        dateClick: function(info) {
            // Konversi tanggal ke format YYYY-MM-DD
            // info.dateStr formatnya ISO (bisa ada T jamnya)
            // Kita ambil tanggalnya saja untuk dioper ke form create
            let dateOnly = info.dateStr.split('T')[0];

            // Redirect ke form create dengan parameter tanggal
            window.location.href = '<?= url('/admin/schedules/create') ?>?start_date=' + dateOnly;
        },

        // Klik Event -> Buka Modal Detail/CRUD
        eventClick: function(info) {
            // Isi Modal
            document.getElementById('modalTitle').innerText = info.event.title + ' (' + info.event
                .extendedProps.class_code + ')';
            document.getElementById('modalLab').innerText = info.event.extendedProps.lab_name;
            document.getElementById('modalLecturer').innerText = info.event.extendedProps.lecturer;

            // Format Jam
            const start = info.event.start.toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });
            const end = info.event.end.toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });
            document.getElementById('modalTime').innerText = start + ' - ' + end;

            // Update Link Action
            document.getElementById('btnEdit').href = '<?= url('/admin/schedules/') ?>' + info.event
                .id + '/edit';
            document.getElementById('formDelete').action = '<?= url('/admin/schedules/') ?>' + info
                .event.id + '/delete';

            // Tampilkan Modal
            document.getElementById('eventModal').classList.remove('hidden');
        }
    });

    calendar.render();

    // Filter Lab Logic
    labFilter.addEventListener('change', function() {
        var labId = this.value;
        // Refresh event source dengan parameter lab_id
        var newSource = {
            url: '<?= url('/admin/calendar/data') ?>',
            extraParams: {
                lab_id: labId
            }
        };

        // Hapus event lama & tambah baru
        var oldSource = calendar.getEventSources()[0];
        if (oldSource) oldSource.remove();
        calendar.addEventSource(newSource);
    });
});

function closeModal() {
    document.getElementById('eventModal').classList.add('hidden');
}

// Close modal on click outside
document.getElementById('eventModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>
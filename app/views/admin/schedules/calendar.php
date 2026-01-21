<?php $title = 'Kalender Jadwal';
$adminLayout = true; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>

<div class="admin-layout antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-8 transition-all duration-300">
        <div class="max-w-7xl mx-auto">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Kalender Ketersediaan</h1>
                    <p class="text-slate-500 text-sm mt-1">Pantau slot penggunaan laboratorium secara visual.</p>
                </div>

                <div class="flex items-center gap-3">
                    <select id="labFilter"
                        class="bg-white border border-slate-300 text-slate-700 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block p-2.5 shadow-sm">
                        <option value="">-- Semua Laboratorium --</option>
                        <?php foreach ($laboratories as $lab): ?>
                        <option value="<?= $lab['id'] ?>"><?= $lab['lab_name'] ?></option>
                        <?php endforeach; ?>
                    </select>

                    <a href="<?= url('/admin/schedules/create') ?>"
                        class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium px-4 py-2.5 rounded-lg shadow-md transition-all">
                        <i class="bi bi-plus-lg"></i> Buat Jadwal
                    </a>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <div id='calendar' class="min-h-[700px]"></div>
            </div>

        </div>
    </main>
</div>

<div id="eventModal"
    class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden transform scale-95 transition-all"
        id="modalContent">
        <div class="p-6">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-xl font-bold text-slate-900" id="modalTitle">Course Name</h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600">
                    <i class="bi bi-x-lg text-lg"></i>
                </button>
            </div>

            <div class="space-y-4">
                <div class="flex items-center gap-3 text-sm text-slate-600">
                    <div
                        class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                        <i class="bi bi-clock"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-800">Waktu</p>
                        <p id="modalTime">08:00 - 10:00</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 text-sm text-slate-600">
                    <div
                        class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-800">Laboratorium</p>
                        <p id="modalLab">Lab Multimedia</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 text-sm text-slate-600">
                    <div
                        class="w-8 h-8 rounded-full bg-violet-50 text-violet-600 flex items-center justify-center shrink-0">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-800">Dosen Pengampu</p>
                        <p id="modalLecturer">Nama Dosen</p>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button onclick="closeModal()"
                    class="px-4 py-2 bg-slate-100 text-slate-700 font-medium rounded-lg hover:bg-slate-200 transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var labFilter = document.getElementById('labFilter');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek', // Tampilan Mingguan
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        slotMinTime: '07:00:00', // Jam mulai tampil
        slotMaxTime: '18:00:00', // Jam selesai tampil
        allDaySlot: false, // Sembunyikan slot 'all day'
        height: 'auto',
        locale: 'id', // Bahasa Indonesia
        firstDay: 1, // Mulai hari Senin

        // Sumber Data (API)
        events: {
            url: '<?= url('/admin/schedules/data') ?>',
            failure: function() {
                alert('Gagal memuat jadwal!');
            }
        },

        // Event Click (Buka Modal)
        eventClick: function(info) {
            document.getElementById('modalTitle').innerText = info.event.title;

            // Format Waktu
            const start = info.event.start.toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });
            const end = info.event.end.toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });
            document.getElementById('modalTime').innerText = start + ' - ' + end;

            // Data Tambahan (Extended Props)
            document.getElementById('modalLab').innerText = info.event.extendedProps.lab;
            document.getElementById('modalLecturer').innerText = info.event.extendedProps.lecturer;

            document.getElementById('eventModal').classList.remove('hidden');
        }
    });

    calendar.render();

    // Fitur Filter Lab (Reload events saat dropdown berubah)
    labFilter.addEventListener('change', function() {
        var labId = this.value;
        // Update URL source event dengan parameter lab_id
        var newSource = {
            url: '<?= url('/admin/schedules/data') ?>',
            extraParams: {
                lab_id: labId
            }
        };

        // Hapus source lama & tambah source baru
        var oldSource = calendar.getEventSources()[0];
        oldSource.remove();
        calendar.addEventSource(newSource);
    });
});

// Fungsi Tutup Modal
function closeModal() {
    document.getElementById('eventModal').classList.add('hidden');
}

// Tutup modal jika klik di luar area
document.getElementById('eventModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>
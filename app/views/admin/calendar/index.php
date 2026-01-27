<?php $title = 'Kalender Akademik';
$adminLayout = true; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>

<style>
    /* --- CUSTOM CALENDAR STYLE --- */

    /* Header Toolbar */
    .fc-header-toolbar {
        margin-bottom: 1.5rem !important;
        padding: 0.5rem;
    }

    .fc-toolbar-title {
        font-size: 1.25rem !important;
        font-weight: 800 !important;
        color: #1e293b;
    }

    .fc-button {
        background-color: white !important;
        border: 1px solid #e2e8f0 !important;
        color: #64748b !important;
        font-weight: 600 !important;
        text-transform: capitalize !important;
        box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        transition: all 0.2s;
    }

    .fc-button:hover,
    .fc-button-active {
        background-color: #f8fafc !important;
        color: #0f172a !important;
        border-color: #cbd5e1 !important;
    }

    .fc-button-primary:not(:disabled).fc-button-active {
        background-color: #eff6ff !important;
        color: #2563eb !important;
        border-color: #bfdbfe !important;
    }

    /* Grid & Cells */
    .fc-daygrid-day {
        transition: background-color 0.2s;
    }

    .fc-daygrid-day:hover {
        background-color: #f8fafc;
        cursor: pointer;
    }

    .fc-col-header-cell {
        background-color: #f1f5f9;
        padding: 10px 0 !important;
        font-size: 0.75rem;
        text-transform: uppercase;
        color: #64748b;
        border-bottom: 0 !important;
    }

    .fc-daygrid-day-number {
        font-size: 0.85rem;
        font-weight: 600;
        color: #64748b;
        padding: 8px 8px 0 0 !important;
    }

    .fc-day-today {
        background-color: #f0f9ff !important;
    }

    /* Event Card Style */
    .fc-daygrid-event {
        white-space: normal !important;
        margin-top: 4px !important;
        background: transparent !important;
        border: none !important;
    }

    .event-card {
        padding: 4px 8px;
        border-radius: 6px;
        border-left-width: 4px;
        border-left-style: solid;
        font-size: 0.7rem;
        line-height: 1.3;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        transition: transform 0.1s;
    }

    .event-card:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .event-time {
        font-weight: 700;
        opacity: 0.8;
        font-size: 0.65rem;
        display: block;
        margin-bottom: 1px;
    }

    .event-title {
        font-weight: 700;
        display: block;
        margin-bottom: 2px;
    }

    .event-lab {
        font-size: 0.65rem;
        opacity: 0.9;
        display: flex;
        align-items: center;
        gap: 3px;
    }
</style>

<div class="admin-layout antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-8 transition-all duration-300">
        <div class="max-w-[1600px] mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Kalender Akademik</h1>
                    <p class="text-slate-500 text-sm mt-1">Klik tanggal kosong untuk menambah jadwal baru.</p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="bi bi-funnel text-slate-400"></i>
                        </div>
                        <select id="labFilter"
                            class="bg-white border border-slate-300 text-slate-700 text-sm rounded-xl focus:ring-sky-500 focus:border-sky-500 block w-full pl-10 pr-8 py-2.5 shadow-sm min-w-[250px]">
                            <option value="">Tampilkan Semua Lab</option>
                            <?php foreach ($laboratories as $lab): ?>
                                <option value="<?= $lab['id'] ?>"><?= $lab['lab_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-white p-2 md:p-6 rounded-2xl shadow-sm border border-slate-200">
                <div id='calendar' class="min-h-[850px]"></div>
            </div>

        </div>
    </main>
</div>

<div id="dateActionModal"
    class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity opacity-0 pointer-events-none">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden transform scale-95 transition-all"
        id="modalPanel">
        <div class="bg-gradient-to-r from-slate-50 to-white px-6 py-5 border-b border-slate-100 text-center">
            <h3 class="text-lg font-bold text-slate-800">Kelola Tanggal</h3>
            <div
                class="inline-flex items-center gap-2 px-3 py-1 bg-sky-50 text-sky-700 rounded-full mt-2 border border-sky-100">
                <i class="bi bi-calendar-check"></i>
                <span class="font-mono text-sm font-bold" id="selectedDateText">2026-01-20</span>
            </div>
        </div>

        <div class="p-6 space-y-3">
            <button onclick="redirectToCreate()"
                class="w-full flex items-center p-4 rounded-xl border border-slate-200 hover:border-emerald-500 hover:bg-emerald-50 hover:shadow-md group transition-all duration-200">
                <div
                    class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform shadow-sm">
                    <i class="bi bi-plus-lg text-xl"></i>
                </div>
                <div class="ml-4 text-left">
                    <h4 class="font-bold text-slate-800 group-hover:text-emerald-700">Buat Jadwal Baru</h4>
                    <p class="text-xs text-slate-500">Isi slot kosong di tanggal ini.</p>
                </div>
            </button>

            <button onclick="confirmClearSchedule()"
                class="w-full flex items-center p-4 rounded-xl border border-slate-200 hover:border-rose-500 hover:bg-rose-50 hover:shadow-md group transition-all duration-200">
                <div
                    class="w-12 h-12 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center group-hover:scale-110 transition-transform shadow-sm">
                    <i class="bi bi-trash3 text-xl"></i>
                </div>
                <div class="ml-4 text-left">
                    <h4 class="font-bold text-slate-800 group-hover:text-rose-700">Bersihkan Jadwal</h4>
                    <p class="text-xs text-slate-500">Hapus semua sesi di tanggal ini.</p>
                </div>
            </button>
        </div>

        <div class="bg-slate-50 px-6 py-4 border-t border-slate-100 text-center">
            <button onclick="closeDateModal()"
                class="text-slate-500 hover:text-slate-800 text-sm font-semibold px-6 py-2 rounded-lg hover:bg-slate-200 transition-colors">Batal</button>
        </div>
    </div>
</div>

<script>
    let selectedDateISO = '';
    let currentLabId = '';

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var labFilter = document.getElementById('labFilter');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listWeek' // Tambah opsi View Mingguan & List
            },
            locale: 'id',
            firstDay: 1,
            navLinks: true, // Bisa klik tanggal header untuk pindah ke view harian
            dayMaxEvents: 3, // Maksimal event tampil sebelum "+ more"
            moreLinkContent: function(args) {
                return '+' + args.num + ' Lainnya';
            },

            // API DATA
            events: '<?= url('/admin/calendar/data') ?>',

            // --- RENDERING TAMPILAN EVENT (KARTU) ---
            eventContent: function(arg) {
                // Ambil warna dari controller
                let color = arg.event.backgroundColor || '#3b82f6';

                // Buat warna background transparan (pastel)
                let bgStyle =
                    `background-color: ${color}20; color: ${color}; border-left-color: ${color};`;

                // Format Waktu
                let start = arg.event.start.toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit'
                });
                let end = arg.event.end ? arg.event.end.toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit'
                }) : '';
                let timeRange = start + (end ? ' - ' + end : '');

                // Data Extended Props
                let courseName = arg.event.title;
                let labName = arg.event.extendedProps.lab_name || 'Lab';

                let html = `
                    <div class="event-card" style="${bgStyle}">
                        <span class="event-time">${timeRange}</span>
                        <span class="event-title">${courseName}</span>
                        <span class="event-lab"><i class="bi bi-geo-alt-fill" style="font-size:8px"></i> ${labName}</span>
                    </div>
                `;

                return {
                    html: html
                };
            },

            // --- TOOLTIP SAAT HOVER ---
            eventDidMount: function(info) {
                let content = `
                    <div class="text-left">
                        <div class="font-bold text-white mb-1 border-b border-white/20 pb-1">${info.event.title}</div>
                        <div class="text-xs opacity-90 mb-1"><i class="bi bi-clock"></i> ${info.timeText}</div>
                        <div class="text-xs opacity-90 mb-1"><i class="bi bi-geo-alt"></i> ${info.event.extendedProps.lab_name}</div>
                        <div class="text-xs opacity-90"><i class="bi bi-person"></i> ${info.event.extendedProps.lecturer}</div>
                    </div>
                `;

                tippy(info.el, {
                    content: content,
                    allowHTML: true,
                    theme: 'light-border', // Bisa ganti 'material' jika mau dark
                    animation: 'scale',
                    placement: 'top',
                });
            },

            // --- INTERAKSI KLIK ---
            dateClick: function(info) {
                selectedDateISO = info.dateStr;
                let dateObj = new Date(selectedDateISO);
                let options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                document.getElementById('selectedDateText').innerText = dateObj.toLocaleDateString(
                    'id-ID', options);

                openDateModal();
            },

            eventClick: function(info) {
                let planId = info.event.extendedProps.plan_id;

                if (planId) {
                    window.location.href = '<?= url('/admin/schedules/') ?>' + planId + '/sessions';
                } else {
                    alert('ID Jadwal Induk tidak ditemukan.');
                }
            }
        });

        calendar.render();

        // --- FILTER LAB LOGIC ---
        labFilter.addEventListener('change', function() {
            currentLabId = this.value;
            var newSource = {
                url: '<?= url('/admin/calendar/data') ?>',
                extraParams: {
                    lab_id: currentLabId
                }
            };

            var oldSource = calendar.getEventSources()[0];
            if (oldSource) oldSource.remove();
            calendar.addEventSource(newSource);
        });
    });

    // --- MODAL ANIMATION LOGIC ---
    const modal = document.getElementById('dateActionModal');
    const panel = document.getElementById('modalPanel');

    function openDateModal() {
        modal.classList.remove('hidden');
        // Trigger reflow
        void modal.offsetWidth;
        modal.classList.remove('opacity-0', 'pointer-events-none');
        panel.classList.remove('scale-95');
        panel.classList.add('scale-100');
    }

    function closeDateModal() {
        modal.classList.add('opacity-0', 'pointer-events-none');
        panel.classList.remove('scale-100');
        panel.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200); // Wait for transition
    }

    function redirectToCreate() {
        let url = '<?= url('/admin/schedules/create') ?>?date=' + selectedDateISO;
        window.location.href = url;
    }

    function confirmClearSchedule() {
        if (confirm('PERINGATAN: Anda akan menghapus SEMUA jadwal pada tanggal ini. Lanjutkan?')) {
            fetch('<?= url('/admin/calendar/clear') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        date: selectedDateISO,
                        lab_id: currentLabId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Gunakan notifikasi bawaan browser atau toast jika ada
                        alert('Jadwal berhasil dibersihkan.');
                        location.reload();
                    } else {
                        alert('Gagal: ' + data.message);
                    }
                });
        }
    }

    modal.addEventListener('click', function(e) {
        if (e.target === this) closeDateModal();
    });
</script>
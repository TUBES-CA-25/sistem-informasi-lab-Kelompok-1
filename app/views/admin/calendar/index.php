<?php $title = 'Kalender Akademik';
$adminLayout = true; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>

<style>
/* Custom Style untuk Event Text */
.fc-event-content {
    white-space: normal;
    font-size: 0.75rem;
    line-height: 1.2;
}

.fc-daygrid-event {
    background: transparent !important;
    border: none !important;
    margin-top: 2px;
}

.custom-event-box {
    background-color: #eff6ff;
    /* blue-50 */
    border-left: 3px solid #3b82f6;
    color: #1e3a8a;
    padding: 2px 4px;
    border-radius: 4px;
    font-family: monospace;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.custom-event-box:hover {
    background-color: #dbeafe;
    transform: scale(1.02);
}
</style>

<div class="admin-layout antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-8 transition-all duration-300">
        <div class="max-w-7xl mx-auto">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Kalender Akademik</h1>
                    <p class="text-slate-500 text-sm mt-1">Klik tanggal untuk opsi: Tambah, Edit, atau Bersihkan Jadwal.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <select id="labFilter"
                        class="bg-white border border-slate-300 text-slate-700 text-sm rounded-xl focus:ring-sky-500 focus:border-sky-500 block w-full pl-3 pr-8 py-2.5 shadow-sm">
                        <option value="">Semua Laboratorium</option>
                        <?php foreach ($laboratories as $lab): ?>
                        <option value="<?= $lab['id'] ?>"><?= $lab['lab_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <div id='calendar' class="min-h-[800px]"></div>
            </div>

        </div>
    </main>
</div>

<div id="dateActionModal"
    class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden transform scale-100 transition-all">
        <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 text-center">
            <h3 class="text-lg font-bold text-slate-800">Kelola Tanggal</h3>
            <p class="text-sky-600 font-mono text-sm font-bold mt-1" id="selectedDateText">2026-01-20</p>
        </div>

        <div class="p-6 space-y-3">
            <button onclick="redirectToCreate()"
                class="w-full flex items-center p-4 rounded-xl border border-slate-200 hover:border-emerald-500 hover:bg-emerald-50 group transition-all">
                <div
                    class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="bi bi-plus-lg text-xl"></i>
                </div>
                <div class="ml-4 text-left">
                    <h4 class="font-bold text-slate-800">Buat Jadwal Baru</h4>
                    <p class="text-xs text-slate-500">Isi slot kosong di tanggal ini.</p>
                </div>
            </button>

            <button onclick="confirmClearSchedule()"
                class="w-full flex items-center p-4 rounded-xl border border-slate-200 hover:border-rose-500 hover:bg-rose-50 group transition-all">
                <div
                    class="w-10 h-10 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="bi bi-trash text-xl"></i>
                </div>
                <div class="ml-4 text-left">
                    <h4 class="font-bold text-slate-800">Bersihkan Jadwal</h4>
                    <p class="text-xs text-slate-500">Hapus semua sesi di tanggal ini.</p>
                </div>
            </button>
        </div>

        <div class="bg-slate-50 px-6 py-3 border-t border-slate-100 text-center">
            <button onclick="closeDateModal()"
                class="text-slate-500 hover:text-slate-800 text-sm font-medium">Batal</button>
        </div>
    </div>
</div>

<script>
let selectedDateISO = ''; // Simpan tanggal terpilih (YYYY-MM-DD)
let currentLabId = ''; // Simpan filter lab saat ini

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var labFilter = document.getElementById('labFilter');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth', // Ganti ke Tampilan Bulanan agar terlihat list-nya
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek'
        },
        locale: 'id',
        firstDay: 1,
        contentHeight: 'auto',
        dayMaxEvents: 4, // Maksimal 4 baris sebelum muncul "+ more"

        // Sumber Data
        events: '<?= url('/admin/calendar/data') ?>',

        // CUSTOM RENDERING: Ubah tampilan jadi text [Matkul Jam]
        eventContent: function(arg) {
            // arg.event punya extendedProps yg dikirim dari Controller
            let timeStr = arg.timeText || ''; // FullCalendar auto format time range

            // Format Waktu Manual (Contoh: 07.30 - 10.30)
            let start = arg.event.start.toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            }).replace(':', '.');
            let end = arg.event.end ? arg.event.end.toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            }).replace(':', '.') : '';
            let timeRange = start + (end ? ' - ' + end : '');

            let courseName = arg.event.title;

            // Format HTML sesuai request: [Matkul Jam-Jam]
            let html = `<div class="custom-event-box">
                                [${courseName}] <span class="opacity-75">[${timeRange}]</span>
                            </div>`;

            return {
                html: html
            };
        },

        // KLIK TANGGAL (Buka Modal Pilihan)
        dateClick: function(info) {
            selectedDateISO = info.dateStr; // Simpan YYYY-MM-DD

            // Tampilkan Modal
            document.getElementById('selectedDateText').innerText = new Date(selectedDateISO)
                .toLocaleDateString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            document.getElementById('dateActionModal').classList.remove('hidden');
        },

        // KLIK EVENT (Edit Spesifik - Redirect ke Edit Page)
        eventClick: function(info) {
            // Langsung redirect ke halaman edit jadwal tersebut
            window.location.href = '<?= url('/admin/schedules/') ?>' + info.event.id + '/edit';
        }
    });

    calendar.render();

    // Logic Filter Lab
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

// --- FUNGSI MODAL ---

function closeDateModal() {
    document.getElementById('dateActionModal').classList.add('hidden');
}

// 1. Redirect ke Create dengan Parameter Tanggal
function redirectToCreate() {
    let url = '<?= url('/admin/schedules/create') ?>?date=' + selectedDateISO;
    if (currentLabId) {
        // Jika sedang filter lab, otomatis pilih lab itu juga (optional logic di create)
        // url += '&lab_id=' + currentLabId; 
    }
    window.location.href = url;
}

// 2. Hapus Semua Jadwal di Tanggal Itu
function confirmClearSchedule() {
    if (confirm('Yakin ingin MENGHAPUS SEMUA jadwal pada tanggal ' + selectedDateISO +
            '? Data tidak bisa dikembalikan.')) {
        // Kirim Request AJAX ke Backend
        fetch('<?= url('/admin/calendar/clear') ?>', { // Kita butuh route ini
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    date: selectedDateISO,
                    lab_id: currentLabId // Kirim filter lab jika ada
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Jadwal berhasil dibersihkan.');
                    location.reload(); // Reload halaman untuk refresh kalender
                } else {
                    alert('Gagal: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan sistem.');
            });
    }
}

// Tutup modal jika klik luar
document.getElementById('dateActionModal').addEventListener('click', function(e) {
    if (e.target === this) closeDateModal();
});
</script>
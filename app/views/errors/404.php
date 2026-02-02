<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $code ?> - <?= $title ?> | ICLABS</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/assets/images/logo-iclabs.png">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl w-full">
        <!-- Error Card -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header with gradient -->
            <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-8 py-6">
                <div class="flex items-center justify-center gap-4">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center">
                        <i class="bi bi-exclamation-triangle text-4xl text-white"></i>
                    </div>
                    <div class="text-white">
                        <h1 class="text-6xl font-bold"><?= $code ?></h1>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="px-8 py-12 text-center">
                <h2 class="text-3xl font-bold text-slate-800 mb-4"><?= htmlspecialchars($title) ?></h2>
                <p class="text-slate-600 text-lg mb-8 leading-relaxed">
                    <?= htmlspecialchars($message) ?>
                </p>

                <!-- Error Code Badge -->
                <div class="inline-block mb-8">
                    <div class="px-4 py-2 bg-slate-100 rounded-full text-slate-600 text-sm font-medium">
                        <i class="bi bi-info-circle mr-2"></i>
                        Error Code: <?= $code ?>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="<?= url('/') ?>" 
                       class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-all shadow-lg shadow-primary-500/30">
                        <i class="bi bi-house-door"></i>
                        <span>Kembali ke Beranda</span>
                    </a>
                    
                    <button onclick="window.history.back()" 
                            class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium rounded-lg transition-all">
                        <i class="bi bi-arrow-left"></i>
                        <span>Halaman Sebelumnya</span>
                    </button>
                </div>
            </div>

            <!-- Footer -->
            <div class="border-t border-slate-100 px-8 py-4 bg-slate-50">
                <p class="text-center text-sm text-slate-500">
                    <i class="bi bi-shield-check mr-1"></i>
                    ICLABS - Laboratory Information System
                </p>
            </div>
        </div>

        <!-- Help Text -->
        <div class="mt-6 text-center">
            <p class="text-slate-600 text-sm">
                Jika masalah berlanjut, silakan hubungi administrator sistem.
            </p>
        </div>
    </div>
</body>
</html>

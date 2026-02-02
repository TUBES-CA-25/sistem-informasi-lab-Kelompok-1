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
<body class="bg-gradient-to-br from-amber-50 to-orange-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl w-full">
        <!-- Error Card -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-amber-500 to-orange-500 px-8 py-6">
                <div class="flex items-center justify-center gap-4">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center">
                        <i class="bi bi-shield-lock text-4xl text-white"></i>
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

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="<?= url('/login') ?>" 
                       class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-lg transition-all shadow-lg shadow-amber-500/30">
                        <i class="bi bi-box-arrow-in-right"></i>
                        <span>Login</span>
                    </a>
                    
                    <a href="<?= url('/') ?>" 
                       class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium rounded-lg transition-all">
                        <i class="bi bi-house-door"></i>
                        <span>Kembali ke Beranda</span>
                    </a>
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
    </div>
</body>
</html>

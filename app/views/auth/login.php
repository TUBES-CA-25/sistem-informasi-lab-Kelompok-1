<?php $title = 'Login - ICLABS'; ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/assets/images/logo-iclabs.png">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
    body {
        font-family: 'Inter', sans-serif;
    }

    .fade-enter {
        opacity: 0;
    }

    .fade-enter-active {
        opacity: 1;
        transition: opacity 1s ease-in-out;
    }

    .fade-exit {
        opacity: 1;
    }

    .fade-exit-active {
        opacity: 0;
        transition: opacity 1s ease-in-out;
    }

    /* Animasi Ken Burns (Zoom in perlahan) */
    @keyframes kenburns {
        0% {
            transform: scale(1);
        }

        100% {
            transform: scale(1.1);
        }
    }

    .animate-kenburns {
        animation: kenburns 10s ease-out forwards;
    }
    </style>
</head>

<body class="bg-white">

    <div class="flex min-h-screen">

        <div class="hidden lg:flex lg:w-1/2 relative bg-slate-900 overflow-hidden">

            <div id="slideshow-container" class="absolute inset-0 w-full h-full">
                <?php 
                // Jika ada data gambar dari controller
                if (!empty($labImages)): 
                    $first = true;
                    foreach($labImages as $lab): 
                        // Fix path gambar
                        $imgSrc = (strpos($lab['image'], 'http') === 0) ? $lab['image'] : BASE_URL . '/' . $lab['image'];
                ?>
                <div
                    class="slide-item absolute inset-0 w-full h-full transition-opacity duration-1000 ease-in-out <?= $first ? 'opacity-100' : 'opacity-0' ?>">
                    <img src="<?= $imgSrc ?>" class="absolute inset-0 w-full h-full object-cover animate-kenburns"
                        alt="Lab Image">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/40 to-slate-900/30">
                    </div>

                    <div class="absolute bottom-0 left-0 p-12 w-full">
                        <span
                            class="inline-block py-1 px-3 rounded-full bg-blue-600/30 border border-blue-500/50 text-blue-200 text-xs font-bold uppercase tracking-wider mb-3 backdrop-blur-sm">
                            Fasilitas Laboratorium
                        </span>
                        <h2 class="text-4xl font-extrabold text-white mb-2 leading-tight">
                            <?= $lab['lab_name'] ?>
                        </h2>
                        <p class="text-slate-300 text-lg line-clamp-2 max-w-lg">
                            <?= $lab['description'] ?>
                        </p>
                    </div>
                </div>
                <?php 
                    $first = false; 
                    endforeach; 
                else: 
                    // Fallback jika tidak ada gambar
                ?>
                <div class="absolute inset-0 w-full h-full">
                    <img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?q=80&w=2070&auto=format&fit=crop"
                        class="absolute inset-0 w-full h-full object-cover animate-kenburns">
                    <div class="absolute inset-0 bg-slate-900/60"></div>
                    <div class="absolute bottom-0 left-0 p-12">
                        <h2 class="text-4xl font-extrabold text-white mb-2">Laboratorium Terpadu</h2>
                        <p class="text-slate-300">Fasilitas komputasi modern untuk mahasiswa.</p>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <div class="absolute top-8 left-8 z-10">
                <a href="<?= url('/') ?>"
                    class="flex items-center gap-3 text-white hover:opacity-80 transition-opacity">
                    <div
                        class="w-10 h-10 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center">
                        <i class="bi bi-arrow-left text-xl"></i>
                    </div>
                    <span class="font-medium">Kembali ke Beranda</span>
                </a>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-8 md:p-12 lg:p-16 bg-white relative">

            <a href="<?= url('/') ?>"
                class="absolute top-6 left-6 lg:hidden w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-500 hover:bg-slate-100 transition-colors">
                <i class="bi bi-arrow-left text-lg"></i>
            </a>

            <div class="w-full max-w-md space-y-8">

                <div class="text-center">
                    <img src="<?= BASE_URL ?>/assets/images/logo-iclabs.png" alt="ICLABS" class="h-16 mx-auto mb-6"
                        onerror="this.src='https://cdn-icons-png.flaticon.com/512/2083/2083213.png'">
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Selamat Datang</h1>
                    <p class="text-slate-500 mt-2">Silakan login untuk mengakses portal laboratorium.</p>
                </div>

                <?php if(isset($_SESSION['flash'])): ?>
                <div class="p-4 mb-4 text-sm rounded-xl flex items-center gap-3 <?= $_SESSION['flash']['type'] == 'success' ? 'text-green-800 bg-green-50 border border-green-200' : 'text-rose-800 bg-rose-50 border border-rose-200' ?>"
                    role="alert">
                    <i
                        class="bi <?= $_SESSION['flash']['type'] == 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill' ?>"></i>
                    <div><?= $_SESSION['flash']['message'] ?></div>
                </div>
                <?php unset($_SESSION['flash']); ?>
                <?php endif; ?>

                <form class="mt-8 space-y-6" action="<?= url('/auth/login') ?>" method="POST">

                    <div class="space-y-5">
                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email
                                Akademik</label>
                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                    <i class="bi bi-envelope"></i>
                                </div>
                                <input id="email" name="email" type="email" autocomplete="email" required
                                    class="appearance-none relative block w-full pl-3 pr-1 py-3 border border-slate-300 placeholder-slate-400 text-slate-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all"
                                    placeholder="nama@umi.ac.id">
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                            </div>
                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                    <i class="bi bi-lock"></i>
                                </div>
                                <input id="password" name="password" type="password" autocomplete="current-password"
                                    required
                                    class="appearance-none relative block w-full pl-3 pr-1 py-3 border border-slate-300 placeholder-slate-400 text-slate-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all"
                                    placeholder="••••••••">
                                <button type="button" onclick="togglePassword()"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 cursor-pointer">
                                    <i class="bi bi-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="group w-full flex justify-center items-center gap-2 py-3.5 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50">
                            <i
                                class="bi bi-box-arrow-in-right text-blue-200 group-hover:text-white transition-colors text-lg"></i>
                            <span>Masuk ke Portal</span>
                        </button>
                    </div>

                </form>

                <div class="mt-6 text-center">
                    <p class="text-xs text-slate-400">
                        &copy; <?= date('Y') ?> Fakultas Ilmu Komputer UMI.<br>All rights reserved.
                    </p>
                </div>

            </div>
        </div>
    </div>

    <script>
    // 1. Password Toggle
    function togglePassword() {
        const input = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');
        if (input.type === "password") {
            input.type = "text";
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = "password";
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }

    // 2. Simple Slideshow Script (Vanilla JS)
    document.addEventListener('DOMContentLoaded', function() {
        const slides = document.querySelectorAll('.slide-item');
        if (slides.length > 1) {
            let currentSlide = 0;

            setInterval(() => {
                // Hide current
                slides[currentSlide].classList.remove('opacity-100');
                slides[currentSlide].classList.add('opacity-0');

                // Calculate next
                currentSlide = (currentSlide + 1) % slides.length;

                // Show next
                slides[currentSlide].classList.remove('opacity-0');
                slides[currentSlide].classList.add('opacity-100');
            }, 5000); // Ganti setiap 5 detik
        }
    });
    </script>
</body>

</html>
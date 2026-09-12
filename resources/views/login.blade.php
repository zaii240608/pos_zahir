<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Toko Kelontong Zahir</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- GSAP Animation CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            dark: '#0f3832',
                            card: '#13433c',
                            accent: '#f59e0b',
                            accentHover: '#d97706',
                            bgDark: '#081e1b',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans min-h-screen flex flex-col items-center justify-center p-4 overflow-x-hidden overflow-y-auto relative selection:bg-brand-accent selection:text-brand-dark">

    <!-- Ambient Glowing Background Orbs -->
    <div class="fixed top-0 -left-20 w-72 h-72 border-[32px] border-teal-100 rounded-full pointer-events-none"></div>
    <div class="fixed bottom-0 -right-20 w-80 h-80 border-[40px] border-amber-100 rounded-full pointer-events-none"></div>

    <!-- Canvas Render Animasi 3D Three.js -->
    <canvas id="bg-3d" class="hidden"></canvas>

    <!-- Pop-up Notifikasi Error -->
    <div id="alert-popup" class="fixed top-6 z-50 transform -translate-y-20 opacity-0 transition-all duration-300 pointer-events-none w-full max-w-md px-4">
        <div class="bg-rose-950/90 border border-rose-800/80 backdrop-blur-xl p-4 rounded-2xl shadow-2xl shadow-rose-950/50 flex items-start space-x-3">
            <div class="text-rose-400 mt-0.5">
                <i data-lucide="alert-triangle" class="w-5 h-5 animate-bounce"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-xs font-extrabold text-rose-200 uppercase tracking-wider">Akses Gagal</h3>
                <p id="alert-message" class="text-xs font-medium text-rose-300 mt-0.5">Email belum terdaftar atau password salah.</p>
            </div>
            <button onclick="closeAlert()" class="text-rose-400 hover:text-rose-200 transition-colors pointer-events-auto">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
    </div>

    <!-- Wrapper Card Utama dengan Animasi GSAP -->
    <div class="gsap-card w-full max-w-md flex flex-col items-center z-10 space-y-6">
        
        <div class="w-full bg-white rounded-2xl shadow-xl shadow-slate-200/70 border border-slate-200/80 overflow-hidden relative transition-all duration-300 hover:shadow-2xl">
            
            <!-- Shimmer Border Line -->
            <div class="h-1.5 w-full bg-teal-400"></div>

            <!-- Header Card -->
            <div class="p-8 pb-3 text-center flex flex-col items-center">
                <!-- Logo Box -->
                <div class="gsap-logo w-14 h-14 rounded-2xl bg-brand-accent text-brand-dark flex items-center justify-center shadow-lg shadow-amber-500/20 mb-4 transform transition-transform duration-500 hover:rotate-12">
                    <i data-lucide="shopping-cart" class="w-7 h-7"></i>
                </div>

                <h2 class="text-2xl font-black text-slate-900 tracking-tight">
                    Selamat <span class="text-teal-600">Datang</span>
                </h2>
                <p class="text-xs font-medium text-slate-500 mt-1.5">
                    Masukkan kredensial akun Anda untuk mengakses Toko Kelontong Zahir.
                </p>
            </div>

            <!-- Form Section -->
            <div class="px-8 pb-8 pt-2">
                <form id="login-form" action="{{ route('auth') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Email Field -->
                    <div class="gsap-field space-y-1.5">
                        <label for="email" class="block text-xs font-bold text-slate-700">Alamat Email</label>
                        <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 transition-colors group-focus-within:text-teal-600">
                                <i data-lucide="mail" class="w-4 h-4"></i>
                            </div>
                            <input id="email" name="email" type="email" required 
                                class="block w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-teal-600 focus:ring-4 focus:ring-teal-600/10 text-xs font-medium transition-all duration-300"
                                placeholder="nama@email.com" value="{{ old('email') }}">
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="gsap-field space-y-1.5">
                        <div class="flex justify-between items-center">
                            <label for="password" class="block text-xs font-bold text-slate-700">Kata Sandi</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-[11px] font-semibold text-teal-700 hover:text-amber-600 transition-colors">Lupa Password?</a>
                            @endif
                        </div>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 transition-colors group-focus-within:text-teal-600">
                                <i data-lucide="lock" class="w-4 h-4"></i>
                            </div>
                            <input id="password" name="password" type="password" required 
                                class="block w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-teal-600 focus:ring-4 focus:ring-teal-600/10 text-xs font-medium transition-all duration-300"
                                placeholder="••••••••">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="gsap-submit pt-3">
                        <button type="submit" id="submit-btn"
                            class="w-full py-3.5 px-4 bg-brand-dark hover:bg-brand-card text-white font-extrabold rounded-xl shadow-lg shadow-teal-900/20 hover:shadow-xl transition duration-200 active:scale-95 text-xs tracking-wider flex items-center justify-center space-x-2">
                            <span id="btn-text">Masuk Sekarang</span>
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Footer Copyright -->
            <p class="text-[11px] font-semibold text-slate-400 tracking-wider hover:text-slate-600 transition-colors">
            &copy; {{ date('Y') }} TOKO KELONTONG ZAHIR. All rights reserved.
        </p>
    </div>

    <!-- Script Importmap Three.js -->
    <script type="importmap">
        {
            "imports": {
                "three": "https://unpkg.com/three@0.160.0/build/three.module.js"
            }
        }
    </script>

    <script type="module">
        import * as THREE from 'three';

        // Init Lucide Icons
        lucide.createIcons();

        // Three.js 3D Background Setup
        const canvas = document.getElementById('bg-3d');
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 0.1, 1000);
        camera.position.z = 6.5;

        const renderer = new THREE.WebGLRenderer({ canvas: canvas, alpha: true, antialias: true });
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });

        // 3D Geometries
        const geometryTorus = new THREE.TorusKnotGeometry(0.5, 0.15, 100, 16);
        const materialAmber = new THREE.MeshStandardMaterial({ color: 0xf59e0b, roughness: 0.2, metalness: 0.5 });
        const torusNode = new THREE.Mesh(geometryTorus, materialAmber);
        torusNode.position.set(-3.2, -1.2, -1);

        const sphereTeal = new THREE.Mesh(
            new THREE.SphereGeometry(0.5, 32, 32),
            new THREE.MeshStandardMaterial({ color: 0x10b981, roughness: 0.3 })
        );
        sphereTeal.position.set(3.4, 1.4, -1.5);

        scene.add(torusNode, sphereTeal);

        // Lighting
        scene.add(new THREE.AmbientLight(0xffffff, 1.0));
        const dirLight = new THREE.DirectionalLight(0xffffff, 1.8);
        dirLight.position.set(5, 8, 5);
        scene.add(dirLight);

        // Alert popup handling
        let alertTimeout = null;
        const loginForm = document.getElementById('login-form');
        const submitBtn = document.getElementById('submit-btn');
        const btnText = document.getElementById('btn-text');

        window.showAlert = function(msg) {
            const popup = document.getElementById('alert-popup');
            if(msg) document.getElementById('alert-message').innerText = msg;
            popup.classList.remove('-translate-y-20', 'opacity-0', 'pointer-events-none');
            popup.classList.add('translate-y-0', 'opacity-100');

            if (alertTimeout) clearTimeout(alertTimeout);
                alertTimeout = setTimeout(() => { closeAlert(); }, 3000);
        }

        window.closeAlert = function() {
            const popup = document.getElementById('alert-popup');
            popup.classList.add('-translate-y-20', 'opacity-0', 'pointer-events-none');
            popup.classList.remove('translate-y-0', 'opacity-100');
            if (alertTimeout) clearTimeout(alertTimeout);
        }

        @if ($errors->any())
            window.addEventListener('DOMContentLoaded', () => {
                showAlert("Email atau kata sandi yang Anda masukkan salah.");
            });
        @endif

        loginForm.addEventListener('submit', function() {
            btnText.innerText = "Memeriksa Akun...";
            submitBtn.disabled = true;
        });

        // Loop Animation Three.js
        function animate() {
            requestAnimationFrame(animate);
            const time = Date.now() * 0.001;

            torusNode.rotation.x = time * 0.5;
            torusNode.rotation.y = time * 0.3;
            torusNode.position.y = -1.2 + Math.sin(time * 1.5) * 0.2;

            sphereTeal.position.y = 1.4 + Math.cos(time * 1.2) * 0.25;

            renderer.render(scene, camera);
        }
        animate();

        // GSAP Animations
        document.addEventListener("DOMContentLoaded", () => {
            const timeline = gsap.timeline({ defaults: { ease: "power3.out" } });

            timeline.from(".gsap-card", {
                y: 40,
                opacity: 0,
                duration: 0.9
            })
            .from(".gsap-field", {
                y: 16,
                opacity: 0,
                duration: 0.45,
                stagger: 0.12
            }, "-=0.35")
            .from(".gsap-submit", {
                y: 12,
                opacity: 0,
                duration: 0.4
            }, "-=0.2");

            gsap.from(".gsap-logo", {
                scale: 0,
                rotation: -45,
                duration: 0.7,
                delay: 0.2,
                ease: "back.out(1.7)"
            });
        });
    </script>
</body>
</html>
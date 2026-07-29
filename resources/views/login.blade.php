<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ config('app.name', 'Laravel POS') }}</title>
    
    <!-- Panggil Tailwind CSS via CDN dengan benar -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-900 min-h-screen font-sans antialiased flex flex-col items-center justify-center p-4 overflow-hidden relative selection:bg-teal-500 selection:text-white">

    <!-- Glowing Background Orbs dengan Animasi Napas (Pulse) -->
    <div class="fixed top-1/4 -left-20 w-96 h-96 bg-teal-500/20 rounded-full blur-3xl pointer-events-none animate-pulse duration-1000"></div>
    <div class="fixed bottom-1/4 -right-20 w-96 h-96 bg-amber-500/15 rounded-full blur-3xl pointer-events-none animate-pulse duration-700"></div>

    <!-- Canvas Render Animasi 3D -->
    <canvas id="bg-3d" class="fixed top-0 left-0 w-full h-full pointer-events-none z-0"></canvas>

    <!-- Pop-up Notifikasi Error -->
    <div id="alert-popup" class="fixed top-6 z-50 transform -translate-y-20 opacity-0 transition-all duration-300 pointer-events-none w-full max-w-md px-4">
        <div class="bg-rose-950/90 border border-rose-800/80 backdrop-blur-xl p-4 rounded-2xl shadow-2xl shadow-rose-950/50 flex items-start space-x-3">
            <div class="text-rose-400 mt-0.5 animate-bounce">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-xs font-extrabold text-rose-200 uppercase tracking-wider">Akses Gagal</h3>
                <p id="alert-message" class="text-xs font-medium text-rose-300 mt-0.5">Email belum terdaftar atau password salah.</p>
            </div>
            <button onclick="closeAlert()" class="text-rose-400 hover:text-rose-200 transition-colors pointer-events-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Wrapper Card Utama dengan Efek Transisi Masuk -->
    <div class="w-full max-w-md flex flex-col items-center z-10 space-y-6 transition-all duration-700 transform translate-y-0 opacity-100">
        
        <div class="w-full bg-stone-800/80 backdrop-blur-2xl rounded-3xl shadow-2xl shadow-stone-950/80 border border-stone-700/60 overflow-hidden relative transition-transform duration-300 hover:border-teal-500/40">
            
            <!-- Glow Border Accent Top dengan Animasi Shimmer -->
            <div class="h-1 w-full bg-gradient-to-r from-teal-500 via-emerald-300 to-teal-600 animate-pulse"></div>

            <!-- Header Card -->
            <div class="p-8 pb-2 text-center flex flex-col items-center">
                <!-- App Logo dengan Efek Hover Berputar Lembut -->
                <div class="w-12 h-12 rounded-2xl bg-teal-500/10 border border-teal-500/30 flex items-center justify-center text-teal-400 shadow-lg shadow-teal-500/10 mb-4 transition-transform duration-500 hover:rotate-12">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>

                <h2 class="text-2xl font-black text-white tracking-tight">
                    Selamat <span class="text-teal-400">Datang</span>
                </h2>
                <p class="text-xs font-medium text-stone-400 mt-1.5">
                    Masukkan kredensial akun Anda untuk mengakses APP POS.
                </p>
            </div>

            <!-- Form Section -->
            <div class="px-8 pb-8 pt-4">
                <form id="login-form" action="{{ route('auth') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Email Field -->
                    <div class="space-y-1.5">
                        <label for="email" class="block text-xs font-bold text-stone-300">Alamat Email</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-stone-500 transition-colors group-focus-within:text-teal-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                </svg>
                            </div>
                            <input id="email" name="email" type="email" required 
                                class="block w-full pl-10 pr-4 py-2.5 bg-stone-900/70 border border-stone-700/80 rounded-2xl text-stone-100 placeholder-stone-500 focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 text-xs font-medium transition-all duration-300"
                                placeholder="nama@email.com" value="{{ old('email') }}">
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-1.5">
                        <div class="flex justify-between items-center">
                            <label for="password" class="block text-xs font-bold text-stone-300">Kata Sandi</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-[11px] font-semibold text-teal-400 hover:text-teal-300 transition-colors">Lupa Password?</a>
                            @endif
                        </div>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-stone-500 transition-colors group-focus-within:text-teal-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <input id="password" name="password" type="password" required 
                                class="block w-full pl-10 pr-4 py-2.5 bg-stone-900/70 border border-stone-700/80 rounded-2xl text-stone-100 placeholder-stone-500 focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 text-xs font-medium transition-all duration-300"
                                placeholder="••••••••">
                        </div>
                    </div>

                    <div class="pt-3">
                        <button type="submit" id="submit-btn"
                            class="w-full py-3 px-4 bg-teal-500 hover:bg-teal-600 text-stone-950 font-extrabold rounded-2xl shadow-lg shadow-teal-500/20 hover:shadow-teal-500/30 transition duration-200 active:scale-95 text-xs tracking-wide flex items-center justify-center space-x-2">
                            <span id="btn-text">Masuk Sekarang</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Footer Copyright -->
        <p class="text-[11px] font-medium text-stone-500 tracking-wide hover:text-stone-400 transition-colors">
            &copy; {{ date('Y') }} zLDevv. All rights reserved.
        </p>
    </div>

    <!-- Script Three.js Menggunakan CDN ES Module -->
    <script type="importmap">
        {
            "imports": {
                "three": "https://unpkg.com/three@0.160.0/build/three.module.js"
            }
        }
    </script>

    <script type="module">
        import * as THREE from 'three';

        const canvas = document.getElementById('bg-3d');
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 0.1, 1000);
        camera.position.z = 6.5;

        const renderer = new THREE.WebGLRenderer({ canvas: canvas, alpha: true, antialias: true });
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

        const whiteMaterial = new THREE.MeshStandardMaterial({ color: 0x14b8a6, roughness: 0.2, metalness: 0.1 }); 
        const darkAccentMat = new THREE.MeshStandardMaterial({ color: 0x44403c, roughness: 0.4 }); 
        const errorMaterial = new THREE.MeshStandardMaterial({ color: 0xf43f5e, roughness: 0.2 }); 

        const lockGroup = new THREE.Group();
        const shape = new THREE.Shape();
        const width = 1.1, height = 0.9, radius = 0.25;

        shape.moveTo(-width/2 + radius, -height/2);
        shape.lineTo(width/2 - radius, -height/2);
        shape.quadraticCurveTo(width/2, -height/2, width/2, -height/2 + radius);
        shape.lineTo(width/2, height/2 - radius);
        shape.quadraticCurveTo(width/2, height/2, width/2 - radius, height/2);
        shape.lineTo(-width/2 + radius, height/2);
        shape.quadraticCurveTo(-width/2, height/2, -width/2, height/2 - radius);
        shape.lineTo(-width/2, -height/2 + radius);
        shape.quadraticCurveTo(-width/2, -height/2, -width/2 + radius, -height/2);

        const bodyGeo = new THREE.ExtrudeGeometry(shape, { steps: 2, depth: 0.35, bevelEnabled: true, bevelThickness: 0.1, bevelSize: 0.1 });
        bodyGeo.center();
        const lockBody = new THREE.Mesh(bodyGeo, whiteMaterial);
        lockBody.position.set(0, -0.3, 0);
        lockGroup.add(lockBody);

        const shackleGroup = new THREE.Group();
        shackleGroup.position.set(-0.38, 0, 0);
        const lockShackle = new THREE.Mesh(new THREE.TorusGeometry(0.38, 0.09, 32, 64, Math.PI), whiteMaterial);
        lockShackle.position.set(0.38, 0.15, 0);
        shackleGroup.add(lockShackle);
        
        const legGeo = new THREE.CylinderGeometry(0.09, 0.09, 0.3, 32);
        const legLeft = new THREE.Mesh(legGeo, whiteMaterial);
        legLeft.position.set(0, 0.02, 0);
        const legRight = new THREE.Mesh(legGeo, whiteMaterial);
        legRight.position.set(0.76, 0.02, 0);
        shackleGroup.add(legLeft, legRight);
        lockGroup.add(shackleGroup);

        const keyholeCircle = new THREE.Mesh(new THREE.SphereGeometry(0.07, 32, 32), darkAccentMat);
        keyholeCircle.position.set(0, -0.22, 0.28);
        const keyholeSlot = new THREE.Mesh(new THREE.CylinderGeometry(0.025, 0.05, 0.1, 32), darkAccentMat);
        keyholeSlot.position.set(0, -0.28, 0.28);
        lockGroup.add(keyholeCircle, keyholeSlot);

        lockGroup.position.set(0, 2.7, 0);
        scene.add(lockGroup);

        const sphereTeal = new THREE.Mesh(new THREE.SphereGeometry(0.45, 32, 32), new THREE.MeshStandardMaterial({ color: 0x14b8a6, roughness: 0.3 }));
        sphereTeal.position.set(-3.6, -1, -2);
        const sphereAmber = new THREE.Mesh(new THREE.SphereGeometry(0.35, 32, 32), new THREE.MeshStandardMaterial({ color: 0xf59e0b, roughness: 0.3 }));
        sphereAmber.position.set(3.6, 1.5, -2);
        scene.add(sphereTeal, sphereAmber);

        scene.add(new THREE.AmbientLight(0xffffff, 1.2));
        const mainLight = new THREE.DirectionalLight(0xffffff, 1.5);
        mainLight.position.set(5, 8, 5);
        scene.add(mainLight);

        let mouseX = 0, mouseY = 0;
        window.addEventListener('mousemove', (e) => {
            mouseX = (e.clientX / window.innerWidth - 0.5) * 2;
            mouseY = (e.clientY / window.innerHeight - 0.5) * 2;
        });

        let isErrorShaking = false, shakeTime = 0;
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
            alertTimeout = setTimeout(() => {
                closeAlert();
            }, 3000);
        }

        window.closeAlert = function() {
            const popup = document.getElementById('alert-popup');
            popup.classList.add('-translate-y-20', 'opacity-0', 'pointer-events-none');
            popup.classList.remove('translate-y-0', 'opacity-100');
            if (alertTimeout) clearTimeout(alertTimeout);
        }

        @if ($errors->any())
            window.addEventListener('DOMContentLoaded', () => {
                lockBody.material = errorMaterial;
                lockShackle.material = errorMaterial;
                legLeft.material = errorMaterial;
                legRight.material = errorMaterial;
                isErrorShaking = true;
                
                showAlert("Email atau kata sandi yang Anda masukkan salah.");
                
                setTimeout(() => {
                    isErrorShaking = false;
                    lockBody.material = whiteMaterial;
                    lockShackle.material = whiteMaterial;
                    legLeft.material = whiteMaterial;
                    legRight.material = whiteMaterial;
                }, 1800);
            });
        @endif

        loginForm.addEventListener('submit', function(e) {
            btnText.innerText = "Memeriksa Akun...";
            submitBtn.disabled = true;
        });

        function animate() {
            requestAnimationFrame(animate);
            const time = Date.now() * 0.001;

            sphereTeal.position.y = -1 + Math.sin(time * 1.5) * 0.2;
            sphereAmber.position.y = 1.5 + Math.cos(time * 1.2) * 0.2;

            if (isErrorShaking) {
                shakeTime += 0.4;
                lockGroup.rotation.y = (mouseX * 0.75) + Math.sin(shakeTime * 35) * 0.15;
            } else {
                lockGroup.rotation.y += (mouseX * 0.75 - lockGroup.rotation.y) * 0.04;
                lockGroup.rotation.x += (mouseY * 0.45 - lockGroup.rotation.x) * 0.04;
                lockGroup.position.y = 2.7 + Math.sin(time * 1.2) * 0.12;
                lockGroup.rotation.z = Math.sin(time * 0.6) * 0.03;
            }

            renderer.render(scene, camera);
        }
        animate();
    </script>
</body>
</html>
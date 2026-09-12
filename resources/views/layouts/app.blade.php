<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Toko Kelontong Zahir')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Tailwind CSS Play CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        stone: {
                            50: '#fafaf9', 100: '#f5f5f4', 200: '#e7e5e4', 300: '#d6d3d1',
                            400: '#a8a29e', 500: '#78716c', 600: '#57534e', 700: '#44403c',
                            800: '#292524', 900: '#1c1917', 950: '#0c0a09',
                        },
                        teal: {
                            50: '#f0fdfa', 100: '#ccfbf1', 200: '#99f6e4', 300: '#5eead4',
                            400: '#2dd4bf', 500: '#14b8a6', 600: '#0d9488', 700: '#0f766e',
                            800: '#115e59', 900: '#134e4e', 950: '#042f2e',
                        }
                    }
                }
            }
        }
    </script>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-stone-100 text-stone-800 antialiased min-h-screen overflow-x-hidden">

    <!-- Tempat konten dipanggil (tanpa margin/padding pembatas di luar) -->
    <main class="w-full min-w-0 overflow-x-hidden">
        @yield('content')
    </main>

    @if(session('success') || session('error') || session('warning'))
        @php
            $notificationType = session('success') ? 'success' : (session('warning') ? 'warning' : 'error');
            $notificationMessage = session('success') ?? session('warning') ?? session('error');
            $notificationStyles = [
                'success' => 'border-emerald-200 bg-emerald-50 text-emerald-900',
                'warning' => 'border-amber-200 bg-amber-50 text-amber-900',
                'error' => 'border-rose-200 bg-rose-50 text-rose-900',
            ];
        @endphp
        <div id="global-notification" role="status" aria-live="polite"
             class="fixed right-4 top-20 z-[100] flex max-w-sm items-start gap-3 rounded-2xl border px-4 py-3 text-xs font-semibold shadow-lg transition-all duration-300 {{ $notificationStyles[$notificationType] }}">
            <span class="mt-0.5 shrink-0 text-sm font-black">
                {{ $notificationType === 'success' ? '✓' : ($notificationType === 'warning' ? '!' : '×') }}
            </span>
            <span class="flex-1">{{ $notificationMessage }}</span>
            <button type="button" onclick="dismissGlobalNotification()" class="shrink-0 text-current opacity-60 transition hover:opacity-100" aria-label="Tutup notifikasi">×</button>
        </div>
    @endif

    <!-- Script Global Notifikasi dan Konfirmasi -->
    <script>
        function dismissGlobalNotification() {
            const notification = document.getElementById('global-notification');
            if (!notification) return;

            notification.classList.add('translate-x-8', 'opacity-0');
            setTimeout(() => notification.remove(), 300);
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[data-auto-dismiss]').forEach((notification) => notification.remove());

            if (document.getElementById('global-notification')) {
                setTimeout(dismissGlobalNotification, 3000);
            }
        });

        function showToast(message, type = 'success') {
            const colors = {
                success: 'border-emerald-200 bg-emerald-50 text-emerald-900',
                warning: 'border-amber-200 bg-amber-50 text-amber-900',
                error: 'border-rose-200 bg-rose-50 text-rose-900'
            };
            const icons = { success: '✓', warning: '!', error: '×' };
            const existing = document.getElementById('client-notification');
            if (existing) existing.remove();

            const notification = document.createElement('div');
            notification.id = 'client-notification';
            notification.setAttribute('role', 'status');
            notification.setAttribute('aria-live', 'polite');
            notification.className = `fixed right-4 top-20 z-[100] flex max-w-sm items-start gap-3 rounded-2xl border px-4 py-3 text-xs font-semibold shadow-lg transition-all duration-300 ${colors[type] || colors.success}`;
            notification.innerHTML = `<span class="mt-0.5 shrink-0 text-sm font-black">${icons[type] || icons.success}</span><span class="flex-1"></span><button type="button" class="shrink-0 text-current opacity-60 transition hover:opacity-100" aria-label="Tutup notifikasi">×</button>`;
            notification.querySelector('.flex-1').textContent = message;
            notification.querySelector('button').addEventListener('click', () => dismissClientNotification(notification));
            document.body.appendChild(notification);
            setTimeout(() => dismissClientNotification(notification), 3000);
        }

        function dismissClientNotification(notification) {
            if (!notification || !notification.isConnected) return;
            notification.classList.add('translate-x-8', 'opacity-0');
            setTimeout(() => notification.remove(), 300);
        }

        // Helper Function Global untuk Konfirmasi Hapus Data
        function confirmDelete(formId, message = "Data yang dihapus tidak dapat dikembalikan!") {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626', // Warna Merah
                cancelButtonColor: '#4b5563',  // Warna Abu-abu
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'px-4 py-2 rounded-lg text-sm font-semibold',
                    cancelButton: 'px-4 py-2 rounded-lg text-sm font-semibold mr-2'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
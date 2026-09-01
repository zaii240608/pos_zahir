<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'POS System')</title>
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
<body class="bg-stone-100 text-stone-800 antialiased min-h-screen">

    <!-- Tempat konten dipanggil (tanpa margin/padding pembatas di luar) -->
    <main class="w-full">
        @yield('content')
    </main>

    <!-- Script Global SweetAlert2 -->
    <script>
        // Pop-up Notifikasi Sukses dari Controller
        // @if(session('success'))
        //     Swal.fire({
        //         icon: 'success',
        //         title: 'Berhasil!',
        //         text: "{{ session('success') }}",
        //         showConfirmButton: false,
        //         timer: 2000,
        //         customClass: {
        //             popup: 'rounded-2xl'
        //         }
        //     });
        // @endif

        // Pop-up Notifikasi Error dari Controller
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                confirmButtonColor: '#dc2626',
                customClass: {
                    popup: 'rounded-2xl'
                }
            });
        @endif

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
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    @livewireStyles
    @stack('styles')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite('resources/js/app.js')
</head>

<body>
    <div class="wrapper">
        @include('layouts.sidebar')

        <div class="main">
            @include('layouts.header')

            <main class="content">
                <div class="container-fluid p-0">
                    {{ $slot }}
                </div>
            </main>

            @include('layouts.footer')
        </div>
    </div>
    @livewireScripts
    @stack('scripts')
    <script>
        function changeRoleActive(e) {
            const value = e.value;
            const url = document.querySelector('input[name="change_role_active_url"]').value;
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const homeUrl = document.querySelector('input[name="home_url"]').value;
            if (value != '0') {
                fetch(url, {
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        method: 'POST',
                        credentials: 'same-origin',
                        body: `role_active=${value}`
                    })
                    .then(response => {
                        if (!response.ok) {
                            switch (response.status) {
                                case 401:
                                    throw new Error("Sesi login Anda sudah habis! Silakan login kembali.");
                                    break;
                                case 403:
                                    throw new Error("Tidak dapat mengubah peran aktif! Silakan login kembali.");
                                default:
                                    throw new Error("Terjadi kesalahan sistem! Silakan login kembali.");
                                    break;
                            }
                        } else {
                            return response.json();
                        }
                    })
                    .then(data => {
                        swal({
                            title: "",
                            text: data.message,
                            icon: "info"
                        })
                        .then(() => {
                            window.location.href = homeUrl;
                        });
                    })
                    .catch(err => {
                        swal({
                            title: "",
                            text: err.message,
                            icon: "error"
                        })
                        .then(() => {
                            window.location.reload();
                        });
                    });
            }
        }
    </script>
</body>

</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Styles -->
</head>

<body class="antialiased">
    <div
        class="relative min-h-screen bg-gray-100 bg-center sm:flex sm:justify-center sm:items-center bg-dots-darker selection:bg-red-500 selection:text-white">
        @if (Route::has('login'))
            <div class="z-10 p-6 text-right sm:fixed sm:top-0 sm:right-0">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                @else
                    <a href="{{ route('login') }}"
                        class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log
                        in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="ml-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                    @endif
                @endauth
            </div>
        @endif

        <div class="container px-4 py-16 mx-auto">
            <div class="flex flex-col items-center text-center md:flex-row md:items-start md:text-left">
                <div class="w-full">
                    <h1 class="text-4xl font-bold md:text-5xl lg:text-6xl xl:text-8xl">
                        Sampaikan Keluhan Anda,
                        <br /> Kami Siap Mendengarkan
                    </h1>
                    <p class="mt-6 text-lg md:text-xl lg:text-2xl">
                        Kami berdedikasi menangani kebutuhan masyarakat.
                        <br />
                        Sampaikan keluhan atau masukan Anda, dan kami akan
                        <br />
                        memberikan solusi terbaik.
                    </p>
                    <div class="flex flex-col items-center gap-4 mt-8 md:flex-row md:items-start">
                        <a href="{{ route('login') }}"
                            class="px-6 py-3 text-white bg-black rounded-lg hover:bg-gray-800 md:px-8 md:py-4">
                            Ajukan Pengaduan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

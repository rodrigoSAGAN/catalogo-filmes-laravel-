<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Catálogo de Filmes') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-100 antialiased bg-gray-900 selection:bg-purple-500 selection:text-white">
    <div class="relative min-h-screen flex flex-col items-center justify-center overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
            <div
                class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-purple-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob">
            </div>
            <div
                class="absolute top-[-10%] right-[-10%] w-96 h-96 bg-pink-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000">
            </div>
            <div
                class="absolute bottom-[-20%] left-[20%] w-96 h-96 bg-indigo-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000">
            </div>
        </div>

        <!-- Header/Nav -->
        <div class="absolute top-0 right-0 p-6 z-20">
            @if (Route::has('login'))
                <nav class="flex gap-4">
                    @auth
                        <a href="{{ url('/movies') }}"
                            class="text-gray-300 hover:text-white font-semibold transition duration-300">
                            Filmes
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-gray-300 hover:text-white font-semibold transition duration-300">
                            Entrar
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="text-gray-300 hover:text-white font-semibold transition duration-300">
                                Cadastrar
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>

        <!-- Main Content -->
        <div class="relative z-10 max-w-4xl mx-auto text-center px-6">
            <h1
                class="text-5xl md:text-7xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 via-pink-500 to-red-500 mb-6 tracking-tight">
                CATÁLOGO DE FILMES
            </h1>

            <p class="text-xl md:text-2xl text-gray-300 mb-12 max-w-2xl mx-auto leading-relaxed">
                Aqui você organiza e ranqueia seus filmes e séries preferidos.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-6">
                @auth
                    <a href="{{ route('movies.index') }}"
                        class="px-8 py-4 text-lg font-bold text-white bg-purple-600 rounded-full hover:bg-purple-700 transition duration-300 shadow-lg hover:shadow-purple-500/50 transform hover:-translate-y-1">
                        Acessar Catálogo
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="px-8 py-4 text-lg font-bold text-white bg-purple-600 rounded-full hover:bg-purple-700 transition duration-300 shadow-lg hover:shadow-purple-500/50 transform hover:-translate-y-1">
                        Entrar
                    </a>
                    <a href="{{ route('register') }}"
                        class="px-8 py-4 text-lg font-bold text-purple-400 border-2 border-purple-600 rounded-full hover:bg-purple-600 hover:text-white transition duration-300 shadow-lg hover:shadow-purple-500/30 transform hover:-translate-y-1">
                        Cadastrar
                    </a>
                @endauth
            </div>
        </div>

        <!-- Footer -->
        <div class="absolute bottom-4 text-gray-500 text-sm z-10">
            &copy; {{ date('Y') }} Catálogo de Filmes. Todos os direitos reservados.
        </div>
    </div>

    <style>
        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</body>

</html>
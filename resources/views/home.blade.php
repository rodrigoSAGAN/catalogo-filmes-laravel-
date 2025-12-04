<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Catálogo de Filmes') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes gradient-shift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .animated-gradient-bg {
            background: linear-gradient(-45deg, #1f0c3d, #3a0d5c, #5c0d3d, #7c0e5b);
            background-size: 400% 400%;
            animation: gradient-shift 15s ease infinite;
        }

        @keyframes pulse-logo {
            0% {
                transform: scale(1);
                opacity: 0.8;
            }

            50% {
                transform: scale(1.05);
                opacity: 1;
            }

            100% {
                transform: scale(1);
                opacity: 0.8;
            }
        }

        .animate-pulse-logo {
            animation: pulse-logo 3s ease-in-out infinite;
        }
    </style>
</head>

<body class="font-sans text-gray-100 antialiased animated-gradient-bg selection:bg-purple-500 selection:text-white">
    <div class="relative min-h-screen flex flex-col items-center justify-center overflow-hidden bg-black bg-opacity-50">

        <div class="absolute top-0 w-full p-6 flex justify-between items-center z-20">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div
                    class="w-12 h-12 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
                <span class="text-2xl font-bold text-purple-400 group-hover:text-purple-300 transition-colors">CATÁLOGO
                    DE FILMES</span>
            </a>
            @if (Route::has('login'))
                <nav class="flex gap-4">
                    @auth
                        <a href="{{ url('/filmes') }}"
                            class="text-gray-300 hover:text-white font-semibold transition duration-300">
                            Meus Filmes
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 text-sm font-semibold text-white bg-purple-600 rounded-full hover:bg-purple-700 transition duration-300">
                            Entrar
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="px-4 py-2 text-sm font-semibold text-purple-400 border-2 border-purple-600 rounded-full hover:bg-purple-600 hover:text-white transition duration-300">
                                Cadastrar
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>

        <div
            class="relative z-10 max-w-4xl mx-auto text-center px-6 py-12 bg-black bg-opacity-70 rounded-lg shadow-xl border border-purple-800 animate-fade-in">
            <div class="mb-8">
                <svg class="mx-auto w-24 h-24 text-purple-400 mb-6 animate-pulse-logo" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
            </div>

            <h1
                class="text-4xl md:text-6xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-300 via-purple-400 to-indigo-500 mb-6 tracking-tight drop-shadow-lg">
                CATÁLOGO DE FILMES
            </h1>

            <p class="text-xl md:text-2xl text-gray-300 mb-10 max-w-2xl mx-auto leading-relaxed">
                Aqui você organiza, classifica e compara seus filmes e séries preferidos.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-6">
                @auth
                    <a href="{{ route('filmes.listar') }}" {{-- Usando a rota nomeada 'filmes.listar' --}}
                        class="px-8 py-4 text-lg font-bold text-white bg-purple-700 rounded-full hover:bg-purple-800 transition duration-300 shadow-lg hover:shadow-purple-500/50 transform hover:-translate-y-1">
                        Acessar Catálogo
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="px-8 py-4 text-lg font-bold text-white bg-purple-700 rounded-full hover:bg-purple-800 transition duration-300 shadow-lg hover:shadow-purple-500/50 transform hover:-translate-y-1">
                        Entrar
                    </a>
                    <a href="{{ route('register') }}"
                        class="px-8 py-4 text-lg font-bold text-purple-300 border-2 border-purple-600 rounded-full hover:bg-purple-600 hover:text-white transition duration-300 shadow-lg hover:shadow-purple-500/30 transform hover:-translate-y-1">
                        Cadastrar
                    </a>
                @endauth
            </div>
        </div>

        <div class="absolute bottom-4 text-gray-400 text-sm z-10">
            &copy; {{ date('Y') }} Catálogo de Filmes. Todos os direitos reservados.
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" integrity="sha512-..."
        crossorigin="anonymous"></script>
</body>

</html>
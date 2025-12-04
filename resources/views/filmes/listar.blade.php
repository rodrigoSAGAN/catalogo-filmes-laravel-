<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-purple-400 leading-tight">
                {{ __('Filmes') }}
            </h2>
            <a href="{{ route('filmes.criar') }}"
                class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded transition duration-150 ease-in-out">
                Adicionar Filme
            </a>
        </div>
    </x-slot>

    <div class="py-12" x-data="{ open: false, selectedMovie: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Genre and Author Filter Form --}}
            <div class="mb-6">
                <form method="GET" action="{{ route('movies.index') }}" class="space-y-4">
                    <div class="flex flex-col sm:flex-row gap-3">
                        {{-- Genre Filter --}}
                        <div class="flex-1">
                            <label for="genero" class="block text-sm font-medium text-purple-300 mb-2">
                                Filtrar por Gênero
                            </label>
                            <select id="genero" 
                                    name="genero" 
                                    class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200"
                                    onchange="this.form.submit()">
                                <option value="">Todos os Gêneros</option>
                                @foreach($generos as $genero)
                                    <option value="{{ $genero }}" {{ request('genero') == $genero ? 'selected' : '' }}>
                                        {{ $genero }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Author Search --}}
                        <div class="flex-1">
                            <label for="autor" class="block text-sm font-medium text-purple-300 mb-2">
                                Buscar por Autor
                            </label>
                            <div class="flex gap-2">
                                <input type="text" 
                                       id="autor" 
                                       name="autor" 
                                       value="{{ request('autor') }}"
                                       placeholder="Buscar por Autor..." 
                                       class="flex-1 px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200">
                                <button type="submit" 
                                        class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-gray-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Clear Filters Button --}}
                    @if(request('genero') || request('autor'))
                        <div class="flex justify-end">
                            <a href="{{ route('movies.index') }}" 
                               class="px-6 py-2 bg-gray-700 hover:bg-gray-600 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 focus:ring-offset-gray-900">
                                <svg class="inline-block w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Limpar Filtros
                            </a>
                        </div>
                    @endif

                    {{-- Active Filters Display --}}
                    @if(request('genero') || request('autor'))
                        <div class="flex flex-wrap gap-2 items-center text-sm text-purple-300">
                            <span class="font-semibold">Filtros ativos:</span>
                            @if(request('genero'))
                                <span class="px-3 py-1 bg-purple-900 text-purple-200 rounded-full">
                                    Gênero: {{ request('genero') }}
                                </span>
                            @endif
                            @if(request('autor'))
                                <span class="px-3 py-1 bg-purple-900 text-purple-200 rounded-full">
                                    Autor: {{ request('autor') }}
                                </span>
                            @endif
                        </div>
                    @endif
                </form>
            </div>

            <div id="movie-list" class="flex flex-col space-y-4">
                @foreach ($movies as $movie)
                    <div data-id="{{ $movie->id }}" @click="selectedMovie = {{ $movie }}; open = true"
                        class="bg-gray-800 overflow-hidden shadow-lg rounded-lg border border-gray-700 hover:border-purple-500 transition duration-300 flex flex-row h-64 cursor-pointer group">
                        <!-- Image Section (Fixed Width, Left) -->
                        <div class="w-48 sm:w-56 flex-shrink-0 bg-gray-700 relative overflow-hidden">
                            @if($movie->image_url)
                                <img src="{{ $movie->image_url }}" alt="{{ $movie->title }}"
                                    class="absolute inset-0 w-full h-full object-cover transform transition duration-300 group-hover:scale-110"
                                    referrerpolicy="no-referrer"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div
                                    class="hidden items-center justify-center h-full text-gray-500 bg-gray-700 absolute inset-0">
                                    <span class="text-4xl">🎬</span>
                                </div>
                            @else
                                <div class="flex items-center justify-center h-full text-gray-500">
                                    <span class="text-4xl">🎬</span>
                                </div>
                            @endif
                            <div class="absolute top-2 left-2">
                                <span class="px-2 py-1 text-xs font-bold text-white bg-purple-600 rounded-full shadow-md">
                                    {{ $movie->rating ?? 'N/A' }}
                                </span>
                            </div>
                        </div>

                        <!-- Content Section (Right) -->
                        <div class="flex-1 p-4 flex flex-col justify-between">
                            <div>
                                <div class="flex justify-between items-start">
                                    <h3 class="text-xl font-bold text-white truncate mr-2" title="{{ $movie->title }}">
                                        {{ $movie->title }}
                                    </h3>
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $movie->is_series ? 'bg-purple-900 text-purple-200' : 'bg-gray-700 text-gray-300' }} flex-shrink-0">
                                        {{ $movie->is_series ? 'Série' : 'Filme' }}
                                    </span>
                                </div>
                                <div class="mt-1 text-sm text-gray-400">
                                    <span class="mr-4">{{ $movie->release_year }}</span>
                                    <span>{{ $movie->genre }}</span>
                                </div>
                            </div>

                            <div class="flex justify-end items-center space-x-3 mt-2" @click.stop>
                                <a href="{{ route('movies.edit', $movie->id) }}"
                                    class="inline-flex items-center px-3 py-1 bg-gray-700 border border-gray-600 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-600 hover:border-purple-600 focus:outline-none focus:border-purple-700 focus:ring ring-purple-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Editar
                                </a>
                                <form action="{{ route('movies.destroy', $movie->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center px-3 py-1 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150"
                                        onclick="return confirm('Tem certeza?')">
                                        Excluir
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Modal -->
        <div x-show="open" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
            aria-modal="true" style="display: none;">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                    class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true"
                    @click="open = false"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="open" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="inline-block align-bottom bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-gray-700">
                    <div class="bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-purple-400" id="modal-title"
                                    x-text="selectedMovie?.title"></h3>
                                <div class="mt-4">
                                    <template x-if="selectedMovie?.image_url">
                                        <img :src="selectedMovie?.image_url"
                                            class="w-full h-64 object-cover rounded-md mb-4" alt="Movie Cover"
                                            referrerpolicy="no-referrer">
                                    </template>
                                    <h4 class="text-md font-bold text-gray-200 mt-2">Seu Comentário e Avaliação
                                    </h4>
                                    <div class="flex items-center mt-1">
                                        <span class="font-semibold text-purple-400 mr-2">Avaliação:</span>
                                        <template x-if="selectedMovie?.user_rating">
                                            <div class="flex">
                                                <template x-for="i in 5">
                                                    <svg class="w-5 h-5"
                                                        :class="i <= selectedMovie.user_rating ? 'text-yellow-400' : 'text-gray-500'"
                                                        fill="currentColor" viewBox="0 0 20 20"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                        </path>
                                                    </svg>
                                                </template>
                                            </div>
                                        </template>
                                        <template x-if="!selectedMovie?.user_rating">
                                            <span class="text-gray-400 text-sm">Não avaliado</span>
                                        </template>
                                    </div>
                                    <p class="text-sm text-gray-300 mt-2 bg-gray-700 p-3 rounded-md italic"
                                        x-text="selectedMovie?.personal_comment || 'Sem comentário pessoal.'">
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm"
                            @click="open = false">
                            Fechar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var el = document.getElementById('movie-list');
            var sortable = Sortable.create(el, {
                animation: 150,
                onEnd: function (evt) {
                    var newOrder = sortable.toArray();

                    fetch('{{ route('movies.reorder') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            ids: newOrder
                        })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                console.log('Order updated successfully');
                            } else {
                                console.error('Failed to update order');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }
            });
        });
    </script>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-purple-400 leading-tight">
            {{ __('Editar Filme') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-700">
                <div class="p6 text-gray-100">
                    <form action="{{ route('movies.update', $movie->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-200">Título</label>
                            <input type="text" id="title" name="title" value="{{ $movie->title }}"
                                class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-gray-100 placeholder-gray-400 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="release_year" class="block text-sm font-medium text-gray-200">Ano de
                                Lançamento</label>
                            <input type="number" id="release_year" name="release_year" value="{{ $movie->release_year }}"
                                class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-gray-100 placeholder-gray-400 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="genre" class="block text-sm font-medium text-gray-200">Gênero</label>
                            <select id="genre" name="genre"
                                class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-gray-100 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm"
                                required>
                                <option value="">Selecione um gênero</option>
                                @foreach($generos as $genero)
                                    <option value="{{ $genero }}" {{ $movie->genre == $genero ? 'selected' : '' }}>
                                        {{ $genero }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="autor" class="block text-sm font-medium text-gray-200">Autor (Nome do Diretor/Escritor)</label>
                            <input type="text" id="autor" name="autor" value="{{ $movie->autor }}"
                                class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-gray-100 placeholder-gray-400 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                        </div>

                        <div class="mb-4">
                            <div class="flex items-center">
                                <input type="checkbox" id="is_series" name="is_series" value="1" {{ $movie->is_series ? 'checked' : '' }}
                                    class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-600 rounded bg-gray-700">
                                <label for="is_series" class="ml-2 block text-sm text-gray-200">É uma Série?</label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="rating" class="block text-sm font-medium text-gray-200">Avaliação
                                (IMDb/Rotten)</label>
                            <input type="number" id="rating" name="rating" step="0.1" min="0" max="10"
                                value="{{ $movie->rating }}"
                                class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-gray-100 placeholder-gray-400 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                        </div>

                        <div class="mb-4">
                            <label for="image_url" class="block text-sm font-medium text-gray-200">URL da Imagem</label>
                            <input type="url" id="image_url" name="image_url" value="{{ $movie->image_url }}"
                                class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-gray-100 placeholder-gray-400 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                        </div>

                        <div class="mb-4">
                            <label for="personal_comment" class="block text-sm font-medium text-gray-200">Comentário
                                Pessoal</label>
                            <textarea id="personal_comment" name="personal_comment" rows="3"
                                class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-gray-100 placeholder-gray-400 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">{{ $movie->personal_comment }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="user_rating" class="block text-sm font-medium text-gray-200">Sua Avaliação
                                (1-5)</label>
                            <input type="number" id="user_rating" name="user_rating" min="1" max="5"
                                value="{{ $movie->user_rating }}"
                                class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-gray-100 placeholder-gray-400 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('movies.index') }}"
                                class="text-gray-400 hover:text-gray-200 mr-4">Cancelar</a>
                            <button type="submit"
                                class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                                Atualizar Filme
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
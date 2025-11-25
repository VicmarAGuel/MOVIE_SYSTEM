<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

         {{-- Success Messagee --}}
        @if(session('success'))
            <div id="flash-message" class="rounded-lg bg-green-200/20 p-4 text-green-300 dark:bg-green-800/40 dark:text-green-200">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <!-- Total Movies -->
            <div class="relative overflow-hidden rounded-xl border border-slate-700 bg-slate-800 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-300">Total Movies</p>
                        <h3 class="mt-2 text-3xl font-bold text-white">{{ $movies->count() }}</h3>
                    </div>
                    <div class="rounded-full bg-blue-900/40 p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                            class="h-6 w-6 text-blue-400"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">

                            <circle cx="12" cy="12" r="10"></circle>
                            <circle cx="12" cy="7.5" r="1.5"></circle>
                            <circle cx="12" cy="16.5" r="1.5"></circle>
                            <circle cx="7.5" cy="12" r="1.5"></circle>
                            <circle cx="16.5" cy="12" r="1.5"></circle>

                            <path d="M22 12h-2"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Genres -->
            <div class="relative overflow-hidden rounded-xl border border-slate-700 bg-slate-800 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-300">Total Genres</p>
                        <h3 class="mt-2 text-3xl font-bold text-white">{{ $genres->count() }}</h3>
                    </div>
                    <div class="rounded-full bg-green-900/40 p-3">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 text-green-400"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">

                            <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 7a2 2 0 012-2h4l2 2h6a2 2 0 012 2v7a2 2 0 01-2 2H5a2 2 0 01-2-2V7z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Average Rating -->
            <div class="relative overflow-hidden rounded-xl border border-slate-700 bg-slate-800 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-300">Average Rating</p>
                        <h3 class="mt-2 text-3xl font-bold text-white">{{ number_format($movies->avg('rating'), 1) }}</h3>
                    </div>
                    <div class="rounded-full bg-purple-900/40 p-3">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 text-purple-400"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">

                            <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 17.25l-5.19 3.03 1.39-5.97L3 9.75l6.03-.52L12 3.75l2.97 5.48L21 9.75l-5.2 4.56 1.39 5.97L12 17.25z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add New Movie Form Container -->
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-slate-700 bg-slate-800">
            <div class="flex h-full flex-col p-6">
                <div class="mb-6 rounded-lg border border-slate-700 bg-slate-900 p-6">
                    <h2 class="mb-4 text-lg font-semibold text-white">Add New Movie</h2>

                    <form action="{{ route('movies.store') }}" method="POST" class="grid gap-4 md:grid-cols-2">
                        @csrf

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-300">Title</label>
                            <input type="text" name="title" value="{{ old('title') }}" placeholder="Enter movie title" required class="w-full rounded-lg border border-slate-600 bg-slate-800 px-4 py-2 text-sm text-white focus:border-blue-500 focus:ring-blue-500/30">
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-300">Director</label>
                            <input type="text" name="director" value="{{ old('director') }}" placeholder="Enter director" class="w-full rounded-lg border border-slate-600 bg-slate-800 px-4 py-2 text-sm text-white focus:border-blue-500 focus:ring-blue-500/30">
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-300">Release Year</label>
                            <input type="number" name="release_year" value="{{ old('release_year') }}" placeholder="e.g., 2023" class="w-full rounded-lg border border-slate-600 bg-slate-800 px-4 py-2 text-sm text-white focus:border-blue-500 focus:ring-blue-500/30">
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-300">Rating</label>
                            <input type="number" step="0.1" max="10" min="0" name="rating" value="{{ old('rating') }}" placeholder="e.g., 8.5" class="w-full rounded-lg border border-slate-600 bg-slate-800 px-4 py-2 text-sm text-white focus:border-blue-500 focus:ring-blue-500/30">
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-300">Genre</label>
                            <select name="genre_id" required class="w-full rounded-lg border border-slate-600 bg-slate-800 px-4 py-2 text-sm text-white focus:border-blue-500 focus:ring-blue-500/30">
                                <option value="">Select a genre</option>
                                @foreach($genres as $genre)
                                    <option value="{{ $genre->id }}" {{ old('genre_id') == $genre->id ? 'selected' : '' }}>
                                        {{ $genre->name }} ({{ $genre->description ?? 'No description' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="mb-2 block text-sm font-medium text-slate-300">Synopsis</label>
                            <textarea name="synopsis" placeholder="Enter synopsis" class="w-full rounded-lg border border-slate-600 bg-slate-800 px-4 py-2 text-sm text-white focus:border-blue-500 focus:ring-blue-500/30">{{ old('synopsis') }}</textarea>
                        </div>

                        <div class="md:col-span-2 flex justify-end">
                            <button type="submit" class="rounded-lg bg-blue-600 px-6 py-2 text-sm font-medium text-white hover:bg-blue-700">
                                Add Movie
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Movie List -->
                <div class="flex-1 overflow-auto">
                    <h2 class="mb-4 text-lg font-semibold text-white">Movie List</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-full">
                            <thead>
                                <tr class="border-b border-slate-700 bg-slate-900">
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-slate-300">#</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-slate-300">Title</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-slate-300">Genre</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-slate-300">Year</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-slate-300">Rating</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-slate-300">Director</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-slate-300">Synopsis</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-slate-300">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-700">

                                @forelse($movies as $movie)
                                <tr class="transition-colors hover:bg-slate-700/40">
                                    <td class="px-4 py-3 text-sm text-slate-300">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3 text-sm text-white">{{ $movie->title }}</td>
                                    <td class="px-4 py-3 text-sm text-slate-300">{{ $movie->genre?->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-sm text-slate-300">{{ $movie->release_year ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm text-slate-300">{{ $movie->rating ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm text-slate-300">{{ $movie->director ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm text-slate-300 max-w-md">{{ $movie->synopsis ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        <button onclick="editMovie({{ $movie->id }}, '{{ $movie->title }}', {{ $movie->genre_id ?? 'null' }}, '{{ $movie->release_year }}', '{{ $movie->rating }}', '{{ $movie->director }}', '{{ addslashes($movie->synopsis) }}')" 
                                            class="text-blue-400 hover:text-blue-300">
                                            Edit
                                        </button>
                                        <span class="mx-1 text-slate-500">|</span>
                                        <form action="{{ route('movies.destroy', $movie) }}" method="POST" class="inline" onsubmit="return confirm('Delete movie?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-300">Delete</button>
                                        </form>
                                    </td>
                                </tr>

                                @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-8 text-center text-sm text-slate-400">
                                        No movies found. Add your first movie above!
                                    </td>
                                </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Edit Movie Modal -->
    <div id="editMovieModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60">
        <div class="w-full max-w-2xl rounded-xl border border-slate-700 bg-slate-800 p-6">
            <h2 class="mb-4 text-lg font-semibold text-white">Edit Movie</h2>

            <form id="editMovieForm" method="POST">
                @csrf
                @method('PUT')

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-300">Title</label>
                        <input type="text" id="edit_title" name="title" required class="w-full rounded-lg border border-slate-600 bg-slate-900 px-4 py-2 text-sm text-white">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-300">Director</label>
                        <input type="text" id="edit_director" name="director" class="w-full rounded-lg border border-slate-600 bg-slate-900 px-4 py-2 text-sm text-white">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-300">Release Year</label>
                        <input type="number" id="edit_release_year" name="release_year" class="w-full rounded-lg border border-slate-600 bg-slate-900 px-4 py-2 text-sm text-white">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-300">Rating</label>
                        <input type="number" step="0.1" max="10" min="0" id="edit_rating" name="rating" class="w-full rounded-lg border border-slate-600 bg-slate-900 px-4 py-2 text-sm text-white">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-300">Genre</label>
                        <select id="edit_genre_id" name="genre_id" class="w-full rounded-lg border border-slate-600 bg-slate-900 px-4 py-2 text-sm text-white">
                            <option value="">Select a genre</option>
                            @foreach($genres as $genre)
                                <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-slate-300">Synopsis</label>
                        <textarea id="edit_synopsis" name="synopsis" class="w-full rounded-lg border border-slate-600 bg-slate-900 px-4 py-2 text-sm text-white"></textarea>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeEditMovieModal()"
                        class="rounded-lg border border-slate-600 px-4 py-2 text-sm font-medium text-slate-300 hover:bg-slate-700">
                        Cancel
                    </button>
                    <button type="submit"
                        class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                        Update Movie
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editMovie(id, title, genreId, release_year, rating, director, synopsis) {
            document.getElementById('editMovieModal').classList.remove('hidden');
            document.getElementById('editMovieModal').classList.add('flex');
            document.getElementById('editMovieForm').action = `/movies/${id}`;
            document.getElementById('edit_title').value = title;
            document.getElementById('edit_director').value = director;
            document.getElementById('edit_release_year').value = release_year;
            document.getElementById('edit_rating').value = rating;
            document.getElementById('edit_genre_id').value = genreId || '';
            document.getElementById('edit_synopsis').value = synopsis;
        }

        function closeEditMovieModal() {
            document.getElementById('editMovieModal').classList.add('hidden');
            document.getElementById('editMovieModal').classList.remove('flex');
        }
         document.addEventListener('DOMContentLoaded', () => {
    const flashMessage = document.getElementById('flash-message');

    if (flashMessage) {
        setTimeout(() => {
            flashMessage.style.transition = 'opacity 0.5s ease-out';
            flashMessage.style.opacity = '0';

            setTimeout(() => {
                flashMessage.remove();
            }, 500);
        }, 3000);
    }
});

    </script>
</x-layouts.app>

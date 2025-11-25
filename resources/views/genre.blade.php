<x-layouts.app :title="__('Genres')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        {{-- Success Message --}}
        @if(session('success'))
            <div id="flash-message" class="rounded-lg bg-green-700/30 p-4 text-green-300 dark:bg-green-700/30 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-slate-700 bg-slate-900">
            <div class="flex h-full flex-col p-6">

                <!-- Add New Genre Form -->
                <div class="mb-6 rounded-lg border border-slate-700 bg-slate-800 p-6">
                    <h2 class="mb-4 text-lg font-semibold text-slate-100">Add New Genre</h2>

                    <form action="{{ route('genres.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-300">Name</label>
                                <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter genre name" required
                                       class="w-full rounded-lg border border-slate-700 bg-slate-900 px-4 py-2 text-sm text-slate-100 focus:border-slate-500 focus:ring-2 focus:ring-slate-500/20">
                                @error('name')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-300">Description</label>
                                <input type="text" name="description" value="{{ old('description') }}" placeholder="Enter description (optional)"
                                       class="w-full rounded-lg border border-slate-700 bg-slate-900 px-4 py-2 text-sm text-slate-100 focus:border-slate-500 focus:ring-2 focus:ring-slate-500/20">
                                @error('description')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="rounded-lg bg-slate-600 px-6 py-2 text-sm font-medium text-white transition-colors hover:bg-slate-700">
                                Add Genre
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Genres Table -->
                <div class="flex-1 overflow-auto">
                    <h2 class="mb-4 text-lg font-semibold text-slate-100">Genre List</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-full">
                            <thead>
                                <tr class="border-b border-slate-700 bg-slate-800">
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-slate-300">#</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-slate-300">Name</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-slate-300">Description</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-slate-300">Movies Count</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-slate-300">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-700">
                                @forelse($genres as $genre)
                                    <tr class="transition-colors hover:bg-slate-700">
                                        <td class="px-4 py-3 text-center text-sm text-slate-400">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 text-center text-sm text-slate-100">{{ $genre->name }}</td>
                                        <td class="px-4 py-3 text-center text-sm text-slate-400">{{ $genre->description ?? '-' }}</td>
                                        <td class="px-4 py-3 text-center text-sm text-slate-400">{{ $genre->movies_count }}</td>
                                        <td class="px-4 py-3 text-center text-sm">
                                            <button onclick="editGenre({{ $genre->id }}, '{{ addslashes($genre->name) }}', '{{ addslashes($genre->description ?? '') }}')"
                                                class="text-slate-300 transition-colors hover:text-white">
                                                Edit
                                            </button>
                                            <span class="mx-1 text-slate-500">|</span>
                                            <form action="{{ route('genres.destroy', $genre) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-400 transition-colors hover:text-red-300">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-center text-sm text-slate-400">
                                            No genres found. Add your first genre above!
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

    <!-- Edit Genre Modal -->
    <div id="editGenreModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">
        <div class="w-full max-w-2xl rounded-xl border border-slate-700 bg-slate-800 p-6">
            <h2 class="mb-4 text-lg font-semibold text-slate-100">Edit Genre</h2>

            <form id="editGenreForm" method="POST">
                @csrf
                @method('PUT')
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-300">Name</label>
                        <input type="text" id="edit_name" name="name" required
                               class="w-full rounded-lg border border-slate-700 bg-slate-900 px-4 py-2 text-sm text-slate-100 focus:ring-2 focus:ring-slate-500/20">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-300">Description</label>
                        <input type="text" id="edit_description" name="description"
                               class="w-full rounded-lg border border-slate-700 bg-slate-900 px-4 py-2 text-sm text-slate-100 focus:ring-2 focus:ring-slate-500/20">
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeEditModal()"
                        class="rounded-lg border border-slate-700 px-4 py-2 text-sm font-medium text-slate-300 hover:bg-slate-700">
                        Cancel
                    </button>
                    <button type="submit"
                        class="rounded-lg bg-slate-600 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">
                        Update Genre
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editGenre(id, name, description) {
            document.getElementById('editGenreModal').classList.remove('hidden');
            document.getElementById('editGenreModal').classList.add('flex');
            document.getElementById('editGenreForm').action = `/genres/${id}`;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_description').value = description;
        }

        function closeEditModal() {
            document.getElementById('editGenreModal').classList.add('hidden');
            document.getElementById('editGenreModal').classList.remove('flex');
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

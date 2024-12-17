<div class="container mx-auto mt-8">
    @if ($report)
        <!-- Report Card -->
        <div class="max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-lg">
            <div class="p-6">
                <!-- Report Title and Description -->
                <h1 class="text-2xl font-bold text-gray-800">{{ $report->description }}</h1>
                <p class="mt-2 text-gray-600">{{ $report->type }}</p>
                <p class="mt-2 text-gray-600"><strong>Provinsi:</strong> {{ $report->province }}</p>
                <p class="mt-2 text-gray-600"><strong>Kota:</strong> {{ $report->regency }}</p>
                <p class="mt-2 text-gray-600"><strong>Dibuat:</strong>
                    {{ \Carbon\Carbon::parse($report->created_at)->translatedFormat('d F Y H:i') }}
                </p>

                <!-- Report Image -->
                <div class="mt-6">
                    <img src="{{ asset('storage/' . $report->image) }}" alt="{{ $report->description }}"
                        class="object-cover w-full h-56 rounded-md shadow-md">
                </div>

                <!-- Comment Section -->
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-800">Komentar</h3>
                    <div class="mt-4">
                        <!-- Display Comments -->
                        @foreach ($report->comments as $comment)
                            <div class="py-4 border-b border-gray-200">
                                <p class="font-semibold text-gray-800">{{ $comment->user->email }}</p>
                                <p class="text-sm text-gray-600">{{ $comment->created_at->format('d-m-Y H:i') }}</p>
                                <p class="mt-2 text-gray-800">{{ $comment->comment }}</p>
                            </div>
                        @endforeach
                    </div>

                    <!-- Comment Form -->
                    @auth
                        <div class="mt-6">
                            <form wire:submit.prevent="addComment" class="space-y-4">
                                <textarea wire:model="comment" rows="4"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Add a comment..."></textarea>
                                @error('comment')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                                <button type="submit"
                                    class="px-6 py-2 text-white bg-gray-900 rounded-md hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-800">Tambah
                                    Komentar</button>
                            </form>
                        </div>
                    @else
                        <p class="mt-4 text-gray-600">Tolong <a href="{{ route('login') }}"
                                class="text-blue-500 underline">login</a> untuk menambahkan komentar.</p>
                    @endauth
                </div>
            </div>
        </div>
    @else
        <p class="mt-4 text-2xl font-bold text-center text-gray-700">Report not found.</p>
    @endif
</div>

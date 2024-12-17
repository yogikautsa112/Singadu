<div class="p-6">
    <h1 class="mb-4 text-xl font-bold">Laporan ID: {{ $report->id }}</h1>
    <p class="text-gray-600">Riwayat Progress:</p>
    <ul class="ml-6 list-disc">
        @forelse ($report->progress as $progress)
            <li class="text-sm">{{ $progress->histories }}</li>
        @empty
            <li class="text-sm text-gray-500">Belum ada progress.</li>
        @endforelse
    </ul>

    <div class="mt-4">
        <button wire:click="$set('showAddProgressModal', true)" class="px-4 py-2 text-white bg-blue-600 rounded">
            Tambah Progress
        </button>
    </div>

    @if ($showAddProgressModal)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="p-6 bg-white rounded-lg shadow-lg">
                <h2 class="mb-4 text-lg font-bold">Tambah Progress Baru</h2>

                <textarea wire:model="progressDescription" class="w-full p-2 border rounded" placeholder="Masukkan progress"></textarea>
                @error('progressDescription')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror

                <div class="flex justify-end mt-4 space-x-2">
                    <button wire:click="$set('showAddProgressModal', false)" class="px-4 py-2 bg-gray-300 rounded">
                        Batal
                    </button>
                    <button wire:click="addProgress" class="px-4 py-2 text-white bg-blue-600 rounded">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

<div class="flex flex-wrap p-6 mx-4 my-4 space-y-4 bg-white rounded shadow-md lg:space-x-4 lg:space-y-0 lg:flex-nowrap">
    @if ($report)
        <!-- Section Kiri -->
        <div class="w-full lg:w-2/3">
            <div class="mb-4">
                <h1 class="text-lg font-bold">Laporan ID: {{ $report->id }}</h1>
                <p class="text-sm text-gray-500">Tanggal: {{ now()->format('d F Y') }}</p>
                <span
                    class="px-2 py-1 ml-1 text-xs text-white bg-green-500 rounded">{{ $report->response->response_status }}</span>
            </div>

            <div class="mb-4">
                <h2 class="text-sm font-bold text-gray-700 uppercase">Lokasi Laporan</h2>
                <p class="mt-1 text-sm text-gray-600">
                    {{ $report->regency ?? 'Informasi lokasi laporan tidak tersedia.' }}
                </p>
            </div>

            <div class="mb-4">
                @if ($report->image)
                    <img src="{{ asset('storage/' . $report->image) }}" alt="Laporan Gambar"
                        class="w-full max-w-md rounded-md">
                @else
                    <p class="text-sm text-gray-600">Gambar tidak tersedia.</p>
                @endif
            </div>
        </div>

        <!-- Section Kanan -->
        <div class="w-full lg:w-1/3">
            <div class="flex justify-end mb-4 space-x-2">
                <button wire:click="markAsCompleted"
                    wire:confirm="Apakah Anda yakin ingin menandai laporan ini sebagai selesai?"
                    class="px-3 py-1 text-xs text-white bg-blue-500 rounded hover:bg-blue-600">
                    Selesai
                </button>
                <button wire:click="$set('showAddProgressModal', true)"
                    class="px-3 py-1 text-xs text-white bg-gray-500 rounded hover:bg-gray-600">Tambah Progres</button>
            </div>
            <h3 class="mb-2 text-sm font-bold text-gray-700 uppercase">Riwayat Progress</h3>
            <div class="timeline">
                @if ($report->response && $report->response->progress && $report->response->progress->isNotEmpty())
                    <ul class="list-none">
                        @foreach ($report->response->progress as $progress)
                            @if (!empty($progress->histories))
                                @foreach ($progress->histories as $history)
                                    <li class="mb-4">
                                        <div class="flex items-start space-x-2">
                                            <span class="w-2 h-2 mt-1 bg-blue-500 rounded-full"></span>
                                            <div>
                                                <p class="text-sm text-gray-600">{{ $history['description'] }}</p>
                                                <p class="text-xs text-gray-500">{{ $history['date'] }}</p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm text-gray-600">Belum ada riwayat progress perbaikan/penyelesaian apapun.</p>
                @endif
            </div>
        </div>
    @else
        <p class="w-full text-sm text-center text-gray-600">Data laporan tidak ditemukan.</p>
    @endif

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

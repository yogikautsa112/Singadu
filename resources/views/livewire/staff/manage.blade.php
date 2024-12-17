<div class="p-6 bg-gray-50">
    <div class="p-4 bg-white border border-gray-300 rounded-lg shadow-lg">
        <h2 class="pb-2 mb-6 text-2xl font-semibold text-gray-800 border-b">Manage Reports</h2>
        <livewire:export.export-report />
        <!-- Tabel Data Laporan -->
        <table class="w-full overflow-x-auto text-left border-collapse table-auto">
            <thead class="bg-gray-200">
                <tr>
                    <th wire:click="sortBy('voting')"
                        class="px-4 py-2 text-sm font-medium text-gray-700 cursor-pointer">
                        Jumlah Vote
                        <span class="ml-2 text-xs font-bold">
                            {{ $sortField === 'voting' ? ($sortOrder === 'asc' ? '▲' : '▼') : '' }}
                        </span>
                    </th>
                    <th class="px-4 py-2 text-sm font-medium text-gray-700">Gambar</th>
                    <th class="px-4 py-2 text-sm font-medium text-gray-700">Lokasi</th>
                    <th class="px-4 py-2 text-sm font-medium text-gray-700">Deskripsi</th>
                    <th class="px-4 py-2 text-sm font-medium text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($reports as $report)
                    <tr class="hover:bg-gray-100">
                        <td class="px-4 py-3 font-medium text-center text-gray-800">
                            <span class="px-2 py-1 text-sm text-white bg-blue-500 rounded-lg">
                                {{ count($report->voting) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <img src="{{ asset('storage/' . $report->image) }}" alt="Gambar Laporan"
                                class="object-cover w-12 h-12 rounded-md">
                        </td>
                        <td class="px-4 py-3 text-gray-600">
                            {{ $report->province }} {{ $report->subdistrict }}
                            <br>
                            {{ $report->regency }} {{ $report->village }} <br>
                            {{ $report->created_at->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-4 py-3 text-gray-600">
                            {{ Str::limit($report->description, 50) }}
                        </td>
                        <td class="px-4 py-3">
                            <button wire:click="selectReport({{ $report->id }})"
                                class="px-4 py-2 text-sm font-medium text-white bg-gray-700 rounded-md hover:bg-gray-800">
                                Tindak Lanjut
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-3 text-center text-gray-600">Tidak ada data laporan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $reports->links() }}
        </div>

        {{-- Modal --}}
        @if ($selectedReportId)
            <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
                <div class="p-6 bg-white rounded-lg shadow-lg w-96">
                    <h3 class="text-lg font-bold">Tindak Lanjut</h3>
                    <p class="my-2 text-sm font-light">Pilih Tanggapan:</p>
                    <select wire:model="responseStatus" class="w-full mb-4 border rounded-md">
                        <option value="">Pilih Tindakan</option>
                        <option value="REJECT">Tolak</option>
                        <option value="ON_PROCESS">Proses Penyelesaian/Perbaikan</option>
                    </select>
                    <!-- Display errors if any -->
                    @if ($errors->has('responseStatus'))
                        <div class="mt-2 text-sm text-red-500">
                            {{ $errors->first('responseStatus') }}
                        </div>
                    @endif
                    <div class="flex justify-end gap-2">
                        <button wire:click="$set('selectedReportId', null)"
                            class="px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                            Batal
                        </button>
                        <button wire:click="submitResponse"
                            class="px-4 py-2 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700">
                            Kirim
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

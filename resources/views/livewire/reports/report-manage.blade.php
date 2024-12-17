<div class="container px-4 py-6 mx-auto">
    @if ($reports->isEmpty())
        <div class="py-10 text-center text-gray-600">
            <p>Tidak ada laporan yang tersedia.</p>
        </div>
    @else
        <div class="space-y-6">
            @foreach ($reports as $report)
                <div wire:key="{{ $report->id }}" class="overflow-hidden bg-white border rounded-lg shadow-md">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-bold text-gray-900">
                                Pengaduan {{ $report->created_at->format('d F Y') }}
                            </h2>
                            <span
                                class="badge {{ $report->response
                                    ? ($report->response->response_status === 'ON_PROCESS'
                                        ? 'badge-primary'
                                        : ($report->response->response_status === 'DONE'
                                            ? 'badge-success'
                                            : ($report->response->response_status === 'REJECT'
                                                ? 'badge-warning'
                                                : 'badge-error')))
                                    : 'badge-success' }} font-bold">
                                {{ $report->response->response_status ?? 'Menunggu' }}
                            </span>

                        </div>

                        {{-- Tabs --}}
                        <div class="grid grid-cols-3 gap-2 mb-4 tabs tabs-bordered">
                            @foreach (['data' => 'DATA', 'gambar' => 'GAMBAR', 'status' => 'STATUS'] as $key => $label)
                                <button wire:click="changeTab('{{ $key }}', {{ $report->id }})"
                                    class="tab {{ $selectedReportId === $report->id && $activeTab === $key ? 'tab-active' : '' }}">
                                    {{ $label }}
                                </button>
                            @endforeach
                        </div>

                        {{-- Tab Contents --}}
                        @if ($selectedReportId === $report->id)
                            @switch($activeTab)
                                @case('data')
                                    <div>
                                        <p class="text-sm font-semibold">Tipe:</p>
                                        <p>{{ $report->type }}</p>
                                        <p class="text-sm font-semibold">Lokasi:</p>
                                        <p>{{ $report->province }} {{ $report->regency }} {{ $report->district }}
                                            {{ $report->village }}</p>
                                        <p class="mt-4 text-sm font-semibold">Deskripsi:</p>
                                        <p>{{ $report->description }}</p>
                                    </div>
                                @break

                                @case('gambar')
                                    <div class="flex items-center justify-center">
                                        @if ($report->image)
                                            <img loading="lazy" src="{{ asset('storage/' . $report->image) }}"
                                                alt="Bukti foto laporan {{ $report->type }}"
                                                class="object-cover w-48 h-48 rounded-lg shadow-md">
                                        @else
                                            <p class="text-center text-gray-500">Tidak ada gambar tersedia</p>
                                        @endif
                                    </div>
                                @break

                                @case('status')
                                    <div>
                                        <p class="text-sm font-semibold">Status Saat Ini:</p>
                                        <p>{{ $report->response->response_status ?? 'Belum Diterima' }}</p>

                                        {{-- Tambahkan bagian progress --}}
                                        @if ($report->response && $report->response->progress && $report->response->progress->isNotEmpty())
                                            <div class="mt-4">
                                                <p class="mb-2 text-sm font-semibold">Riwayat Progress:</p>
                                                <div class="space-y-2">
                                                    @foreach ($report->response->progress as $progress)
                                                        @if (!empty($progress->histories))
                                                            @foreach ($progress->histories as $history)
                                                                <div class="p-3 bg-gray-100 rounded-lg">
                                                                    <p class="text-sm text-gray-700">
                                                                        {{ $history['description'] }}</p>
                                                                    <p class="text-xs text-gray-500">
                                                                        {{ \Carbon\Carbon::parse($history['date'])->format('d F Y') }}
                                                                    </p>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @else
                                            <p class="mt-4 text-sm text-gray-500">Belum ada riwayat progress.</p>
                                        @endif

                                        @if (!$report->response)
                                            <button wire:click="deleteReport({{ $report->id }})"
                                                wire:confirm="Apakah Anda yakin ingin menghapus laporan ini?"
                                                class="mt-4 btn btn-error btn-block">
                                                Hapus Pengaduan
                                            </button>
                                        @endif
                                    </div>
                                @break
                            @endswitch
                        @endif
                    </div>
                </div>
            @endforeach

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $reports->links() }}
            </div>
        </div>
    @endif

    {{-- Flash Messages --}}
    @foreach (['status', 'error'] as $msg)
        @if (session()->has($msg))
            <div class="toast toast-top toast-end">
                <div class="alert alert-{{ $msg === 'status' ? 'success' : 'error' }}">
                    <span>{{ session($msg) }}</span>
                </div>
            </div>
        @endif
    @endforeach
</div>

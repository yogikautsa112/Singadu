<div class="relative m-6">
    <div class="flex mb-6 space-x-4">
        {{-- Province Dropdown --}}
        <select wire:model="selectedProvince"
            class="w-1/3 px-4 py-2 border border-gray-400 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
            <option value="">All Provinces</option>
            @foreach ($provinces as $province)
                <option value="{{ $province['name'] }}">
                    {{ $province['name'] }}
                </option>
            @endforeach
        </select>

        {{-- Search Button --}}
        <button wire:click="searchReports"
            class="px-4 py-2 text-black bg-white border border-gray-400 rounded-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-500">
            Search
        </button>

        {{-- Reset Button --}}
        <button wire:click="resetFilters"
            class="px-4 py-2 text-black bg-white border border-gray-400 rounded-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-500">
            Reset
        </button>

        {{-- Add Report Link --}}
        <a href="{{ route('report.create') }}"
            class="px-4 py-2 text-black bg-white border border-gray-400 rounded-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-500 text-end">
            Tambah Keluhan
        </a>
    </div>

    <!-- Main Layout -->
    <div class="flex flex-col gap-6 lg:grid lg:grid-cols-3 lg:gap-6">
        @if ($reports->count() > 0)
            @foreach ($reports as $report)
                <div id="report-{{ $report->id }}"
                    class="w-full max-w-sm overflow-hidden transition-transform transform bg-white border border-gray-400 rounded-lg shadow-lg hover:scale-105">
                    <figure>
                        <img src="{{ asset('storage/' . $report->image) }}" alt="{{ $report->type }}"
                            class="object-cover w-full h-56 transition-opacity duration-300 hover:opacity-80" />
                    </figure>
                    <div class="p-6">
                        <!-- Report Description and Link to Show Page -->
                        <a href="{{ route('report.show', $report->id) }}"
                            class="mb-2 text-xl font-semibold text-black underline">{{ $report->description }}</a>
                        <p class="mb-4 text-sm text-gray-600">{{ $report->type }}</p>

                        <!-- Display Like and View Counts -->
                        <div class="flex justify-between">
                            <div class="flex items-center">
                                <!-- Livewire Like Button -->
                                <livewire:reports.like-reports :report="$report" :key="$report->id" />
                            </div>
                            <div class="flex items-center">
                                <i class="text-gray-500 fas fa-eye"></i>
                                <span class="ml-2 text-sm text-gray-600">{{ $report->views }} Views</span>
                            </div>
                        </div>

                        <!-- Display Creation Date -->
                        <p class="mt-2 text-xs text-gray-500">Dibuat Pada {{ $report->created_at->format('d M Y') }}
                        </p>
                    </div>
                </div>
            @endforeach
        @else
            <p class="mt-4 text-gray-600">Tidak ada keluhan yang ditemukan.</p>
        @endif
    </div>
</div>

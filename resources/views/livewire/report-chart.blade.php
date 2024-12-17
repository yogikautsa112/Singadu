<div class="p-6 bg-white rounded-lg shadow-lg">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Chart Berdasarkan Provinsi</h2>
        <div class="flex space-x-4">
            <div class="flex items-center space-x-2">
                <div class="w-4 h-4 bg-blue-500 rounded"></div>
                <span class="text-sm text-gray-600">Complaints</span>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-4 h-4 bg-red-500 rounded"></div>
                <span class="text-sm text-gray-600">Responses</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-2">
        <div class="p-4 border border-blue-100 rounded-lg shadow-sm bg-blue-50">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="mb-1 text-sm font-medium text-blue-800">Total Complaints</h3>
                    <p class="text-2xl font-bold text-blue-600">
                        {{ array_sum($complaintsData) }}
                    </p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-blue-300" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
            </div>
        </div>
        <div class="p-4 border border-red-100 rounded-lg shadow-sm bg-red-50">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="mb-1 text-sm font-medium text-red-800">Total Responses</h3>
                    <p class="text-2xl font-bold text-red-600">
                        {{ array_sum($responsesData) }}
                    </p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-red-300" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
            </div>
        </div>
    </div>

    <div class="p-4 border border-gray-100 rounded-lg shadow-sm bg-gray-50">
        <canvas id="reportChart" wire:ignore class="w-full h-96"></canvas>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('reportChart');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($labels),
                    datasets: [{
                            label: 'Total Complaints',
                            data: @json($complaintsData),
                            backgroundColor: 'rgba(59, 130, 246, 0.7)',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 1,
                            borderRadius: 5
                        },
                        {
                            label: 'Total Responses',
                            data: @json($responsesData),
                            backgroundColor: 'rgba(239, 68, 68, 0.7)',
                            borderColor: 'rgba(239, 68, 68, 1)',
                            borderWidth: 1,
                            borderRadius: 5
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            top: 10,
                            bottom: 10
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Count'
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                boxWidth: 20,
                                font: {
                                    size: 12
                                }
                            }
                        },
                        title: {
                            display: false
                        }
                    }
                }
            });
        });
    </script>
@endpush

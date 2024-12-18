<div class="relative">
    <div class="flex justify-end p-3">
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open"
                class="flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700">
                Export Excel
                <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>

            <div x-show="open" @click.outside="open = false" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute right-0 z-50 w-48 mt-2 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                <div class="py-1">
                    <button wire:click='exportAll'
                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                        Export Semua
                    </button>
                    <button wire:click="openDateModal"
                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                        Export berdasarkan tanggal
                    </button>
                </div>
            </div>
        </div>
    </div>

    @if ($showDateModal)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto outline-none focus:outline-none">
            <div class="relative w-auto max-w-3xl mx-auto my-6">
                <div
                    class="relative flex flex-col w-full bg-white border-0 rounded-lg shadow-lg outline-none focus:outline-none">
                    <div
                        class="flex items-start justify-between p-5 border-b border-solid rounded-t border-blueGray-200">
                        <h3 class="text-3xl font-semibold">
                            Export by Custom Date Range
                        </h3>
                        <button wire:click="closeDateModal"
                            class="float-right p-1 ml-auto text-3xl font-semibold leading-none text-black bg-transparent border-0 outline-none opacity-5 focus:outline-none">
                            ×
                        </button>
                    </div>
                    <div class="relative flex-auto p-6">
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="startDate">
                                Start Date
                            </label>
                            <input wire:model="startDate" type="date"
                                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline">
                            @error('startDate')
                                <p class="text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="endDate">
                                End Date
                            </label>
                            <input wire:model="endDate" type="date"
                                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline">
                            @error('endDate')
                                <p class="text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="flex items-center justify-end p-6 border-t border-solid rounded-b border-blueGray-200">
                        <button wire:click="closeDateModal"
                            class="px-6 py-2 mb-1 mr-1 text-sm font-bold text-red-500 uppercase outline-none background-transparent focus:outline-none">
                            Close
                        </button>
                        <button wire:click="export"
                            class="px-6 py-3 mb-1 mr-1 text-sm font-bold text-white uppercase bg-green-500 rounded shadow hover:shadow-lg focus:outline-none">
                            Export
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

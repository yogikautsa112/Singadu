<div class="max-w-md p-4 mx-auto my-4 bg-white rounded-lg shadow-sm">
    <form wire:submit.prevent="saveReport" enctype="multipart/form-data">
        <h2 class="mb-4 text-lg font-semibold text-gray-800">Submit Report</h2>

        <!-- Grid Layout -->
        <div class="grid gap-4 md:grid-cols-2">
            <!-- Province Dropdown -->
            <div>
                <label class="block text-xs font-medium text-gray-600">Province</label>
                <select wire:model.live="province"
                    class="block w-full p-1 text-xs border-gray-300 rounded focus:border-indigo-500 focus:ring-indigo-200">
                    <option value="">Select</option>
                    @foreach ($provinces as $prov)
                        <option value="{{ $prov['id'] }}">{{ $prov['name'] }}</option>
                    @endforeach
                </select>
                @error('province')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Regency Dropdown -->
            <div>
                <label class="block text-xs font-medium text-gray-600">Regency</label>
                <select wire:model.live="regency" {{ empty($regencies) ? 'disabled' : '' }}
                    class="block w-full p-1 text-xs border-gray-300 rounded focus:border-indigo-500 focus:ring-indigo-200">
                    <option value="">Select</option>
                    @foreach ($regencies as $reg)
                        <option value="{{ $reg['id'] }}">{{ $reg['name'] }}</option>
                    @endforeach
                </select>
                @error('regency')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Subdistrict & Village -->
        <div class="grid gap-4 mt-2 md:grid-cols-2">
            <div>
                <label class="block text-xs font-medium text-gray-600">Subdistrict</label>
                <select wire:model.live="subdistrict" {{ empty($districts) ? 'disabled' : '' }}
                    class="block w-full p-1 text-xs border-gray-300 rounded focus:border-indigo-500 focus:ring-indigo-200">
                    <option value="">Select</option>
                    @foreach ($districts as $dist)
                        <option value="{{ $dist['id'] }}">{{ $dist['name'] }}</option>
                    @endforeach
                </select>
                @error('subdistrict')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600">Village</label>
                <select wire:model.live="village" {{ empty($villages) ? 'disabled' : '' }}
                    class="block w-full p-1 text-xs border-gray-300 rounded focus:border-indigo-500 focus:ring-indigo-200">
                    <option value="">Select</option>
                    @foreach ($villages as $vill)
                        <option value="{{ $vill['id'] }}">{{ $vill['name'] }}</option>
                    @endforeach
                </select>
                @error('village')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Report Type -->
        <div class="mt-2">
            <label class="block text-xs font-medium text-gray-600">Report Type</label>
            <select wire:model="type"
                class="block w-full p-1 text-xs border-gray-300 rounded focus:border-indigo-500 focus:ring-indigo-200">
                <option value="">Select Type</option>
                @foreach ($reportTypes as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>
            @error('type')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Description -->
        <div class="mt-2">
            <label class="block text-xs font-medium text-gray-600">Description</label>
            <textarea wire:model="description" rows="2"
                class="block w-full p-1 text-xs border-gray-300 rounded focus:border-indigo-500 focus:ring-indigo-200"
                placeholder="Report details..."></textarea>
            @error('description')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Image Upload -->
        <div class="mt-2">
            <label for="image" class="block text-xs font-medium text-gray-600">Upload Image</label>
            <input type="file" wire:model="image" id="image" accept="image/*"
                class="block w-full p-1 text-xs border-gray-300 rounded focus:border-indigo-500 focus:ring-indigo-200" />
            @error('image')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Statement -->
        <div class="flex items-center mt-2">
            <input type="checkbox" wire:model="statement" id="statement"
                class="mr-2 text-indigo-500 focus:ring-indigo-200">
            <label for="statement" class="text-xs text-gray-600">I confirm the accuracy of this report</label>
        </div>
        @error('statement')
            <span class="text-xs text-red-500">{{ $message }}</span>
        @enderror

        <!-- Submit Button -->
        <div class="mt-4">
            <button type="submit"
                class="w-full py-2 text-xs font-medium text-white bg-indigo-600 rounded hover:bg-indigo-700 focus:outline-none">
                <span wire:loading.remove>Submit</span>
                <span wire:loading class="inline-flex items-center justify-center">
                    <svg class="w-5 h-5 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 1116 0A8 8 0 014 12z"></path>
                    </svg>
                </span>
            </button>
        </div>
    </form>
</div>

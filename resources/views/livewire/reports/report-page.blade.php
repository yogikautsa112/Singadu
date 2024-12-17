<div>
    @if (session()->has('success') || session()->has('error'))
        <div x-data="{ showToast: true }" x-show="showToast" x-init="setTimeout(() => showToast = false, 5000)"
            class="absolute z-50 toast toast-top toast-end">
            <div class="alert"
                :class="{ 'bg-gray-800 text-white': @js(session()->has('success')), 'bg-gray-600 text-white': @js(session()->has('error')) }">
                <span>{{ session('success') ?? session('error') }}</span>
                <button @click="showToast = false" class="ml-4 text-gray-300 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    @endif
    <livewire:reports.article-reports>
</div>

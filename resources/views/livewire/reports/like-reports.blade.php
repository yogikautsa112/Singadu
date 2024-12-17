<div>
    <!-- Like Button -->
    <button wire:click="toggleLike"
        class="p-2 text-xs font-medium text-gray-600 bg-transparent border-2 border-gray-300 rounded-lg hover:bg-indigo-100">
        <!-- Conditionally change the SVG icon based on the $liked property -->
        @if ($liked)
            <!-- Filled heart (liked) -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-red-700">
                <path fill-rule="evenodd"
                    d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"
                    clip-rule="evenodd" />
            </svg>
        @else
            <!-- Outline heart (unliked) -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" class="w-5 h-5 text-gray-600">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
            </svg>
        @endif
    </button>
    <!-- Display Like Count -->
    <span class="ml-1 text-sm font-bold text-gray-600">{{ count($report->voting) }} Vote</span>
</div>

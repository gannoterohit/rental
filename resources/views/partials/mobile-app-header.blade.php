<div class="mobile-app-header lg:hidden bg-white sticky top-0 z-[999] px-4 py-3 flex items-center justify-between border-b border-gray-100 shadow-sm">
    <!-- Left: Placeholder for balance or hamburger (Empty for now to center logo) -->
    <div class="w-10">
        <!-- Optional: Back button if not on home? -->
        @if(!request()->routeIs('rooms.index'))
            <a href="{{ route('rooms.index') }}" class="text-gray-600">
                <i class="fas fa-arrow-left text-lg"></i>
            </a>
        @endif
    </div>

    <!-- Center: Brand Logo -->
    <div class="flex-1 text-center">
        <h1 class="text-xl font-black tracking-tighter text-gray-900 uppercase font-sans">
            ROOM<span class="text-red-600">RENTAL</span>
        </h1>
    </div>

    <!-- Right: Support / Help -->
    <div class="w-10 flex justify-end">
        <a href="{{ route('pages.contact') }}" class="text-gray-600">
            <i class="fas fa-headset text-xl"></i>
        </a>
    </div>
</div>

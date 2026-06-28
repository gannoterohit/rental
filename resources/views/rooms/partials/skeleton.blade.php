<div class="space-y-4 md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-6 md:space-y-0">
    @for($i = 0; $i < 3; $i++)
    <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100">
        <div class="skeleton skeleton-image w-full"></div>
        <div class="p-4 space-y-3">
            <div class="skeleton skeleton-text w-3/4"></div>
            <div class="skeleton skeleton-text w-1/2"></div>
            <div class="flex justify-between items-center pt-2">
                <div class="skeleton skeleton-text w-24"></div>
                <div class="skeleton skeleton-text w-20"></div>
            </div>
        </div>
    </div>
    @endfor
</div>

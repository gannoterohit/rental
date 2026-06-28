<!-- Mobile App Loading Indicator -->
<div id="mobile-loading" class="lg:hidden fixed inset-0 bg-white z-[3000] flex items-center justify-center transition-opacity duration-300" style="display: none;">
    <div class="text-center">
        <div class="app-spinner mx-auto mb-4"></div>
        <p class="text-indigo-600 font-semibold">Loading...</p>
    </div>
</div>

<script>
    // Show loading on page transitions
    document.addEventListener('DOMContentLoaded', function() {
        const loading = document.getElementById('mobile-loading');
        
        // Show loading when clicking links, but only on mobile
        document.addEventListener('click', function(e) {
            // Check if we are on a desktop screen
            if (window.innerWidth >= 1024) return;
            
            const target = e.target.closest('a');
            if (target && target.href && target.href.indexOf(window.location.hostname) >= 0) {
                loading.style.display = 'flex';
                setTimeout(() => {
                    loading.style.display = 'none';
                }, 5000); // Hide after 5 seconds max
            }
        });
        
        // Hide loading when page is fully loaded
        window.addEventListener('load', function() {
            loading.style.display = 'none';
        });
    });
</script>
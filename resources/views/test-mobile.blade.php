<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Mobile App Test</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="{{ asset('css/mobile-app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
</head>
<body class="mobile-app-view">
    <div class="mobile-app-container">
        <!-- Mobile Status Bar -->
        <div class="mobile-status-bar">
            <div class="status-time">9:41</div>
            <div class="status-icons">
                <i class="fas fa-signal"></i>
                <i class="fas fa-wifi"></i>
                <i class="fas fa-battery-full"></i>
            </div>
        </div>
        
        <!-- Mobile App Header -->
        <div class="mobile-app-header">
            <div class="header-left">
                <div class="app-icon">
                    <i class="fas fa-home text-white text-xl"></i>
                </div>
                <div class="header-content">
                    <h1 class="text-lg font-bold text-gray-900 leading-none">RoomRental</h1>
                    <p class="text-[10px] text-gray-600 font-medium">Find your stay</p>
                </div>
            </div>
            <div class="header-right">
                <button class="menu-toggle">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
        
        <!-- Mobile Search -->
        @include('partials.mobile-search')
        
        <!-- Test Content -->
        <div class="p-4">
            <h2 class="app-section-title">Test Mobile Components</h2>
            <p class="app-section-subtitle">This page tests all mobile app components</p>
            
            <!-- Test App Card -->
            <div class="app-card mt-4">
                <div class="card-image">
                    <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80"
                         alt="Test room"
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    <div class="absolute top-4 left-4 right-4 flex items-center gap-2">
                        <span class="app-badge app-badge-verified">
                            <i class="fas fa-check-circle mr-1"></i>Verified
                        </span>
                        <span class="app-badge app-badge-featured">
                            <i class="fas fa-star mr-1"></i>Featured
                        </span>
                    </div>
                </div>
                <div class="card-content">
                    <h3 class="card-title">Test Room Listing</h3>
                    <p class="card-subtitle">Beautiful room in prime location</p>
                    <div class="card-price">₹12,000 /mo</div>
                    <button class="app-btn app-btn-primary mt-3">
                        <i class="fas fa-eye mr-2"></i>View Details
                    </button>
                </div>
            </div>
            
            <!-- Test App Button -->
            <div class="mt-4 space-y-2">
                <button class="app-btn app-btn-primary w-full">
                    <i class="fas fa-plus mr-2"></i>Primary Button
                </button>
                <button class="app-btn app-btn-secondary w-full">
                    <i class="fas fa-filter mr-2"></i>Secondary Button
                </button>
            </div>
            
            <!-- Test App Input -->
            <div class="mt-4">
                <input type="text" placeholder="Test input" class="app-input">
            </div>
            
            <!-- Test App Grid -->
            <div class="mt-4">
                <h3 class="app-section-title">Grid Test</h3>
                <div class="app-grid">
                    <div class="app-card">
                        <div class="card-content">
                            <h4 class="card-title text-center">Item 1</h4>
                        </div>
                    </div>
                    <div class="app-card">
                        <div class="card-content">
                            <h4 class="card-title text-center">Item 2</h4>
                        </div>
                    </div>
                    <div class="app-card">
                        <div class="card-content">
                            <h4 class="card-title text-center">Item 3</h4>
                        </div>
                    </div>
                    <div class="app-card">
                        <div class="card-content">
                            <h4 class="card-title text-center">Item 4</h4>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Test App List -->
            <div class="mt-4">
                <h3 class="app-section-title">List Test</h3>
                <ul class="app-list">
                    <li class="app-list-item">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span>List item 1</span>
                        </div>
                    </li>
                    <li class="app-list-item">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span>List item 2</span>
                        </div>
                    </li>
                    <li class="app-list-item">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span>List item 3</span>
                        </div>
                    </li>
                </ul>
            </div>
            
            <!-- Test App Badges -->
            <div class="mt-4 flex gap-2 flex-wrap">
                <span class="app-badge app-badge-verified">Verified</span>
                <span class="app-badge app-badge-featured">Featured</span>
                <span class="app-badge app-badge-new">New</span>
            </div>
            
            <!-- Test App Empty State -->
            <div class="mt-6 app-empty">
                <i class="fas fa-home"></i>
                <h3>No Results Found</h3>
                <p>Try adjusting your search criteria</p>
                <button class="app-btn app-btn-primary">
                    <i class="fas fa-redo mr-2"></i>Try Again
                </button>
            </div>
        </div>
        
        <!-- Mobile App Menu -->
        @include('partials.mobile-app-menu')
        
        <!-- Bottom Navigation -->
        <div class="bottom-nav">
            <a href="#" class="bottom-nav-item active">
                <i class="fas fa-search"></i>
                <span>Explore</span>
            </a>
            <a href="#" class="bottom-nav-item">
                <i class="fas fa-heart"></i>
                <span>Saved</span>
            </a>
            <a href="#" class="bottom-nav-item">
                <i class="fas fa-newspaper"></i>
                <span>Blog</span>
            </a>
            <a href="#" class="bottom-nav-item">
                <i class="fas fa-user-circle"></i>
                <span>Account</span>
            </a>
        </div>
        
        <!-- Floating Action Button -->
        <button class="app-fab">
            <i class="fas fa-plus"></i>
        </button>
    </div>
</body>
</html>
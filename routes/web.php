<?php

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\UnlockController;
use App\Http\Controllers\Admin\BusinessSettingsController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\RejectionReasonController;
use App\Http\Controllers\Admin\RoomOptionController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class,'index'])->name('home');
Route::get('/set-city', [RoomController::class, 'setCity'])->name('set-city');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');

// Referral Tracking
Route::get('/ref/{code}', [\App\Http\Controllers\ReferralController::class, 'track'])->name('referral.track');


Route::get('/dashboard', function () {
    $user = auth()->user();
    
    // Redirect based on role
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'owner') {
        return redirect()->route('owner.dashboard');
    } else {
        // Regular user dashboard
        return view('dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Owner-specific room routes (must be before /rooms/{room} route)
Route::middleware(['auth', 'role:owner'])->group(function () {
    Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
    Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
    Route::get('/rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
    Route::put('/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
    Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');
    Route::post('/rooms/{room}/featured', [RoomController::class, 'makeFeatured'])->name('rooms.featured');
    Route::post('/rooms/{room}/booked', [RoomController::class, 'markBooked'])->name('rooms.markBooked');
    Route::post('/rooms/{room}/available', [RoomController::class, 'markAvailable'])->name('rooms.markAvailable');
});

// Public room browsing
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');

Route::post('/unlock/{room}', [UnlockController::class, 'unlock'])->name('unlock.contact');

// Blog Routes
Route::get('/blog', [\App\Http\Controllers\BlogController::class, 'index'])->name('blogs.index');
Route::get('/blog/{slug}', [\App\Http\Controllers\BlogController::class, 'show'])->name('blogs.show');
Route::post('/newsletter/subscribe', [\App\Http\Controllers\SubscriberController::class, 'store'])->middleware('throttle:public_form')->name('newsletter.subscribe');

// Static Pages
Route::controller(\App\Http\Controllers\PageController::class)->group(function () {
    Route::get('/about-us', 'about')->name('pages.about');
    Route::get('/careers', 'careers')->name('pages.careers');
    Route::get('/how-it-works', 'howItWorks')->name('pages.how-it-works');
    Route::get('/safety-tips', 'safetyTips')->name('pages.safety-tips');
    Route::get('/terms-and-conditions', 'terms')->name('pages.terms');
    Route::get('/privacy-policy', 'privacy')->name('pages.privacy');
    Route::get('/condition-policy', 'condition')->name('pages.condition');
    Route::get('/contact-us', 'contact')->name('pages.contact');
    Route::get('/faq', 'faq')->name('pages.faq');
});
Route::post('/contact-us', [\App\Http\Controllers\ContactController::class, 'store'])->middleware('throttle:public_form')->name('pages.contact.store');

// Public Payment Verification (Must be outside auth middleware for callbacks)
Route::post('/payment/razorpay/verify', [RazorpayController::class,'verifyPayment'])->middleware('throttle:10,1')->name('razorpay.verify');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/otp-delete', [ProfileController::class, 'sendDeleteOtp'])->name('profile.send-delete-otp');
    
    
    // Payment routes
    Route::post('/payment/razorpay/order', [RazorpayController::class,'createOrder'])->middleware('throttle:10,1')->name('razorpay.createOrder');
    
    // Other routes
    Route::post('/book-room', [BookingController::class,'store'])->middleware('throttle:5,1')->name('book.room');
    Route::get('/plans', [PlanController::class,'index'])->name('plans');
    Route::post('/subscription/purchase', [\App\Http\Controllers\SubscriptionController::class, 'store'])->name('subscription.purchase');
    Route::post('/subscribe', [SubscriptionController::class,'store'])->name('subscribe');
    
    // Referral Dashboard
    Route::get('/refer-and-earn', [\App\Http\Controllers\ReferralController::class, 'index'])->name('referral.index');

    // Wishlist Routes
    Route::get('/wishlist', [App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{roomId}', [App\Http\Controllers\WishlistController::class, 'toggle'])->name('wishlist.toggle');


    // City Alerts
    Route::post('/city-alerts', [App\Http\Controllers\CityAlertController::class, 'store'])->name('city-alerts.store');
    Route::delete('/city-alerts/{alert}', [App\Http\Controllers\CityAlertController::class, 'destroy'])->name('city-alerts.destroy');

    // Wallet
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet');
    Route::post('/wallet/convert', [WalletController::class, 'convertPoints'])->name('wallet.convert');
});


Route::post('/webhook/razorpay', [RazorpayController::class,'webhook'])->name('razorpay.webhook');

Route::middleware(['auth','role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Blog Management
    Route::resource('blogs', \App\Http\Controllers\Admin\BlogController::class);

    Route::get('/settings', [BusinessSettingsController::class, 'index'])->name('settings');
    Route::get('/home-page', [\App\Http\Controllers\Admin\HomePageController::class, 'index'])->name('home-page.index');
    Route::put('/home-page', [\App\Http\Controllers\Admin\HomePageController::class, 'update'])->name('home-page.update');
    Route::post('/settings', [BusinessSettingsController::class, 'update'])->name('settings.update');
    Route::post('/settings/store', [BusinessSettingsController::class, 'store'])->name('settings.store');
    Route::post('/settings/ping', [BusinessSettingsController::class, 'pingSearchEngines'])->name('settings.ping');
    Route::resource('room-options', RoomOptionController::class)->except(['show']);
    Route::patch('room-options/{roomOption}/toggle-status', [RoomOptionController::class, 'toggleStatus'])->name('room-options.toggle-status');
    Route::resource('plans', PlanController::class);
    Route::post('/plans/{plan}/toggle-active', [PlanController::class, 'toggleActive'])->name('plans.toggleActive');
    
    // Offers Management
    Route::resource('offers', \App\Http\Controllers\Admin\OfferController::class);
    Route::post('/offers/{offer}/toggle-active', [\App\Http\Controllers\Admin\OfferController::class, 'toggleActive'])->name('offers.toggleActive');
    
    // Users Management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{user}', [AdminController::class, 'userDetail'])->name('users.detail');
    Route::post('/users/{user}/toggle-block', [AdminController::class, 'toggleBlock'])->name('users.toggleBlock');
    
    // Owners Management
    Route::get('/owners', [AdminController::class, 'owners'])->name('owners');
    Route::get('/owners/create', [AdminController::class, 'createOwner'])->name('owners.create');
    Route::post('/owners', [AdminController::class, 'storeOwner'])->name('owners.store');
    Route::get('/owners/{owner}', [AdminController::class, 'ownerDetail'])->name('owners.detail');
    Route::post('/owners/{user}/toggle-block', [AdminController::class, 'toggleBlock'])->name('owners.toggleBlock');

    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::get('/all-rooms', [AdminController::class, 'Rooms'])->name('all-rooms');
    Route::get('/payments-index', [AdminController::class, 'paymentsindex'])->name('payments.index');
    
    // Payout Management
    Route::get('/payouts', [AdminController::class, 'payouts'])->name('payouts');
    Route::post('/payouts/{id}/process', [AdminController::class, 'processPayout'])->name('payouts.process');
    

    // City Alerts Management
    Route::get('/city-alerts', [AdminController::class, 'cityAlerts'])->name('city-alerts.index');
    Route::delete('/city-alerts/{alert}', [AdminController::class, 'deleteCityAlert'])->name('city-alerts.destroy');

    // Newsletter Subscribers
    Route::get('/subscribers', [\App\Http\Controllers\Admin\SubscriberController::class, 'index'])->name('subscribers.index');
    Route::delete('/subscribers/{subscriber}', [\App\Http\Controllers\Admin\SubscriberController::class, 'destroy'])->name('subscribers.destroy');

    // Contact Messages
    Route::get('/contact-messages', [AdminController::class, 'contactMessages'])->name('contact-messages.index');
    Route::post('/contact-messages/{id}/read', [AdminController::class, 'markMessageAsRead'])->name('contact-messages.read');
    Route::delete('/contact-messages/{id}', [AdminController::class, 'deleteContactMessage'])->name('contact-messages.destroy');


Route::get('rejection-reasons', [RejectionReasonController::class, 'index'])->name('rejection-reasons.index');
Route::post('rejection-reasons', [RejectionReasonController::class, 'store'])->name('rejection-reasons.store');
Route::put('rejection-reasons/{rejectionReason}', [RejectionReasonController::class, 'update'])->name('rejection-reasons.update');
Route::delete('rejection-reasons/{rejectionReason}', [RejectionReasonController::class, 'destroy'])->name('rejection-reasons.destroy');

    Route::get('rooms', [AdminController::class, 'Rooms'])->name('rooms.list');
Route::get('rooms/create', [AdminController::class, 'createRoom'])->name('rooms.create');
Route::post('rooms/store', [AdminController::class, 'storeRoom'])->name('rooms.store');
Route::get('rooms/{room}', [AdminController::class, 'showRoom'])->name('rooms.show');
Route::get('rooms/{room}/edit', [AdminController::class, 'editRoom'])->name('rooms.edit');
Route::put('rooms/{room}/update', [AdminController::class, 'updateRoom'])->name('rooms.update');
Route::post('rooms/{room}/approve', [AdminController::class, 'approveRoom'])->name('rooms.approve');
Route::post('rooms/{room}/reject', [AdminController::class, 'rejectRoom'])->name('rooms.reject');
Route::delete('rooms/{room}', [AdminController::class, 'deleteRoom'])->name('rooms.destroy');

    // Search Analytics
    Route::get('/analytics', [\App\Http\Controllers\Admin\SearchAnalyticsController::class, 'index'])->name('analytics');


Route::controller(PagesController::class)->group(function () {
    Route::post('/pages/upload-image', 'uploadImage')->name('pages.upload-image');
    Route::get('/pages/about', 'about')->name('pages.about');
    Route::put('/pages/about', 'updateAbout')->name('pages.about.update');
    Route::get('/pages/careers', 'careers')->name('pages.careers');
    Route::put('/pages/careers', 'updateCareers')->name('pages.careers.update');
    Route::get('/pages/how-it-works', 'howItWorks')->name('pages.how-it-works');
    Route::put('/pages/how-it-works', 'updateHowItWorks')->name('pages.how-it-works.update');
    Route::get('/pages/safety-tips', 'safetyTips')->name('pages.safety-tips');
    Route::put('/pages/safety-tips', 'updateSafetyTips')->name('pages.safety-tips.update');

    Route::get('/pages/terms', 'terms')->name('pages.terms');
    Route::put('/pages/terms', 'updateTerms')->name('pages.terms.update');

    Route::get('/pages/condition', 'condition')->name('pages.condition');
    Route::put('/pages/condition', 'updateCondition')->name('pages.condition.update');

    Route::get('/pages/privacy', 'privacy')->name('pages.privacy');
    Route::put('/pages/privacy', 'updatePrivacy')->name('pages.privacy.update');

    Route::get('/pages/contact', 'contact')->name('pages.contact');
    Route::put('/pages/contact', 'updateContact')->name('pages.contact.update');

    Route::get('/pages/faq', 'faq')->name('pages.faq');
    Route::put('/pages/faq', 'updateFaq')->name('pages.faq.update');
});
});

Route::middleware(['auth', 'role:owner'])->prefix('owner')->group(function () {
    Route::get('/dashboard', [OwnerController::class, 'dashboard'])->name('owner.dashboard');
});






require __DIR__.'/auth.php';

// YouTube Proxy Route
Route::get('/youtube-proxy/{videoId}', function ($videoId) {
    $thumbnailUrl = "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg";
    
    // Fetch the thumbnail from YouTube
    $response = Http::get($thumbnailUrl);
    
    if ($response->successful()) {
        return response($response->body())
            ->header('Content-Type', $response->header('Content-Type'))
            ->header('Cache-Control', 'public, max-age=31536000');
    } else {
        abort(404, 'YouTube thumbnail not found');
    }
})->name('youtube.proxy');

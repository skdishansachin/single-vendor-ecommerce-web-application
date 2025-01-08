<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CollectionPageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\InternalAuthenticatedSessionController;
use App\Http\Controllers\InternalProfileController;
use App\Http\Controllers\InternalRegisterNewUserController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderRefund;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductPageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserOrderController;
use Illuminate\Support\Facades\Route;

route::middleware('role:customer')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::put('/cart', [CartController::class, 'update'])->name('cart.update');
    // TODO - Rethink about the route binding
    Route::delete('/cart/product', [CartController::class, 'destroy'])->name('cart.destroy');

    Route::get('/orders', UserOrderController::class)->name('orders');

    Route::post('/checkout', [CheckoutController::class, 'handleCheckout'])->name('checkout');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');
    Route::get('/checkout/error', [CheckoutController::class, 'error'])->name('checkout.error');
});

// NOTE - This route is for the webhook to work
Route::post('/stripe/webhook', StripeWebhookController::class)->name('stripe.webhook');

Route::get('/', HomePageController::class)->name('index'); // TODO: Better name for the route
Route::get('/products/{product}', ProductPageController::class)->name('products.show');
Route::get('/collections', [CollectionPageController::class, 'index'])->name('collections.index');
Route::get('/collections/{collection}', [CollectionPageController::class, 'show'])->name('collections.show');
Route::get('/search', SearchController::class)->name('search');

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'role:admin|product|order|user|collection']], function () {
    Route::get('/profile', [InternalProfileController::class, 'edit'])->name('dashboard.profile.edit');
    Route::patch('/profile', [InternalProfileController::class, 'update'])->name('dashboard.profile.update');

    Route::get('/', DashboardController::class)->name('dashboard');

    Route::post('/logout', [InternalAuthenticatedSessionController::class, 'destroy'])->name('dashboard.logout');

    Route::resource('products', ProductController::class)->names('dashboard.products');
    Route::resource('collections', CollectionController::class)->names('dashboard.collections');

    Route::get('/users', [UserController::class, 'index'])->name('dashboard.users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('dashboard.users.show');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('dashboard.users.update');

    Route::get('/invitations', [InvitationController::class, 'index'])->name('dashboard.invitations.index');
    Route::get('/invitations/create', [InvitationController::class, 'create'])->name('dashboard.invitations.create');
    Route::post('/invitations', [InvitationController::class, 'store'])->name('dashboard.invitations');
    Route::get('/invitations/{invitation}', [InvitationController::class, 'show'])->name('dashboard.invitations.show');
    Route::put('/invitations/{invitation}/resend', [InvitationController::class, 'resend'])->name('dashboard.invitations.resend');
    Route::put('/invitations/{invitation}/cancel', [InvitationController::class, 'cancel'])->name('dashboard.invitations.cancel');

    Route::get('/orders', [OrderController::class, 'index'])->name('dashboard.orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('dashboard.orders.show');
    Route::put('/orders/{order}', [OrderController::class, 'update'])->name('dashboard.orders.update');

    Route::post('order/{order}/refund', OrderRefund::class)->name('dashboard.orders.refund');

    Route::get('/shipping', [ShippingController::class, 'index'])->name('dashboard.shippings.index');
    Route::get('/shipping/create', [ShippingController::class, 'create'])->name('dashboard.shippings.create');
    Route::post('/shipping', [ShippingController::class, 'store'])->name('dashboard.shippings.store');
    Route::get('/shipping/{shipping}/edit', [ShippingController::class, 'edit'])->name('dashboard.shippings.edit');
    Route::put('/shipping/{shipping}', [ShippingController::class, 'update'])->name('dashboard.shippings.update');

    Route::get('/notifications', NotificationController::class)->name('dashboard.notifications');
});

Route::group(['prefix' => 'dashboard', 'middleware' => 'guest'], function () {
    Route::get('/login', [InternalAuthenticatedSessionController::class, 'index'])->name('dashboard.login');
    Route::post('/login', [InternalAuthenticatedSessionController::class, 'store']);

    Route::get('/register/{token}', [InternalRegisterNewUserController::class, 'index'])
        ->middleware('signed')
        ->name('dashboard.register');
    Route::post('/register', [InternalRegisterNewUserController::class, 'store'])->name('dashboard.register.store');

    Route::view('/forgot-password', 'dashboard.auth.forgot-password');
});

require __DIR__.'/auth.php';

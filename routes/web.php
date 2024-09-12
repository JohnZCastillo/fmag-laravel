<?php

use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController as UserNotification;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\User\AccountController as UserAccountController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\PasswordController;
use App\Http\Controllers\User\UserAddressController;
use App\Http\Middleware\ProfileComplete;
use App\Http\Middleware\VerifiedUser;
use App\Mail\MyTestEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

//PUBLIC ROUTES
Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index']);
Route::get('/shop', [ShopController::class, 'index']);

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'viewRegisterPage']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/mail', function () {
    Mail::to('johnzunigacastillo@gmail.com')->send(new MyTestEmail());
});

Route::get('/verify', [AuthController::class, 'verifyPage']);
Route::post('/verify', [AuthController::class, 'verifyCode']);

Route::get('/complete-profile', [AuthController::class, 'completeProfilePage']);
Route::post('/complete-profile', [AuthController::class, 'completeProfile']);

Route::middleware(['auth', VerifiedUser::class, ProfileComplete::class])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/profile', [ProfileController::class, 'index']);

    Route::get('/password', [PasswordController::class, 'index']);
    Route::post('/password', [PasswordController::class, 'changePassword']);

    Route::get('/orders', [OrderController::class, 'orders']);
    Route::get('/admin/orders', [AdminOrderController::class, 'orders']);
    Route::get('/admin/sales', [SalesController::class, 'index']);
    Route::get('/order/{id}', [OrderController::class, 'order']);

    Route::post('/order/cart-checkout', [CheckoutController::class, 'cartCheckout']);
    Route::get('/order/checkout/{orderID}', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::post('/order/checkout/{order}', [CheckoutController::class, 'confirmCheckout']);

    Route::get('/payments/gcash/{orderID}', [PaymentController::class, 'index'])->name('gcash');

    Route::get('/cart', [CartController::class, 'index']);

    Route::get('/user/profile', [UserAccountController::class, 'index']);
    Route::post('/profile', [UserAccountController::class, 'update']);
    Route::get('/address', [UserAddressController::class, 'index']);
    Route::get('/new-address', [UserAddressController::class, 'newAddressForm']);
    Route::post('/new-address', [UserAddressController::class, 'registerAddress']);

    Route::get('/notifications', [UserNotification::class, 'index']);

    Route::post('/cart/{cartID}', [CartController::class, 'addCartItem']);
    Route::delete('/cart-item/{item}', [CartItemController::class, 'removeItem']);

    Route::get('/product/{productID}', [ProductController::class, 'viewProduct']);

    Route::get('/admin/products', [ProductController::class, 'index']);
    Route::get('/admin/product/{productID}', [ProductController::class, 'getProduct']);
    Route::patch('/admin/product/{product}', [ProductController::class, 'updateProduct']);
    Route::delete('/admin/product/{productID}', [ProductController::class, 'archiveProduct']);

    Route::get('/messages', [ChatController::class, 'userChat']);

    Route::post('/api/message/admin', [ChatController::class, 'sendToAdmin']);
    Route::get('/api/messages/{userID}', [ChatController::class, 'getMessages']);
    Route::post('/api/messages/{userID}', [ChatController::class, 'addMessage']);

    Route::post('/product/feedback/{productID}', [FeedbackController::class, 'addComment']);
});

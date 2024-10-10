<?php

use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\GeneralSettingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController as UserNotification;
use App\Http\Controllers\Admin\NotificationController as AdminNotification;
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
use App\Http\Controllers\ServiceController as UserServiceController;
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

Route::get('/view-notification-link/{notificationID}', [\App\Http\Controllers\NotificationController::class, 'viewNotification']);
Route::post('/read-all-notifications', [\App\Http\Controllers\NotificationController::class, 'readAllNotification']);
Route::get('/api/unread-notifications', [\App\Http\Controllers\NotificationController::class, 'countUnreadNotifications']);

Route::get('/complete-profile', [AuthController::class, 'completeProfilePage']);
Route::post('/complete-profile', [AuthController::class, 'completeProfile']);

Route::middleware(['auth', VerifiedUser::class, ProfileComplete::class])->group(function () {


    Route::post('/logout', [AuthController::class, 'logout'])
        ->withoutMiddleware(['auth', VerifiedUser::class, ProfileComplete::class]);

    Route::post('/api/cart-item/{cartItem}', [CartController::class, 'updateItemQuantity']);
    Route::get('/api/shipping-fee', [\App\Http\Controllers\ShippingFeeController::class, 'getShippingFee']);

    Route::get('/profile', [ProfileController::class, 'index']);

    Route::get('/services/{service}', [UserServiceController::class, 'index'])
    ->withoutMiddleware(['auth', VerifiedUser::class, ProfileComplete::class]);

    Route::middleware([\App\Http\Middleware\User::class])->group(function () {
        Route::get('/orders', [OrderController::class, 'orders']);
        Route::get('/user/profile', [UserAccountController::class, 'index']);
        Route::get('/password', [PasswordController::class, 'index']);
        Route::get('/address', [UserAddressController::class, 'index']);
        Route::get('/messages', [ChatController::class, 'userChat']);
        Route::get('/notifications', [UserNotification::class, 'index']);
        Route::get('/cart', [CartController::class, 'index']);
    });


    Route::middleware([\App\Http\Middleware\Admin::class])->group(function () {
        Route::get('/admin/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index']);
        Route::get('/admin/sales', [SalesController::class, 'index']);
        Route::get('/admin/products', [ProductController::class, 'index']);
        Route::get('/admin/orders', [AdminOrderController::class, 'orders']);
        Route::get('/admin/orders/{orderID}', [AdminOrderController::class, 'order']);
        Route::get('/admin/product/{productID}', [ProductController::class, 'getProduct']);
        Route::patch('/admin/product/{product}', [ProductController::class, 'updateProduct']);
        Route::delete('/admin/product/{productID}', [ProductController::class, 'archiveProduct']);
        Route::post('/admin/unarchived-product/{productID}', [ProductController::class, 'unarchivedProduct']);

        Route::post('/admin/product', [ProductController::class, 'addProduct']);
        Route::post('/admin/report', [SalesController::class, 'getSalesInRange']);

        Route::get('/admin/general-settings', [GeneralSettingController::class, 'index']);
        Route::post('/admin/general-settings', [GeneralSettingController::class, 'update']);

        Route::get('/admin/notifications', [AdminNotification::class, 'index']);

        Route::get('/admin/services', [ServiceController::class, 'index']);
        Route::post('/admin/services', [ServiceController::class, 'add']);
        Route::patch('/admin/services', [ServiceController::class, 'update']);
        Route::get('/admin/services/{serviceID}', [ServiceController::class, 'getService']);
        Route::delete('/admin/services/{serviceID}', [ServiceController::class, 'archived']);

        Route::delete('/admin/inquiries/{serviceInquiry}', [InquiryController::class, 'viewInquiry']);

        Route::get('/admin/inquiries', [InquiryController::class, 'index']);
        Route::get('/admin/messages', [\App\Http\Controllers\Admin\ChatController::class, 'index']);
        Route::get('/admin/messages/{userID}', [\App\Http\Controllers\Admin\ChatController::class, 'userChat']);

        Route::post('/admin/order/delivery', [\App\Http\Controllers\DeliveryController::class, 'updateDelivery']);

        Route::get('/admin/api/messages/{userID}', [\App\Http\Controllers\Admin\ChatController::class, 'messages']);
        Route::post('/admin/api/messages/{userID}', [\App\Http\Controllers\Admin\ChatController::class, 'addMessage']);

    });

    Route::post('/cart', [CartController::class, 'addCartItem']);

    Route::post('/order-cancel/{orderID}', [OrderController::class, 'cancelOrder']);
    Route::post('/inquire/{service}', [InquiryController::class, 'inquire']);

    Route::post('/password', [PasswordController::class, 'changePassword']);


    Route::get('/order/{orderID}', [OrderController::class, 'order']);

    Route::post('/order-complete/{orderID}', [OrderController::class, 'orderComplete']);
    Route::post('/order-failed/{orderID}', [OrderController::class, 'orderFailed']);

    Route::post('/order/product-checkout', [CheckoutController::class, 'productCheckout']);
    Route::post('/order/cart-checkout', [CheckoutController::class, 'cartCheckout']);
    Route::get('/order/checkout/{orderID}', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::post('/order/checkout/{order}', [CheckoutController::class, 'confirmCheckout']);

    Route::get('/payments/gcash/{orderID}', [PaymentController::class, 'index'])->name('gcash');
    Route::post('/payments/gcash/{order}', [PaymentController::class, 'confirm']);


    Route::post('/profile', [UserAccountController::class, 'update']);
    Route::get('/new-address', [UserAddressController::class, 'newAddressForm']);
    Route::post('/new-address', [UserAddressController::class, 'registerAddress']);
    Route::post('/default-address/{userAddress}', [UserAddressController::class, 'setDefaultAddress']);


    Route::delete('/cart-item/{item}', [CartItemController::class, 'removeItem']);

    Route::get('/product/{productID}', [ProductController::class, 'viewProduct'])
        ->withoutMiddleware(['auth', VerifiedUser::class, ProfileComplete::class]);


    Route::post('/api/message/admin', [ChatController::class, 'sendToAdmin']);
    Route::get('/api/messages/{userID}', [ChatController::class, 'getMessages']);
    Route::post('/api/messages/{userID}', [ChatController::class, 'addMessage']);

    Route::post('/product/feedback/{productID}', [FeedbackController::class, 'addComment']);


    Route::get('/api/regions', function () {
        $regions = \App\Models\Address\Region::select(['region_name', 'region_code'])
            ->get();

        return response()->json($regions);
    });

    Route::get('/api/provinces/{region}', function ($region) {

        $provinces = \App\Models\Address\Province::select(['province_name', 'province_code'])
            ->where('region_code', $region)
            ->get();

        return response()->json($provinces);
    });

    Route::get('/api/cities/{province}', function ($province) {

        $cities = \App\Models\Address\City::select(['city_name', 'city_code'])
            ->where('province_code', $province)
            ->get();

        return response()->json($cities);
    });

    Route::get('/api/barangays/{city}', function ($city) {

        try {
            $barangays = \App\Models\Address\Barangay::select(['brgy_name', 'brgy_code'])
                ->where('city_code', $city)
                ->get();

            return response()->json($barangays);


        }catch (Exception $e){
            return response()->json(['message' => $e->getMessage()]);
        }
    });
});

Route::get('/forgot-password', [
    \App\Http\Controllers\ForgotPasswordController::class,
    'index'
]);

Route::post('/forgot-password', [
    \App\Http\Controllers\ForgotPasswordController::class,
    'sendPin'
]);

Route::post('/verify-pin', [
    \App\Http\Controllers\ForgotPasswordController::class,
    'verifyPin'
]);


Route::get('/report', function (Illuminate\Http\Request $request){

    $reportData = session('reportData', [
        'items' => [],
        'total' => 0,
        'coverage' => 'All'
    ]);

    return view('admin.report-download', $reportData)->render();
});

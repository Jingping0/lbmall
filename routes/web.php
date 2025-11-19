<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\PusherController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\WishListController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductItemController;
use App\Http\Controllers\CustomerServiceController;
use App\Http\Controllers\ReturnAndRefundController;

Route::resource('users', UserController::class);
Route::resource('customers', CustomerController::class);
Route::resource('address', AddressController::class);
Route::resource('delivery', DeliveryController::class);

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/about_us', function () {
    return view('about_us');
})->name('about_us');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/profile_home', function () {
    return view('profile_home');
})->name('profile_home')->middleware('auth');

Route::get('/customers/customerProfile', function () {
    return view('customers.customerProfile');
})->name('customersProfile');

Route::get('/product/bed_category', function () {
    return view('product.bed_category');
})->name('bed_category');

Route::get('/product/table_category', function () {
    return view('product.table_category');
})->name('table_category');



//login & register & logout & forget password & reset Password
Route::get('/login', [UserController::class,'login'])->name('login');
Route::post('/login', [UserController::class,'loginPost'])->name('login.post');
Route::get('/registration', [UserController::class,'registration'])->name('registration');
Route::post('/registration', [UserController::class,'registrationPost'])->name('registration.post');
Route::get('/logout',[UserController::class,'logout'])->name('logout');
Route::get('/forget-password', [UserController::class,'forgetPassword'])->name('forget.password');
Route::post('/forget-password', [UserController::class,'forgetPasswordPost'])->name('forget.password.post');
Route::get('/reset-password/{token}', [UserController::class,'resetPassword'])->name('reset.password');
Route::post('/reset-password', [UserController::class,'resetPasswordPost'])->name('reset.password.post');

//User Module   
Route::get('/customerProfile', [CustomerController::class, 'customerProfile'])->name('customerProfile')->middleware('auth');
Route::get('/customerProfileEdit', [CustomerController::class, 'customerProfileEdit'])->name('customerProfileEdit')->middleware('auth');
Route::post('/customerProfileEdit', [CustomerController::class, 'customerProfileEditPost'])->name('customerProfileEdit.post')->middleware('auth');
Route::get('/auth/changeCustPassword', [CustomerController::class, 'changeCustPassword'])->name('changeCustPassword')->middleware('auth');
Route::post('/auth/changeCustPassword', [CustomerController::class, 'changeCustPasswordPost'])->name('changeCustPasswordPost')->middleware('auth');
Route::get('/customerReport', [CustomerController::class, 'customerReport'])->name('customerReport')->middleware('auth');
Route::get('/profile_home', [CustomerController::class, 'profile_home'])->name('profile.home')->middleware('auth');
Route::get('/auth/deleteAccount',[CustomerController::class,'showDeleteAccount'])->name('deleteAccount')->middleware('auth');
Route::post('/auth/deleteAccount/{id}', [CustomerController::class, 'deleteAccount'])->name('deleteAccount.post')->middleware('auth');

////////////////////////////////////Admin User Part//////////////////////////////////////
Route::get('/userList',[UserController::class,'showUserList'])->name('admin.showUserList');
Route::get('/createUser',[UserController::class,'createUser'])->name('admin.createUser');
Route::post('/createUser',[UserController::class,'createUserPost'])->name('admin.createUserPost');
Route::get('/editUser/{user_id}',[UserController::class,'editUser'])->name('admin.editUser');
Route::put('/editUser/{user_id}',[UserController::class,'editUserPost'])->name('admin.editUserPost');
Route::delete('/deleteUser/{user_id}', [UserController::class, 'destroy'])->name('admin.destroyUser');

////////////////////////////////////Admin Customer Part//////////////////////////////////////
Route::get('/customerList',[CustomerController::class,'showCustomerList'])->name('admin.showCustomerList');
Route::get('/createCustomer',[CustomerController::class,'createCustomer'])->name('admin.createCustomer');
Route::post('/createCustomer',[CustomerController::class,'createCustomerPost'])->name('admin.createCustomerPost');
Route::get('/editCustomer/{user_id}',[CustomerController::class,'editCustomer'])->name('admin.editCustomer');
Route::put('/editCustomer/{user_id}',[CustomerController::class,'editCustomerPost'])->name('admin.editCustomerPost');
Route::delete('/deleteCustomer/{user_id}', [CustomerController::class, 'destroy'])->name('admin.destroyCustomer');

////////////////////////////////////Admin Staff Part//////////////////////////////////////
Route::get('/staffProfile', [StaffController::class, 'staffProfile'])->name('staffProfile')->middleware('auth');
Route::get('/staffList',[StaffController::class,'showStaffList'])->name('admin.showStaffList');
Route::get('/createStaff',[StaffController::class,'createStaff'])->name('admin.createStaff');
Route::post('/createStaff',[StaffController::class,'createStaffPost'])->name('admin.createStaffPost');
Route::get('/editStaff/{user_id}',[StaffController::class,'editStaff'])->name('admin.editStaff');
Route::put('/editStaff/{user_id}',[StaffController::class,'editStaffPost'])->name('admin.editStaffPost');
Route::delete('/deleteStaff/{user_id}', [StaffController::class, 'destroy'])->name('admin.destroyStaff');


//////////////////////////////////// Product Module//////////////////////////////////////
Route::get('/product_items', [ProductItemController::class, 'index'])->name('product_items.index');
Route::get('/product/details/{product_item_id}', [ProductItemController::class, 'productDetails'])->name('product.details');

Route::get('/productList', [ProductItemController::class, 'showProductList'])->name('product_items.showProductList');
Route::get('/createProductItem', [ProductItemController::class, 'createProductItem'])->name('product_items.createProductItem');
Route::post('/createProductItem', [ProductItemController::class, 'createProductItemPost'])->name('product_items.createProductItemPost');
Route::get('/editProductItem/{product_item_id}', [ProductItemController::class, 'editProductItem'])->name('product_items.editProductItem');
Route::put('/editProductItem/{product_item_id}', [ProductItemController::class, 'editProductItemPost'])->name('product_items.editProductItemPost');
Route::delete('/{product_item_id}', [ProductItemController::class, 'destroy'])->name('product_items.destroy');

//Cart Module
Route::get('/cart', [CartController::class, 'index'])->name('cart.index')->middleware('auth');
Route::post('/cart/add/{product_item}', [CartController::class, 'addProductItem'])->name('cart.addProductItem');
Route::get('/updateQuantity/{requestedProductItemId}/{action}', [CartController::class, 'updateQuantity'])->name('updateQuantity');
Route::get('/removeCartItem/{requestedProductItemId}', [CartController::class, 'removeCartItem'])->name('removeCartItem');
Route::get('/checkout', [CartController::class, 'toCheckout'])->name('cart.toCheckout')->middleware('auth');


// Route::get('/myPurchase', [OrderController::class, 'getOrderHistory'])->name('getCustomerOrderList')->middleware('auth');
Route::get('/orders', [OrderController::class, 'getCustomerOrderList'])->name('orders.getCustomerOrderList')->middleware('auth');
Route::get('/order/detail/{orderId}', [OrderController::class, 'retrieveOrderDetail'])->name('order.retrieveOrderDetail');
Route::get('/myPurchase', [OrderController::class, 'getStatusOrder'])->name('order.getStatusOrder')->middleware('auth');
Route::post('/myPurchase/{orderId}', [OrderController::class, 'updateOrderStatus'])->name('orders.updateOrderStatus');
Route::post('/placeOrder', [OrderController::class, 'placeOrder'])->name('order.placeOrder');
Route::get('/orderList', [OrderController::class, 'showOrderList'])->name('admin.showOrderList');
Route::get('/editOrder/{order_id}', [OrderController::class, 'editOrder'])->name('admin.editOrder');
Route::put('/editOrder/{order_id}', [OrderController::class, 'editOrderPost'])->name('admin.editOrderPost');
Route::get('/paymentList', [OrderController::class, 'showPaymentList'])->name('admin.showPaymentList');

//////////////////////////////////// Address //////////////////////////////////
Route::get('/address', [AddressController::class, 'index'])->name('address');
Route::put('/address/default/{address}', [AddressController::class, 'setDefault'])->name('address.setDefault');
Route::put('/customers/cusAddress', [AddressController::class, 'getCustomerAddress'])->name('address.cusAddress');
Route::get('/customer/address', [AddressController::class, 'retrieveCustAddress'])->name('address.getCustomerAddress');

Route::get('/admin/address/{address}/edit', [AddressController::class, 'edit'])->name('address.edit');
Route::delete('/deleteAddress/{address_id}', [AddressController::class, 'destroy'])->name('address.destroy');
Route::put('/admin/address/{address}', [AddressController::class, 'staffUpdate'])->name('address.staffUpdate');
Route::get('/delivery/{deliveryId}/status', [AddressController::class,'getDeliveryStatus'])->name('address.getDeliveryStatus');

//////////////////////////////////// Delivery //////////////////////////////////
Route::get('/deliveryList', [DeliveryController::class, 'showDeliveryList'])->name('admin.showDeliveryList');
Route::get('/editDelivery/{delivery_id}', [DeliveryController::class, 'editDelivery'])->name('admin.editDelivery');
Route::put('/editDelivery/{delivery_id}', [DeliveryController::class, 'editDeliveryPost'])->name('admin.editDeliveryPost');
Route::delete('/deleteDelivery/{delivery_id}', [DeliveryController::class, 'destroy'])->name('admin.destroyDelivery');


//////////////////////////////////// Return And Refund //////////////////////////////////
Route::get('/returnAndRefund/{order_id}', [ReturnAndRefundController::class, 'getCustReturnAndRefund'])->name('CustReturnAndRefund');
Route::post('/createRefund', [ReturnAndRefundController::class, 'returnAndRefundPost'])->name('CustReturnAndRefundPost');
Route::get('/returnList', [ReturnAndRefundController::class, 'showReturnList'])->name('admin.showReturnList');
Route::get('/editReturn/{returnAndRefund_id}',[ReturnAndRefundController::class,'editReturn'])->name('admin.editReturn');
Route::put('/editReturn/{returnAndRefund_id}',[ReturnAndRefundController::class,'editReturnPost'])->name('admin.editReturnPost');
Route::delete('/deleteRefund/{returnAndRefund_id}', [ReturnAndRefundController::class, 'destroy'])->name('admin.destroyRefund');


//////////////////////////////////// WishList Product //////////////////////////////////
Route::get('/wishList',[WishListController::class,'getCustomerWishList'])->name('getWishList');
Route::post('/wishList/add/{product_item}', [WishListController::class, 'addWishList'])->name('addWishList');
Route::delete('/removeWishListItem/{productItem}', [WishListController::class, 'removeWishListItem'])->name('removeWishListItem');
Route::post('/wishListtoCart/{product_item}', [WishListController::class, 'addWishToCartItem'])->name('cart.addWishToCartItem');
Route::post('/addAllToCart', [WishListController::class, 'addAllToCart'])->name('addAllToCart');


//////////////////////////////////// Rating Product //////////////////////////////////
Route::get('/ratings/create/{order_id}', [RatingController::class, 'updateRating'])->name('ratings.updateRating');
Route::post('/updateRating/{rating_id}', [RatingController::class, 'updateRatingPost'])->name('ratings.updateRatingPost');
Route::post('/upload', [RatingController::class, 'upload'])->name('upload');


//////////////Paypal///////////////////
Route::post('paypal', [PaypalController::class,'paypal'])->name('paypal');
Route::get('success', [PaypalController::class,'success'])->name('success');
Route::get('cancel', [PaypalController::class,'cancel'])->name('cancel');


///////////////////// Customer Service ///////////////
Route::get('/FAQList',[FAQController::class,'showFAQ'])->name('showFAQ');
Route::post('/createRequest', [CustomerServiceController::class, 'createRequest'])->name('contact.createRequest');
Route::get('/CustomerServiceList',[CustomerServiceController::class,'showCustomerServiceList'])->name('contact.showCustomerServiceList');
Route::get('/editCustomerService/{cust_service_id}', [CustomerServiceController::class, 'editCustomerService'])->name('contact.editCustomerService');
Route::put('/editCustomerService/{cust_service_id}',[CustomerServiceController::class,'editCustomerServicePost'])->name('contact.editCustomerServicePost');


///////////////////// LiveChat ///////////////////////////
Route::get('/',[PusherController::class,'index'])->name('pusher.index');
Route::post('/broadcast',[PusherController::class,'broadcast'])->name('pusher.broadcast');
Route::post('/receive',[PusherController::class,'receive'])->name('pusher.receive');


///////////////////////// Dashboard //////////////////////////////////
Route::get('/admin/dashboard',[DashboardController::class,'index'])->name('dashboard');
Route::get('/salesReport',[OrderController::class,'salesReport'])->name('salesReport');
Route::get('/returnReport',[ReturnAndRefundController::class,'returnReport'])->name('returnReport');
Route::get('/reviewReport',[RatingController::class,'reviewReport'])->name('reviewReport');

Route::group(['middleware' => 'auth'], function(){
    Route::get('/profile',function(){
        return "Hi";
    });
}); //this code is force user to go login or register to authorise them, only authorised user can access to profile page


// Route::get('/admin/dashboard', function () {
//         return view('admin.dashboard');
//     })->name('dashboard');


// Route::get('/product_items/create', [ProductItemController::class, 'create'])->name('product_items.create');
// Route::get('/product_items/{productItem}/edit', [ProductItemController::class, 'edit'])->name('product_items.edit');
// Route::put('/product_items/{productItem}', [ProductItemController::class, 'update'])->name('product_items.update');
// Route::delete('/product_items/{productItem}', [ProductItemController::class, 'destroy'])->name('product_items.destroy');
// Route::get('/product_items/{productItem}', [ProductItemController::class, 'show'])->name('product_items.show');
// Route::get('/staff/product_items', [ProductItemController::class, 'productItemCRUD'])->name('product_items.productItemCRUD');
// Route::get('/menu_item_reports', [ProductItemController::class, 'menuItemReport'])->name('menu_items.menuItemReport');
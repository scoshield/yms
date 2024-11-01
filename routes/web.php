<?php

use App\Http\Controllers\Admin\AppointmentsController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// define('BASE_URL', env('APP_URL'));

Route::redirect('/', env('APP_URL') . '/login');
Route::redirect('/home', env('APP_URL') . '/admin');
Auth::routes(['register' => false]);

// Profile Routes
Route::prefix('profile')->name('profile.')->middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'getProfile'])->name('detail');
    Route::post('/update', [HomeController::class, 'updateProfile'])->name('update');
    Route::post('/change-password', [HomeController::class, 'changePassword'])->name('change-password');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Services
    Route::delete('services/destroy', 'ServicesController@massDestroy')->name('services.massDestroy');
    Route::resource('services', 'ServicesController');

    // Employees
    Route::delete('employees/destroy', 'EmployeesController@massDestroy')->name('employees.massDestroy');
    Route::post('employees/media', 'EmployeesController@storeMedia')->name('employees.storeMedia');
    Route::resource('employees', 'EmployeesController');

    // Clients
    Route::delete('clients/destroy', 'ClientsController@massDestroy')->name('clients.massDestroy');
    Route::resource('clients', 'ClientsController');

    // Appointments
    ///appointments/approve/632667547e7cd3e0466547863e1207a8c0c0c549/da4b9237bacccdf19c0760cab7aec4a8359010b0
    Route::post('appointments/admit', 'AppointmentsController@admit')->name('appointments.admit');
    Route::post('appointments/gateout', 'AppointmentsController@gateout')->name('appointments.gateout');
    Route::post('appointments/approve', 'AppointmentsController@approve')->name('appointments.approve');
    Route::get('appointments/{ref}/approve', 'AppointmentsController@approveAtLevel')->name('appointments.approve_action_url');

    Route::post('appointments/printpass', 'AppointmentsController@printpass')->name('appointments.printpass');
    Route::get('appointments/gateout', [AppointmentsController::class, 'gateoutTruck'])->name('appointment.gateout');
    Route::get('appointments/{appointment}/gatein', [AppointmentsController::class, 'gateinTruck'])->name('appointment.gatein');
    Route::get('appointments/get/{filename}', [AppointmentsController::class, 'downloadFile'])->name('appointments.download');
    Route::delete('appointments/destroy', 'AppointmentsController@massDestroy')->name('appointments.massDestroy');
    Route::resource('appointments', 'AppointmentsController');

    // Loading Bay
    Route::get('loadingbay/{id}/start', 'LoadingBayController@startLoading')->name('loading.start');
    Route::get('loadingbay/{id}/end', 'LoadingBayController@endLoading')->name('loading.end');
    Route::post('loadingbay/start', 'LoadingBayController@start')->name('loadingbay.start');
    Route::post('loadingbay/finish', 'LoadingBayController@finish')->name('loadingbay.finish');
    Route::delete('loadingbay/destroy', 'LoadingBayController@massDestroy')->name('loadingbay.massDestroy');
    Route::resource('loadingbay', 'LoadingBayController');

    // SystemCalendar
    Route::get('system-calendar', 'SystemCalendarController@index')->name('systemCalendar');

    // Department
    Route::delete('departments/destroy', 'DepartmentController@massDestroy')->name('departments.massDestroy');
    Route::post('departments/media', 'DepartmentController@storeMedia')->name('departments.storeMedia');
    Route::resource('departments', 'DepartmentController');

    // Yard
    Route::delete('yards/destroy', 'YardController@massDestroy')->name('yards.massDestroy');
    Route::post('yards/media', 'YardController@storeMedia')->name('yards.storeMedia');
    Route::resource('yards', 'YardController');

    // Hauler
    Route::delete('haulers/destroy', 'HaulerController@massDestroy')->name('haulers.massDestroy');
    Route::post('haulers/media', 'HaulerController@storeMedia')->name('haulers.storeMedia');
    Route::resource('haulers', 'HaulerController');

    // Document
    Route::resource('documents', 'DocumentsController');

    // Inventory items
    Route::delete('inventory_items/destroy', 'InventoryItemController@massDestroy')->name('inventory_items.massDestroy');
    Route::post('inventory_items/media', 'InventoryItemController@storeMedia')->name('inventory_items.storeMedia');
    Route::post('inventory_item/checkout', 'InventoryItemController@checkout')->name('inventory_items.checkout');
    Route::resource('inventory_items', 'InventoryItemController');
});

<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');
Route::redirect('/home', '/admin');
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
    Route::delete('appointments/destroy', 'AppointmentsController@massDestroy')->name('appointments.massDestroy');
    Route::resource('appointments', 'AppointmentsController');

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

    // Inventory items
    Route::delete('inventory_items/destroy', 'InventoryItemController@massDestroy')->name('inventory_items.massDestroy');
    Route::post('inventory_items/media', 'InventoryItemController@storeMedia')->name('inventory_items.storeMedia');
    Route::resource('inventory_items', 'InventoryItemController');
});

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
    Route::delete('department/destroy', 'DepartmentController@massDestroy')->name('department.massDestroy');
    Route::post('department/media', 'DepartmentController@storeMedia')->name('department.storeMedia');
    Route::resource('department', 'DepartmentController');

    // Yard
    Route::delete('yard/destroy', 'YardController@massDestroy')->name('yard.massDestroy');
    Route::post('yard/media', 'YardController@storeMedia')->name('yard.storeMedia');
    Route::resource('yard', 'YardController');

    // Hauler
    Route::delete('hauler/destroy', 'HaulerController@massDestroy')->name('hauler.massDestroy');
    Route::post('hauler/media', 'HaulerController@storeMedia')->name('hauler.storeMedia');
    Route::resource('hauler', 'HaulerController');
});

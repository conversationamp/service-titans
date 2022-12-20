<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthorizationController;
use App\Http\Controllers\CronJobController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SyncSettingsController;
use App\Models\Setting;
use App\Models\SyncSettings;
use App\Models\User;
use Illuminate\Support\Facades\Route;

header('Access-Control-Allow-Origin: *');

// Route::get('/', function () {
//     return view('welcome');
// });
require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::post('/profile-save', [DashboardController::class, 'general'])->name('profile.save');
    Route::post('/password-save', [DashboardController::class, 'password'])->name('password.save');
    Route::prefix('roles')->name('role.')->group(function () {
    });

    Route::prefix('users')->name('user.')->group(function () {
        Route::get('/list', [UserController::class, 'list'])->name('list');
        Route::get('/add', [UserController::class, 'add'])->name('add');
        Route::get('/edit/{id?}', [UserController::class, 'edit'])->name('edit');
        Route::post('/save/{id?}', [UserController::class, 'save'])->name('save');
        Route::get('/delete/{id?}', [UserController::class, 'delete'])->name('delete');
        Route::get('/is-active/{id?}', [UserController::class, 'isActive'])->name('status');
    });

    Route::prefix('authorization')->name('authorization.')->group(function () {
        Route::get('/', [AuthorizationController::class, 'authorization'])->name('index');
        Route::post('/permissions/save', [AuthorizationController::class, 'savePermissions'])->name('permission.save');
        Route::get('/gohighlevel/oauth/callback', [AuthorizationController::class, 'goHighLevelCallback'])->name('gohighlevel.callback');
        Route::get('/service-titans/auth', [AuthorizationController::class, 'serviceTitan'])->name('servicetitan');
        Route::get('/service-titans/oauth/callback', [AuthorizationController::class, 'serviceTitanCallback'])->name('servicetitan.callback');
    });

    Route::prefix('settings')->name('setting.')->group(function () {
        Route::get('/auth', [SettingController::class, 'authSetting'])->name('index');
        Route::get('/general', [SettingController::class, 'generalSetting'])->name('general');
        Route::get('/crm-setting', [SettingController::class, 'crmSetting'])->name('crm');
        Route::get('/titans-setting', [SettingController::class, 'titanSetting'])->name('titan');
        Route::post('/save', [SettingController::class, 'store'])->name('save');
    });

    Route::prefix('sync')->name('sync-settings.')->group(function () {
        Route::get('/list', [SyncSettingsController::class, 'list'])->name('list');
        Route::get('/add', [SyncSettingsController::class, 'add'])->name('add');
        Route::get('/edit/{id?}', [SyncSettingsController::class, 'edit'])->name('edit');
        Route::post('/save/{id?}', [SyncSettingsController::class, 'save'])->name('save');
        Route::get('/delete/{id?}', [SyncSettingsController::class, 'delete'])->name('delete');
        Route::get('/get-data/{id?}', [SyncSettingsController::class, 'getData'])->name('getdata');
        Route::get('/sync-default/{id?}', [SyncSettingsController::class, 'getDefault'])->name('get-default');
        Route::get('/make-default/{id}/{index}', [SyncSettingsController::class, 'makeDefault'])->name('save-default');
    });

    Route::prefix('logs')->middleware('auth')->name('log.')->group(function () {
        Route::get('/contacts', [LogsController::class, 'contactLogs'])->name('contact');
        Route::get('/opportunities', [LogsController::class, 'opportunityLogs'])->name('opportunity');
    });
});

Route::prefix('cron_jobs')->group(function () {
    Route::get('/get-customers', [CronJobController::class, 'init_titan']);
    Route::get('/get-jobs', [CronJobController::class, 'init_titan_jobs']);
    Route::get('/get-projects', [CronJobController::class, 'init_titan_projects']);
    Route::get('/get-invoices', [CronJobController::class, 'init_titan_invoices']);
    Route::get('/get-nonjob-appointments', [CronJobController::class, 'init_nonjob_appointments']);
});

Route::get('/cf', [CronJobController::class, 'customField']);

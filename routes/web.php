<?php

use App\Http\Controllers\AppSettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\GoogleCalendarSettingController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LanguageSettingController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ModuleSettingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileSettingController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SocialAuthSettingController;
use App\Http\Controllers\StorageSettingController;
use App\Http\Controllers\ThemeSettingController;
use App\Http\Controllers\TwoFASettingController;
use Illuminate\Support\Facades\Route;
 
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Socialite routes
Route::get('/redirect/{provider}', [LoginController::class, 'redirect'])->name('social_login');
Route::get('/callback/{provider}', [LoginController::class, 'callback'])->name('social_login_callback');
Route::post('check-email', [LoginController::class, 'checkEmail'])->name('check_email');
Route::post('check-code', [LoginController::class, 'checkCode'])->name('check_code');
Route::get('resend-code', [LoginController::class, 'resendCode'])->name('resend_code');
 
Route::post('setup-account', [RegisterController::class, 'setupAccount'])->name('setup_account');
// Get quill image uploaded
Route::get('quill-image/{image}', [ImageController::class, 'getImage'])->name('image.getImage');
// Cropper Model
Route::get('cropper/{element}', [ImageController::class, 'cropper'])->name('cropper');

/* Account routes starts from here */
 
Route::group(['middleware' => 'auth', 'prefix' => 'account'], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('checklist', [DashboardController::class, 'checklist'])->name('checklist');
    Route::get('dashboard-member', [DashboardController::class, 'memberDashboard'])->name('dashboard.member');
    Route::post('dashboard/widget/{dashboardType}', [DashboardController::class, 'widget'])->name('dashboard.widget');
    Route::get('settings/change-language', [SettingsController::class, 'changeLanguage'])->name('settings.change_language');
    Route::resource('settings', SettingsController::class)->only(['edit', 'update', 'index', 'change_language']);
    /* setting */
    Route::group(['prefix' => 'settings'], function () {
        Route::post('image/upload', [ImageController::class, 'store'])->name('image.store');
        /* app setting */
        Route::post('app-settings/deleteSessions', [AppSettingController::class, 'deleteSessions'])->name('app-settings.delete_sessions');
        Route::resource('app-settings', AppSettingController::class);
        Route::resource('profile-settings', ProfileSettingController::class);

        /* 2FA */
        Route::get('2fa-codes-download', [TwoFASettingController::class, 'download'])->name('2fa_codes_download');
        Route::get('verify-2fa-password', [TwoFASettingController::class, 'verify'])->name('verify_2fa_password');
        Route::get('2fa-confirm', [TwoFASettingController::class, 'showConfirm'])->name('two-fa-settings.validate_confirm');
        Route::post('2fa-confirm', [TwoFASettingController::class, 'confirm'])->name('two-fa-settings.confirm');
        Route::get('2fa-email-confirm', [TwoFASettingController::class, 'showEmailConfirm'])->name('two-fa-settings.validate_email_confirm');
        Route::post('2fa-email-confirm', [TwoFASettingController::class, 'emailConfirm'])->name('two-fa-settings.email_confirm');
        Route::resource('two-fa-settings', TwoFASettingController::class);
        /* profile setting */
        Route::post('profile/dark-theme', [ProfileController::class, 'darkTheme'])->name('profile.dark_theme');
        Route::post('profile/updateOneSignalId', [ProfileController::class, 'updateOneSignalId'])->name('profile.update_onesignal_id');
        Route::resource('profile', ProfileController::class);
        /* storage setting*/
        Route::get('storage-settings/aws-test-modal', [StorageSettingController::class, 'awsTestModal'])->name('storage-settings.aws_test_modal');
        Route::post('storage-settings/aws-test', [StorageSettingController::class, 'awsTest'])->name('storage-settings.aws_test');
        Route::resource('storage-settings', StorageSettingController::class);
        // Language settings
        Route::get('language-settings/auto-translate', [LanguageSettingController::class, 'autoTranslate'])->name('language_settings.auto_translate');
        Route::post('language-settings/auto-translate', [LanguageSettingController::class, 'autoTranslateUpdate'])->name('language_settings.auto_translate_update');
        Route::post('language-settings/update-data/{id?}', [LanguageSettingController::class, 'updateData'])->name('language_settings.update_data');
        Route::resource('language-settings', LanguageSettingController::class);
        
        // Social Auth Settings
        Route::resource('social-auth-settings', SocialAuthSettingController::class, ['only' => ['index', 'update']]);
        
        /* notification */
        // Route::get('smtp-settings/show-send-test-mail-modal', [SmtpSettingController::class, 'showTestEmailModal'])->name('smtp_settings.show_send_test_mail_modal');
        // Route::get('smtp-settings/send-test-mail', [SmtpSettingController::class, 'sendTestEmail'])->name('smtp_settings.send_test_mail');
    
        // Route::get('push-notification-settings/send-test-notification', [PushNotificationController::class, 'sendTestNotification'])->name('push_notification_settings.send_test_notification');

        // Route::resource('smtp-settings', SmtpSettingController::class);
        // Route::resource('notifications', NotificationSettingController::class);
        // Route::resource('slack-settings', SlackSettingController::class);
        // Route::resource('push-notification-settings', PushNotificationController::class);
        // Route::resource('pusher-settings', PusherSettingsController::class);
                    
        // Security Settings
        // Route::get('verify-google-recaptcha-v3', [SecuritySettingController::class, 'verify'])->name('verify_google_recaptcha_v3');
        // Route::resource('security-settings', SecuritySettingController::class);
        
        // Google Calendar Settings
        Route::resource('google-calendar-settings', GoogleCalendarSettingController::class);
        Route::get('google-auth', [GoogleAuthController::class, 'index'])->name('googleAuth');
        Route::delete('google-auth', [GoogleAuthController::class, 'destroy'])->name('googleAuth.destroy');

 
        // Role Permissions
        Route::post('role-permission/storeRole', [RolePermissionController::class, 'storeRole'])->name('role-permissions.store_role');
        Route::post('role-permission/deleteRole', [RolePermissionController::class, 'deleteRole'])->name('role-permissions.delete_role');
        Route::post('role-permissions/permissions', [RolePermissionController::class, 'permissions'])->name('role-permissions.permissions');
        Route::post('role-permissions/customPermissions', [RolePermissionController::class, 'customPermissions'])->name('role-permissions.custom_permissions');
        Route::post('role-permissions/reset-permissions', [RolePermissionController::class, 'resetPermissions'])->name('role-permissions.reset_permissions');
        Route::resource('role-permissions', RolePermissionController::class);
        // Route::resource('role-permissions-create', RolePermissionController::class, 'newperms')->name('role-permissions-create');

        // Theme settings
        Route::resource('theme-settings', ThemeSettingController::class);

        // Module settings
        Route::resource('module-settings', ModuleSettingController::class);
  
    });
    Route::post('mark-read', [NotificationController::class, 'markRead'])->name('mark_single_notification_read');
    Route::get('routes', function () {
        $routeCollection = Route::getRoutes();
    
        echo "<table style='width:100%'>";
        echo "<tr>";
        echo "<td width='10%'><h4>HTTP Method</h4></td>";
        echo "<td width='10%'><h4>Route</h4></td>";
        echo "<td width='10%'><h4>Name</h4></td>";
        echo "<td width='70%'><h4>Corresponding Action</h4></td>";
        echo "</tr>";
        foreach ($routeCollection as $value) {
            echo "<tr>";
            echo "<td>" . $value->methods()[0] . "</td>";
            echo "<td>" . $value->uri() . "</td>";
            echo "<td>" . $value->getName() . "</td>";
            echo "<td>" . $value->getActionName() . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    });
});
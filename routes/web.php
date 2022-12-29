<?php

use App\Http\Controllers\Api\DcIncomingFeederController;
use App\Http\Controllers\Api\EwsInspeksiPdController;
use App\Http\Controllers\AppSettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DC\BebanRealtimeController;
use App\Http\Controllers\DC\CubicleController;
use App\Http\Controllers\DC\DccController;
use App\Http\Controllers\DC\EwsInspeksiAsetController;
use App\Http\Controllers\DC\EwsInspeksiPdController as DCEwsInspeksiPdController;
use App\Http\Controllers\DC\GarduIndukController;
use App\Http\Controllers\DC\IncomingFeederPMTController;
use App\Http\Controllers\DC\RekapGangguanPMTscadaController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\GoogleCalendarSettingController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\LanguageSettingController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ModuleSettingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\NotificationSettingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileSettingController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SmtpSettingController;
use App\Http\Controllers\SocialAuthSettingController;
use App\Http\Controllers\StorageSettingController;
use App\Http\Controllers\ThemeSettingController;
use App\Http\Controllers\TwoFASettingController;
use App\Models\Dc_cubicle;
use App\Models\ews_ssd_gedung;
use App\Models\User;
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
    return redirect('/login');
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
    Route::resource('dccUp3',DccController::class  );
    Route::resource('incoming-feeder',IncomingFeederPMTController::class );
    Route::resource('gardu-induk',GarduIndukController::class );
    Route::resource('cubicle',CubicleController::class );
    Route::resource('beban-realtime',BebanRealtimeController::class );
    Route::resource('inspeksi-pd',DCEwsInspeksiPdController::class );
    Route::get('inspeksi-pd-print',[DCEwsInspeksiPdController::class,'domPdfObjectForDownload'] )->name('inspeksi-pd-print');
    Route::get('inspeksi-pd-download/{id}',[DCEwsInspeksiPdController::class,'download'] )->name('inspeksi-pd-download');
    Route::resource('inspeksi-aset',EwsInspeksiAsetController::class );
    Route::get('inspeksi-aset-print',[EwsInspeksiAsetController::class,'domPdfObjectForDownload'] )->name('inspeksi-aset-print');
    Route::get('inspeksi-aset-download/{id}',[EwsInspeksiAsetController::class,'download'] )->name('inspeksi-aset-download');
    Route::get('rekap-gangguan-pmt',[RekapGangguanPMTscadaController::class,'index' ])->name('rekap-gangguan-pmt.index');
    Route::get('rekap-gangguan-pmt/{id}',[RekapGangguanPMTscadaController::class,'show' ])->name('rekap-gangguan-pmt.show');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('checklist', [DashboardController::class, 'checklist'])->name('checklist');
    Route::get('dashboard-member', [DashboardController::class, 'memberDashboard'])->name('dashboard.member');
    Route::post('dashboard/widget/{dashboardType}', [DashboardController::class, 'widget'])->name('dashboard.widget');
    Route::resource('settings', SettingsController::class)->only(['edit', 'update', 'index', 'change_language']);
    // employee routes
    Route::post('employees/employeApj', [EmployeeController::class, 'employeApj'])->name('employees.employeApj');
    Route::post('employees/apply-quick-action', [EmployeeController::class, 'applyQuickAction'])->name('employees.apply_quick_action');
    Route::post('employees/assignRole', [EmployeeController::class, 'assignRole'])->name('employees.assign_role');
    Route::get('employees/byDepartment/{id}', [EmployeeController::class, 'byDepartment'])->name('employees.by_department');
    Route::get('employees/invite-member', [EmployeeController::class, 'inviteMember'])->name('employees.invite_member');
    Route::get('employees/import', [EmployeeController::class, 'importMember'])->name('employees.import');
    Route::post('employees/import', [EmployeeController::class, 'importStore'])->name('employees.import.store');
    Route::post('employees/import/process', [EmployeeController::class, 'importProcess'])->name('employees.import.process');
    Route::get('import/process/{name}/{id}', [ImportController::class, 'getImportProgress'])->name('import.process.progress');

    Route::get('employees/import/exception/{name}', [ImportController::class, 'getQueueException'])->name('import.process.exception');
    Route::post('employees/send-invite', [EmployeeController::class, 'sendInvite'])->name('employees.send_invite');
    Route::post('employees/create-link', [EmployeeController::class, 'createLink'])->name('employees.create_link');
    Route::resource('employees', EmployeeController::class);
    
    Route::resource('designations', DesignationController::class);
    Route::resource('departments', DepartmentController::class);

    /* setting */ 
    Route::group(['prefix' => 'settings'], function () {
        Route::get('change-language', [SettingsController::class, 'changeLanguage'])->name('settings.change_language'); 
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
        Route::get('smtp-settings/show-send-test-mail-modal', [SmtpSettingController::class, 'showTestEmailModal'])->name('smtp_settings.show_send_test_mail_modal');
        Route::get('smtp-settings/send-test-mail', [SmtpSettingController::class, 'sendTestEmail'])->name('smtp_settings.send_test_mail');
     
        Route::resource('smtp-settings', SmtpSettingController::class);
        Route::resource('notifications', NotificationSettingController::class); 
        Route::resource('pusher-settings', PusherSettingsController::class);
                    
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
    /* Setting menu routes ends here */
    Route::resource('company-settings', SettingsController::class)->only(['edit', 'update', 'index', 'change_language']);

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
    Route::get('apis',function () { return view('apis'); });
});
// Route::get('testapifirebase', function () { 
//     $url = 'https://fcm.googleapis.com/fcm/send';
//     $FcmToken = ["eLROqKFfQECn10nG7xplgm:APA91bH9OVHfhMNwmUut6PDMK55R5-nyAdFtBehcnO1NJ8iDtBG58SHUSiZH7faXPIyFwa6wSGALPKFNkfobDUsBWoXTjPk3iBTtSSZzKEZ0DPb9-T1fzW9nJFvErtJgIMLcZEOxdujH","cFFVbntNSC68dRwr9Zlxyn:APA91bE1BulTssiQY8uswIb5ui4VXzfP5Px83sFIMcG9-x5DU_aOOshVg8hj8gJ_GrTsFiaLaRCs0tO5Dl7K4wZ0661YiZcPukI3Ef2pnxsVh_mtivOGQtWYJaDKPUZcS-bl4GlXHVjG"];
      
//     $serverKey = 'AAAAZnHfQlw:APA91bGhJgRCUSWbLHi2_loTlVxf0iCTJcFYqHBGBapzBUrnh6-TitfPazajIvFveBeG0mt0Q9wNUZVNoFufm42xzwNlCs90JaZulT2ANbRBHypjLM9Jtrs6earOdGQ-95aAKfM8w7N6';

//     $data = [
//         "registration_ids" => $FcmToken,
//         "notification" => [
//             "title" => "test",
//             "body" => "test",  
//         ]
//     ];
//     $encodedData = json_encode($data);

//     $headers = [
//         'Authorization:key=' . $serverKey,
//         'Content-Type: application/json',
//     ];

//     $ch = curl_init();
  
//     curl_setopt($ch, CURLOPT_URL, $url);
//     curl_setopt($ch, CURLOPT_POST, true);
//     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
//     curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
//     // Disabling SSL Certificate support temporarly
//     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        
//     curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
//     // Execute post
//     $result = curl_exec($ch);
//     if ($result === FALSE) {
//         die('Curl failed: ' . curl_error($ch));
//     }        
//     // Close connection
//     curl_close($ch);
//     // FCM response
//     dd($result); 
// });
Route::get('usr', function () { 
    $tokens = User::whereNotNull('fcm_token')->pluck('fcm_token')->all();
    // $cub =  
    //         Dc_cubicle::where('TEMP_A','>','LIMIT_UPPER_TIME')
    //         ->orWhere('TEMP_B','>=','LIMIT_UPPER_TIME')
    //         ->orWhere('TEMP_C','>=','LIMIT_UPPER_TIME')  
    //         ->orWhere('TEMP_B','>=','LIMIT_UPPER_TIME') 
    //         ->get();  
    //         // dd($cub);
    //     if(!empty($cub)){
            
    //         foreach ($cub as $c) { 
    //             {
    //                 // dd($c);
    //                 $titl = "Temperatur";
    //                 $date_now= date('Y-m-d H:i',strtotime(' + 1 Minutes'));
    //                 if ($c['TEMP_A'] >= $c['LIMIT_UPPER_TIME'] ) {
    //                     $time_temp= date('Y-m-d H:i',strtotime($c['TEMP_A_TIME']));
    //                     $time_temp= date('Y-m-d H:i',strtotime($time_temp.' + 1 Minutes')); 
    //                     if ($time_temp == $date_now){
    //                         $time = $c['TEMP_A_TIME'];
    //                         $msgs = 'Suhu Kabel Power '.$c['CUBICLE_NAME'].' Phasa A mencapai '.$c['TEMP_A'].'° C pada '.$time;
    //                         $send = push_notification_android($tokens,$titl,$msgs);   
    //                     }
    //                 } 
    //                 if($c['TEMP_B'] >= $c['LIMIT_UPPER_TIME'] ) {
    //                     $time_temp= date('Y-m-d H:i',strtotime($c['TEMP_B_TIME']));
    //                     $time_temp= date('Y-m-d H:i',strtotime($time_temp.' + 1 Minutes'));
    //                     if ($time_temp == $date_now){
    //                         $time = $c['TEMP_B_TIME']; 
    //                         $msgs = 'Suhu Kabel Power '.$c['CUBICLE_NAME'].' Phasa B mencapai '.$c['TEMP_B'].'° C pada '.$c['TEMP_B_TIME']; 
    //                         $send = push_notification_android($tokens,$titl,$msgs);     
    //                     }
    //                 }
    //                 if($c['TEMP_C'] >= $c['LIMIT_UPPER_TIME'] ) {
    //                     $time_temp= date('Y-m-d H:i',strtotime($c['TEMP_C_TIME']));
    //                     $time_temp= date('Y-m-d H:i',strtotime($time_temp.' + 1 Minutes'));
    //                     if ($time_temp == $date_now){
    //                         $time = $c['TEMP_C_TIME'];
    //                         $msgs = 'Suhu Kabel Power '.$c['CUBICLE_NAME'].' Phasa C mencapai '.$c['TEMP_C'].'° C pada '.$c['TEMP_C_TIME']; 
    //                         $send = push_notification_android($tokens,$titl,$msgs); 
    //                     }    
    //                 }  
    //             }
    //         }
    //     }
         
});
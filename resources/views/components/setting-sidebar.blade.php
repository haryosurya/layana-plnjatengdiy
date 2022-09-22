<!-- SETTINGS SIDEBAR START -->
<div class="mobile-close-overlay w-100 h-100" id="close-settings-overlay"></div>
<div class="settings-sidebar bg-white py-3" id="mob-settings-sidebar">
    <a class="d-block d-lg-none close-it" id="close-settings"><i class="fa fa-times"></i></a>

    <!-- SETTINGS SEARCH START -->
    <form class="border-bottom-grey px-4 pb-3 d-flex">
        <div class="input-group rounded py-1 border-grey">
            <div class="input-group-prepend">
                <span class="input-group-text border-0 bg-white">
                    <i class="fa fa-search f-12 text-lightest"></i>
                </span>
            </div>
            <input type="text" id="search-setting-menu" class="form-control border-0 f-14 pl-0"
                placeholder="@lang('app.search')">
        </div>
    </form>
    <!-- SETTINGS SEARCH END -->

    <!-- SETTINGS MENU START -->
    <ul class="settings-menu" id="settingsMenu">

        @if (user()->permission('manage_company_setting') == 'all')
            <x-setting-menu-item :active="$activeMenu" menu="company_settings" :href="route('company-settings.index')"
                :text="__('app.menu.accountSettings')" />

            <x-setting-menu-item :active="$activeMenu" menu="business_address" :href="route('business-address.index')"
                :text="__('app.menu.businessAddresses')" />
        @endif

        @if (user()->permission('manage_app_setting') == 'all')
            <x-setting-menu-item :active="$activeMenu" menu="app_settings" :href="route('app-settings.index')"
                :text="__('app.menu.appSettings')" />
        @endif

        <x-setting-menu-item :active="$activeMenu" menu="profile_settings" :href="route('profile-settings.index')"
            :text="__('app.menu.profileSettings')" />

        @if (user()->permission('manage_notification_setting') == 'all')
            <x-setting-menu-item :active="$activeMenu" menu="notification_settings" :href="route('notifications.index')"
                :text="__('app.menu.notificationSettings')" />
        @endif

        @if (user()->permission('manage_currency_setting') == 'all')
            <x-setting-menu-item :active="$activeMenu" menu="currency_settings" :href="route('currency-settings.index')"
                :text="__('app.menu.currencySettings')" />
        @endif 
        
        @if (user()->permission('manage_role_permission_setting') == 'all')
            <x-setting-menu-item :active="$activeMenu" menu="role_permissions" :href="route('role-permissions.index')"
                :text="__('app.menu.rolesPermission')" />
        @endif

        @if (user()->permission('manage_message_setting') == 'all')
            <x-setting-menu-item :active="$activeMenu" menu="message_settings" :href="route('message-settings.index')"
                :text="__('app.menu.messageSettings')" />
        @endif

        @if (user()->permission('manage_storage_setting') == 'all')
            <x-setting-menu-item :active="$activeMenu" menu="storage_settings" :href="route('storage-settings.index')"
                :text="__('app.menu.storageSettings')" />
        @endif

        @if (user()->permission('manage_language_setting') == 'all')
            <x-setting-menu-item :active="$activeMenu" menu="language_settings" :href="route('language-settings.index')"
                :text="__('app.menu.languageSettings')" />
        @endif

        @if (user()->permission('manage_lead_setting') == 'all')
            <x-setting-menu-item :active="$activeMenu" menu="lead_settings" :href="route('lead-settings.index')"
                :text="__('app.menu.leadSettings')" />
        @endif

        @if (user()->permission('manage_time_log_setting') == 'all')
            <x-setting-menu-item :active="$activeMenu" menu="timelog_settings" :href="route('timelog-settings.index')"
                :text="__('app.menu.timeLogSettings')" />
        @endif

        @if (user()->permission('manage_task_setting') == 'all')
            <x-setting-menu-item :active="$activeMenu" menu="task_settings" :href="route('task-settings.index')"
                :text="__('app.menu.taskSettings')" />
        @endif

        @if (user()->permission('manage_social_login_setting') == 'all')
            <x-setting-menu-item :active="$activeMenu" menu="social_auth_settings"
                :href="route('social-auth-settings.index')" :text="__('app.menu.socialLogin')" />
        @endif
 
        @if (user()->permission('manage_google_calendar_setting') == 'all')
            <x-setting-menu-item :active="$activeMenu" menu="google_calendar_settings"
                :href="route('google-calendar-settings.index')" :text="__('app.menu.googleCalendarSetting')" />
        @endif

        @if (user()->permission('manage_gdpr_setting') == 'all')
            <x-setting-menu-item :active="$activeMenu" menu="gdpr_settings" :href="route('gdpr-settings.index')"
                :text="__('app.menu.gdprSettings')" />
        @endif

        @if (user()->permission('manage_theme_setting') == 'all')
            <x-setting-menu-item :active="$activeMenu" menu="theme_settings" :href="route('theme-settings.index')"
                :text="__('app.menu.themeSettings')" />
        @endif

        @if (user()->permission('manage_module_setting') == 'all')
            <x-setting-menu-item :active="$activeMenu" menu="module_settings" :href="route('module-settings.index')"
                :text="__('app.menu.moduleSettings')" />
        @endif
 
 

    </ul>
    <!-- SETTINGS MENU END -->

</div>
<!-- SETTINGS SIDEBAR END -->

<script>
    $("body").on("click", ".ajax-tab", function(event) {
        event.preventDefault();

        $('.project-menu .p-sub-menu').removeClass('active');
        $(this).addClass('active');

        const requestUrl = this.href;

        $.easyAjax({
            url: requestUrl,
            blockUI: true,
            container: ".content-wrapper",
            historyPush: true,
            success: function(response) {
                if (response.status === "success") {
                    $('.content-wrapper').html(response.html);
                    init('.content-wrapper');
                }
            }
        });
    });

    $("#search-setting-menu").on("keyup", function() {
        var value = this.value.toLowerCase().trim();
        $("#settingsMenu li").show().filter(function() {
            return $(this).text().toLowerCase().trim().indexOf(value) == -1;
        }).hide();
    });
</script>

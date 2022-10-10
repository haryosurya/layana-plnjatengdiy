<!-- SIDEBAR START -->
 <aside class="{{ ((!user()->dark_theme) ? 'sidebar-'.$appTheme->sidebar_theme : '') }}">
     <!-- MOBILE CLOSE SIDEBAR PANEL START -->
     <div class="mobile-close-sidebar-panel w-100 h-100" onclick="closeMobileMenu()" id="mobile_close_panel"></div>
     <!-- MOBILE CLOSE SIDEBAR PANEL END -->

     <!-- MAIN SIDEBAR START -->
     <div class="main-sidebar" id="mobile_menu_collapse">
         <!-- SIDEBAR BRAND START -->
         <div class="sidebar-brand-box dropdown cursor-pointer {{ user()->dark_theme ? 'bg-dark' : '' }}">
             <div class="dropdown-toggle sidebar-brand d-flex align-items-center justify-content-between  w-100"
                 type="link" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                 @if (global_setting()->sidebar_logo_style == 'square')
                     <!-- SIDEBAR BRAND NAME START -->
                    <div class="sidebar-brand-name">
                        <h1 class="mb-0 f-16 f-w-500 text-white-shade mt-0"  data-placement="bottom" data-toggle="tooltip" data-original-title="{{ ucwords($companyName) }}">{{ ucwords($companyName) }}
                            <i class="icon-arrow-down icons pl-2"></i>
                        </h1>
                        <div class="mb-0 position-relative pro-name">
                            <span class="bg-light-green rounded-circle"></span>
                            <p class="f-13 text-lightest mb-0" data-placement="bottom" data-toggle="tooltip" data-original-title="{{ ucwords(user()->name) }}">{{ ucwords(user()->name) }}</p>
                        </div>
                    </div>
                    <!-- SIDEBAR BRAND NAME END -->
                    <!-- SIDEBAR BRAND LOGO START -->
                    <div class="sidebar-brand-logo">
                        <img src="{{ $global->logo_url }}">
                    </div>
                    <!-- SIDEBAR BRAND LOGO END -->
                 @else
                    <!-- SIDEBAR BRAND NAME START -->
                    <div class="sidebar-brand-name">
                        <h1 class="mb-0 f-16 f-w-500 text-white-shade mt-0"  data-placement="bottom" data-toggle="tooltip" data-original-title="{{ ucwords($companyName) }}">
                        <img src="{{ $global->logo_url }}">
                        </h1>
                    </div>
                    <!-- SIDEBAR BRAND NAME END -->
                    <!-- SIDEBAR BRAND LOGO START -->
                    <div class="sidebar-brand-logo text-white-shade f-12">
                    <i class="icon-arrow-down icons pl-2"></i>
                    </div>
                    <!-- SIDEBAR BRAND LOGO END -->
                @endif
             </div>
             <!-- DROPDOWN - INFORMATION -->
             <div class="dropdown-menu dropdown-menu-right sidebar-brand-dropdown ml-3"
                 aria-labelledby="dropdownMenuLink" tabindex="0">
                 <div class="d-flex justify-content-between align-items-center profile-box">
                     <div class="profileInfo d-flex align-items-center mr-1 flex-wrap">
                         <div class="profileImg mr-2">
                             <img class="h-100" src="{{ $user->image_url }}" alt="{{ ucwords(user()->name) }}">
                         </div>
                         <div class="ProfileData">
                             <h3 class="f-15 f-w-500 text-dark" data-placement="bottom" data-toggle="tooltip" data-original-title="{{ ucwords(user()->name) }}">{{ ucwords(user()->name) }}</h3>
                             <p class="mb-0 f-12 text-dark-grey">{{ user()->designation->name ?? '' }}</p>
                         </div>
                     </div>
                     <a href="{{ route('profile-settings.index') }}">
                         <i class="side-icon bi bi-pencil-square"></i>
                     </a>
                 </div>
 

                 <a class="dropdown-item d-flex justify-content-between align-items-center f-15 text-dark" href="javascript:;">
                     <label for="dark-theme-toggle">@lang('app.darkTheme')</label>
                     <div class="custom-control custom-switch">
                         <input type="checkbox" class="custom-control-input" id="dark-theme-toggle" @if (user()->dark_theme) checked @endif>
                         <label class="custom-control-label f-14" for="dark-theme-toggle"></label>
                     </div>
                 </a>
                 <a class="dropdown-item d-flex justify-content-between align-items-center f-15 text-dark"
                     href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                     @lang('app.logout')
                     <i class="side-icon bi bi-power"></i>
                 </a>
             </div>
         </div>
         <!-- SIDEBAR BRAND END -->

         <!-- SIDEBAR MENU START -->
         <div class="sidebar-menu {{ user()->dark_theme ? 'bg-dark' : '' }}" id="sideMenuScroll">
             <ul> 
                <x-menu-item icon="house" :text="__('app.menu.dashboard')" :link="route('dashboard')">
                    <x-slot name="iconPath">
                        <path fill-rule="evenodd" d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
                        <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/>
                    </x-slot>
                </x-menu-item> 

                @if (in_array('employees', user_modules()) && $sidebarUserPermissions['view_employees'] != 5 && $sidebarUserPermissions['view_employees'] != 'none')
                <x-menu-item icon="people" :link="route('employees.index')" :text="__('app.menu.employees')" >
                    <x-slot name="iconPath">
                        <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
                    </x-slot>
                </x-menu-item>
                @endif

                @if (in_array('dcc', user_modules()) && $sidebarUserPermissions['view_dcc'] != 5 && $sidebarUserPermissions['view_dcc'] != 'none')
                <x-menu-item icon="building" :link="route('dccUp3.index')" :text="__('app.menu.dcc')" >
                    <x-slot name="iconPath">
                        <path fill-rule="evenodd" d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022zM6 8.694 1 10.36V15h5V8.694zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15z"/>
                        <path d="M2 11h1v1H2v-1zm2 0h1v1H4v-1zm-2 2h1v1H2v-1zm2 0h1v1H4v-1zm4-4h1v1H8V9zm2 0h1v1h-1V9zm-2 2h1v1H8v-1zm2 0h1v1h-1v-1zm2-2h1v1h-1V9zm0 2h1v1h-1v-1zM8 7h1v1H8V7zm2 0h1v1h-1V7zm2 0h1v1h-1V7zM8 5h1v1H8V5zm2 0h1v1h-1V5zm2 0h1v1h-1V5zm0-2h1v1h-1V3z"/>
                    </x-slot>
                </x-menu-item>
                @endif

                @if (in_array('gardu-induk', user_modules()) && $sidebarUserPermissions['view_gardu'] != 5 && $sidebarUserPermissions['view_gardu'] != 'none')
                <x-menu-item icon="building" :link="route('gardu-induk.index')" :text="__('app.menu.gardu-induk')" >
                    <x-slot name="iconPath">
                        <path fill-rule="evenodd" d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022zM6 8.694 1 10.36V15h5V8.694zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15z"/>
                        <path d="M2 11h1v1H2v-1zm2 0h1v1H4v-1zm-2 2h1v1H2v-1zm2 0h1v1H4v-1zm4-4h1v1H8V9zm2 0h1v1h-1V9zm-2 2h1v1H8v-1zm2 0h1v1h-1v-1zm2-2h1v1h-1V9zm0 2h1v1h-1v-1zM8 7h1v1H8V7zm2 0h1v1h-1V7zm2 0h1v1h-1V7zM8 5h1v1H8V5zm2 0h1v1h-1V5zm2 0h1v1h-1V5zm0-2h1v1h-1V3z"/>
                    </x-slot>
                </x-menu-item>
                @endif
                
                @if (in_array('incoming-feeder', user_modules()) && $sidebarUserPermissions['view_incoming_feeder'] != 5 && $sidebarUserPermissions['view_incoming_feeder'] != 'none')
                <x-menu-item icon="graph-up" :link="route('incoming-feeder.index')" :text="__('app.menu.incoming-feeder')" >
                    <x-slot name="iconPath">
                        <path d="M7.5 1.018a7 7 0 0 0-4.79 11.566L7.5 7.793V1.018zm1 0V7.5h6.482A7.001 7.001 0 0 0 8.5 1.018zM14.982 8.5H8.207l-4.79 4.79A7 7 0 0 0 14.982 8.5zM0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8z"/>
                    </x-slot>
                </x-menu-item>
                @endif

                @if (in_array('cubicle', user_modules()) && $sidebarUserPermissions['view_cubicle'] != 5 && $sidebarUserPermissions['view_cubicle'] != 'none')
                <x-menu-item icon="building" :link="route('cubicle.index')" :text="__('app.menu.cubicle')" >
                    <x-slot name="iconPath">
                        <path fill-rule="evenodd" d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022zM6 8.694 1 10.36V15h5V8.694zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15z"/>
                        <path d="M2 11h1v1H2v-1zm2 0h1v1H4v-1zm-2 2h1v1H2v-1zm2 0h1v1H4v-1zm4-4h1v1H8V9zm2 0h1v1h-1V9zm-2 2h1v1H8v-1zm2 0h1v1h-1v-1zm2-2h1v1h-1V9zm0 2h1v1h-1v-1zM8 7h1v1H8V7zm2 0h1v1h-1V7zm2 0h1v1h-1V7zM8 5h1v1H8V5zm2 0h1v1h-1V5zm2 0h1v1h-1V5zm0-2h1v1h-1V3z"/>
                    </x-slot>
                </x-menu-item>
                @endif
                    
                <!-- NAV ITEM - SETTINGS -->
                <x-menu-item icon="gear" :text="__('app.menu.settings')"
                    :link="($sidebarUserPermissions['manage_company_setting'] == 4 ? route('company-settings.index') : route('profile-settings.index'))">
                    <x-slot name="iconPath">
                        <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"/>
                        <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z"/>
                    </x-slot>
                </x-menu-item>

             </ul>
         </div>
         <!-- SIDEBAR MENU END -->
     </div>
     <!-- MAIN SIDEBAR END -->
     <!-- Sidebar Toggler -->
     <div
         class="text-center d-flex justify-content-between align-items-center position-fixed sidebarTogglerBox {{ user()->dark_theme ? 'bg-dark' : '' }}">
         <button class="border-0 d-lg-block d-none text-lightest font-weight-bold" id="sidebarToggle"></button>

         <p class="mb-0 text-dark-grey">ver 0.0.1</p>
     </div>
     <!-- Sidebar Toggler -->
 </aside>
 <!-- SIDEBAR END -->

<script>
    $(document).ready(function () {
 

        $('#dark-theme-toggle').change(function () {
            const darkTheme = ($(this).is(':checked')) ? '1' : '0'

            $.easyAjax({
                type: 'POST',
                url: "{{ route('profile.dark_theme') }}",
                blockUI: true,
                data: {
                    '_token': '{{ csrf_token() }}',
                    'darkTheme': darkTheme
                },
                success: function (response) {
                    if (response.status === 'success') {
                        window.location.reload();
                    }
                }
            });

        });

    });
</script>

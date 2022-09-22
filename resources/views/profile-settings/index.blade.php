@extends('layouts.app')

@section('content')

    <!-- SETTINGS START -->
    <div class="w-100 d-flex">

        <x-setting-sidebar :activeMenu="$activeSettingMenu" />

        <x-setting-card>

            <x-slot name="buttons">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <x-forms.link-primary link="javascript:;" class="mr-3 float-left d-none actionBtn emergency-contacts-btn" icon="plus">
                            @lang('app.create') @lang('app.new')
                        </x-forms.link-primary>
                    </div>
                </div>
            </x-slot>

            <x-slot name="header">
                <div class="s-b-n-header" id="tabs">
                    <nav class="tabs px-4 border-bottom-grey">
                        <div class="nav" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link f-15 active profile"
                                href="{{ route('profile-settings.index') }}" role="tab" aria-controls="nav-profiles"
                                aria-selected="true">@lang('app.profile')
                            </a> 
                        </div>
                    </nav>
                </div>
            </x-slot>

            {{-- include tabs here --}}
            @include($view)

        </x-setting-card>

    </div>
    <!-- SETTINGS END -->

@endsection

@push('scripts')
   
@endpush

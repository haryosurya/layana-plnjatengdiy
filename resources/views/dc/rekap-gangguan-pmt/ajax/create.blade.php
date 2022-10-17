@php
$addDesignationPermission = user()->permission('add_designation');
$addDepartmentPermission = user()->permission('add_department');
@endphp

<link rel="stylesheet" href="{{ asset('vendor/css/tagify.css') }}">

<div class="row">
    <div class="col-sm-12">
        <x-form id="save-data-form">

            @include('sections.password-autocomplete-hide')

            <div class="add-client bg-white rounded">
                <h4 class="mb-0 p-20 f-21 font-weight-normal text-capitalize border-bottom-grey">
                    @lang('modules.employees.accountDetails')</h4>
                <div class="row p-20">
                    <div class="col-lg-9 col-xl-10">
                        <div class="row">
                            <div class="col-lg-4 col-md-6">
                                <x-forms.text fieldId="employee_id" :fieldLabel="__('modules.employees.employeeId')"
                                    fieldName="employee_id" :fieldValue="($lastEmployeeID+1)" fieldRequired="true"
                                    :fieldPlaceholder="__('modules.employees.employeeIdInfo')">
                                </x-forms.text>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <x-forms.text fieldId="name" :fieldLabel="__('modules.employees.employeeName')"
                                    fieldName="name" fieldRequired="true" :fieldPlaceholder="__('placeholders.name')">
                                </x-forms.text>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <x-forms.text fieldId="email" :fieldLabel="__('modules.employees.employeeEmail')"
                                    fieldName="email" fieldRequired="true" :fieldPlaceholder="__('placeholders.email')">
                                </x-forms.text>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <x-forms.label class="mt-3" fieldId="password"
                                    :fieldLabel="__('app.password')" fieldRequired="true">
                                </x-forms.label>
                                <x-forms.input-group>

                                    <input type="password" name="password" id="password"
                                        class="form-control height-35 f-14">
                                    <x-slot name="preappend">
                                        <button type="button" data-toggle="tooltip"
                                            data-original-title="@lang('app.viewPassword')"
                                            class="btn btn-outline-secondary border-grey height-35 toggle-password"><i
                                                class="fa fa-eye"></i></button>
                                    </x-slot>
                                    <x-slot name="append">
                                        <button id="random_password" type="button" data-toggle="tooltip"
                                            data-original-title="@lang('modules.client.generateRandomPassword')"
                                            class="btn btn-outline-secondary border-grey height-35"><i
                                                class="fa fa-random"></i></button>
                                    </x-slot>
                                </x-forms.input-group>
                                <small class="form-text text-muted">@lang('placeholders.password')</small>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <x-forms.label class="my-3" fieldId="category_id"
                                    :fieldLabel="__('app.designation')" fieldRequired="true">
                                </x-forms.label>
                                <x-forms.input-group>
                                    <select class="form-control select-picker" name="designation"
                                        id="employee_designation" data-live-search="true">
                                        <option value="">--</option>
                                        @foreach ($designations as $designation)
                                            <option value="{{ $designation->id }}">{{ $designation->name }}</option>
                                        @endforeach
                                    </select>

                                    @if ($addDesignationPermission == 'all' || $addDesignationPermission == 'added')
                                        <x-slot name="append">
                                            <button id="designation-setting" type="button"
                                                class="btn btn-outline-secondary border-grey">@lang('app.add')</button>
                                        </x-slot>
                                    @endif
                                </x-forms.input-group>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <x-forms.label class="my-3" fieldId="category_id"
                                    :fieldLabel="__('app.department')" fieldRequired="true">
                                </x-forms.label>
                                <x-forms.input-group>
                                    <select class="form-control select-picker" name="department"
                                        id="employee_department" data-live-search="true">
                                        <option value="">--</option>
                                        @foreach ($teams as $team)
                                            <option value="{{ $team->id }}">{{ $team->team_name }}</option>
                                        @endforeach
                                    </select>

                                    @if ($addDepartmentPermission == 'all' || $addDepartmentPermission == 'added')
                                        <x-slot name="append">
                                            <button type="button"
                                                class="btn btn-outline-secondary border-grey department-setting">@lang('app.add')</button>
                                        </x-slot>
                                    @endif
                                </x-forms.input-group>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xl-2">
                        <x-forms.file allowedFileExtensions="png jpg jpeg" class="mr-0 mr-lg-2 mr-md-2 cropper"
                            :fieldLabel="__('modules.profile.profilePicture')" fieldName="image" fieldId="image"
                            fieldHeight="119" :popover="__('messages.fileFormat.ImageFile')" />
                    </div>
                     
                    <div class="col-lg-3 col-md-6">
                        <x-forms.tel fieldId="mobile" :fieldLabel="__('app.mobile')" fieldName="mobile"
                            fieldPlaceholder="e.g. 987654321"></x-forms.tel>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <x-forms.select fieldId="gender" :fieldLabel="__('modules.employees.gender')"
                            fieldName="gender">
                            <option value="">--</option>
                            <option value="male">@lang('app.male')</option>
                            <option value="female">@lang('app.female')</option>
                            <option value="others">@lang('app.others')</option>
                        </x-forms.select>
                    </div> 

                    <div class="col-lg-3 col-md-6">
                        <x-forms.datepicker fieldId="TGL_OPERASI_PMT" :fieldLabel="__('modules.dc.tgl-operasi')"
                            fieldName="TGL_OPERASI_PMT" :fieldPlaceholder="__('placeholders.date')" />
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <x-forms.datepicker fieldId="TGL_NORMAL_PMT" :fieldLabel="__('modules.dc.tgl-normal')"
                            fieldName="TGL_NORMAL_PMT" :fieldPlaceholder="__('placeholders.date')" />
                    </div>
                    <div class="col-md-12">
                        <div class="form-group my-3">
                            <x-forms.textarea class="mr-0 mr-lg-2 mr-md-2" :fieldLabel="__('app.address')"
                                fieldName="address" fieldId="address" :fieldPlaceholder="__('placeholders.address')">
                            </x-forms.textarea>
                        </div>
                    </div>

                </div>

                <h4 class="mb-0 p-20 f-21 font-weight-normal text-capitalize border-top-grey">
                    @lang('modules.client.clientOtherDetails')</h4>
                <div class="row p-20">
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.client.clientCanLogin')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="login-yes" :fieldLabel="__('app.yes')" fieldName="login"
                                    fieldValue="enable" checked="true">
                                </x-forms.radio>
                                <x-forms.radio fieldId="login-no" :fieldLabel="__('app.no')" fieldValue="disable"
                                    fieldName="login"></x-forms.radio>
                            </div>
                        </div>
                    </div>
 
                    @if (function_exists('sms_setting') && sms_setting()->telegram_status)
                        <div class="col-md-4">
                            <x-forms.number fieldName="telegram_user_id" fieldId="telegram_user_id"
                                fieldLabel="<i class='fab fa-telegram'></i> {{ __('sms::modules.telegramUserId') }}"
                                :popover="__('sms::modules.userIdInfo')" />
                        </div>
                    @endif

                </div>
 
                <x-form-actions>
                    <x-forms.button-primary id="save-employee-form" class="mr-3" icon="check">
                        @lang('app.save')
                    </x-forms.button-primary>
                    <x-forms.button-cancel :link="route('employees.index')" class="border-0">@lang('app.cancel')
                    </x-forms.button-cancel>

                </x-form-actions>
            </div>
        </x-form>

    </div>
</div>

<script src="{{ asset('vendor/jquery/tagify.min.js') }}"></script>
<script>
    $(document).ready(function() {
  

        datepicker('#TGL_OPERASI_PMT', {
            position: 'bl',
            maxDate: new Date("{{ now() }}"),
            ...datepickerConfig
        });
        datepicker('#TGL_NORMAL_PMT', {
            position: 'bl',
            maxDate: new Date("{{ now() }}"),
            ...datepickerConfig
        });

        var input = document.querySelector('input[name=tags]'),
            // init Tagify script on the above inputs
            tagify = new Tagify(input);

        $('#save-employee-form').click(function() {
            const url = "{{ route('employees.store') }}";

            $.easyAjax({
                url: url,
                container: '#save-data-form',
                type: "POST",
                disableButton: true,
                blockUI: true,
                buttonSelector: "#save-employee-form",
                file: true,
                data: $('#save-data-form').serialize(),
                success: function(response) {
                    if (response.status == 'success') {
                        if ($(MODAL_XL).hasClass('show')) {
                            $(MODAL_XL).hide();
                            window.location.reload();
                        } else {
                            window.location.href = response.redirectUrl;
                        }
                    }
                }
            });
        });
 

        init(RIGHT_MODAL);
    }); 
</script>

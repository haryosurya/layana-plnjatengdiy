<style>
    .card-img {
        width: 120px;
        height: 120px;
    }

    .card-img img {
        width: 120px;
        height: 120px;
        object-fit: cover;
    }

</style>

@php
$editEmployeePermission = user()->permission('edit_employees');
@endphp

<div class="d-lg-flex">

    <div class="project-left w-100 py-0 py-lg-5 py-md-0">
        <!-- ROW START -->
        <div class="row">
            <!--  USER CARDS START -->
            <div class="col-lg-12 col-md-12 mb-4 mb-xl-0 mb-lg-4 mb-md-0"> 
                <x-cards.user :image="$employee->image_url"> 
                    <h4 class="card-title f-15 f-w-500 text-darkest-grey mb-0">
                        {{ ucfirst( ucwords($employee->name)) }} 
                    </h4> 
                    @if ($editEmployeePermission == 'all' || ($editEmployeePermission == 'added' && $employee->employeeDetail->added_by == user()->id)) 
                    <div class="dropdown">
                        <button class="btn f-14 px-0 py-0 text-dark-grey dropdown-toggle"
                            type="button" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="fa fa-ellipsis-h"></i>
                        </button>

                        <div class="dropdown-menu dropdown-menu-right border-grey rounded b-shadow-4 p-0"
                            aria-labelledby="dropdownMenuLink" tabindex="0">
                            <a class="dropdown-item openRightModal"
                                href="{{ route('employees.edit', $employee->id) }}">@lang('app.edit')</a>
                        </div>
                    </div> 
                    @endif
                    <p class="f-13 font-weight-normal text-dark-grey mb-0">
                        {{ !is_null($employee->employeeDetail) && !is_null($employee->employeeDetail->designation) ? ucwords($employee->employeeDetail->designation->name) : '' }}
                        &bull;
                        {{ isset($employee->employeeDetail) && !is_null($employee->employeeDetail->department) && !is_null($employee->employeeDetail->department) ? ucwords($employee->employeeDetail->department->team_name) : '' }}
                    </p> 
                    @if ($employee->status == 'active')
                        <p class="card-text f-12 text-lightest">@lang('app.lastLogin') 
                            @if (!is_null($employee->last_login))
                                {{ $employee->last_login->timezone($global->timezone)->format($global->date_format . ' ' . $global->time_format) }}
                            @else
                                --
                            @endif
                        </p> 
                    @else
                        <p class="card-text f-12 text-lightest">
                            <x-status :value="__('app.inactive')" color="red" />
                        </p>
                    @endif 
                </x-cards.user>


                <x-cards.data :title="__('modules.client.profileInfo')" class=" mt-4">
                    <x-cards.data-row :label="__('modules.employees.employeeId')"
                        :value="(!is_null($employee->employeeDetail) && !is_null($employee->employeeDetail->employee_id)) ? ucwords($employee->employeeDetail->employee_id) : '--'" />

                    <x-cards.data-row :label="__('modules.employees.fullName')"
                        :value="ucwords($employee->name)" />

                    <x-cards.data-row :label="__('app.email')" :value="$employee->email" />

                    <x-cards.data-row :label="__('modules.dc.apj')"
                        :value="(!is_null($employee->employeeDetail) && !is_null($employee->employeeDetail->apj)) ? ucwords($employee->employeeDetail->apj->APJ_NAMA) : '--'" />

                    <x-cards.data-row :label="__('modules.dc.gi')"
                        :value="(!is_null($employee->employeeDetail) && !is_null($employee->employeeDetail->gi)) ? ucwords($employee->employeeDetail->gi->GARDU_INDUK_NAMA) : '--'" />

                    <x-cards.data-row :label="__('app.designation')"
                        :value="(!is_null($employee->employeeDetail) && !is_null($employee->employeeDetail->designation)) ? ucwords($employee->employeeDetail->designation->name) : '--'" />

                    <x-cards.data-row :label="__('app.department')"
                        :value="(isset($employee->employeeDetail) && !is_null($employee->employeeDetail->department) && !is_null($employee->employeeDetail->department)) ? ucwords($employee->employeeDetail->department->team_name) : '--'" />

                    <x-cards.data-row :label="__('app.mobile')"
                        :value="(!is_null($employee->country_id) ? '+'.$employee->country->phonecode.'-' : '--'). $employee->mobile ?? '--'" />

                    <div class="col-12 px-0 pb-3 d-block d-lg-flex d-md-flex">
                        <p class="mb-0 text-lightest f-14 w-30 d-inline-block text-capitalize">
                            @lang('modules.employees.gender')</p>
                        <p class="mb-0 text-dark-grey f-14 w-70">
                            <x-gender :gender='$employee->gender' />
                        </p>
                    </div>

                    <x-cards.data-row :label="__('modules.employees.joiningDate')"
                        :value="(!is_null($employee->employeeDetail) && !is_null($employee->employeeDetail->joining_date)) ? $employee->employeeDetail->joining_date->format($global->date_format) : '--'" />

                    <x-cards.data-row :label="__('modules.employees.placeOfBirth')"
                        :value="(!is_null($employee->employeeDetail) && !is_null($employee->employeeDetail->place_of_birth)) ? $employee->employeeDetail->place_of_birth : '--'" />

                    <x-cards.data-row :label="__('modules.employees.dateOfBirth')"
                        :value="(!is_null($employee->employeeDetail) && !is_null($employee->employeeDetail->date_of_birth)) ? $employee->employeeDetail->date_of_birth->format($global->date_format) : '--'" />

                    <x-cards.data-row :label="__('app.address')"
                        :value="$employee->employeeDetail->address ?? '--'" />


                </x-cards.data> 
            </div>
            <!--  USER CARDS END -->  
        </div>
        <!-- ROW END -->
    </div>
 
</div>

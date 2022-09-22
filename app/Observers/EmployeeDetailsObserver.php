<?php

namespace App\Observers;

use App\Models\EmployeeLeaveQuota;
use App\Models\LeaveType;
use App\Models\EmployeeDetails;
use App\Models\UserDetail;

class EmployeeDetailsObserver
{

    public function saving(UserDetail $detail)
    {
        if (!isRunningInConsoleOrSeeding() && auth()->check()) {
            $detail->last_updated_by = user()->id;
        }
    }

    public function creating(UserDetail $detail)
    {
        if (!isRunningInConsoleOrSeeding() && auth()->check()) {
            $detail->added_by = user()->id;
        }
    }

    public function created(UserDetail $detail)
    { 
    }

}

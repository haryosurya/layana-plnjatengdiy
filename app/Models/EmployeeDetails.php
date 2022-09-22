<?php

namespace App\Models;

use App\Observers\EmployeeDetailsObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeDetails extends BaseModel
{
    use HasFactory; 

    protected $table = 'employee_details';

    protected $dates = ['joining_date', 'last_date', 'date_of_birth'];

    protected $with = ['designation'];

    protected static function boot()
    {
        parent::boot();
        static::observe(EmployeeDetailsObserver::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withoutGlobalScopes(['active']);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }

    public function department()
    {
        return $this->belongsTo(Team::class, 'department_id');
    }
}

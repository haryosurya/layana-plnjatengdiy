<?php

namespace App\Models;
use App\Traits\CustomFieldsTrait;

use App\Observers\EmployeeDetailsObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EmployeeDetails
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $employee_id
 * @property string|null $address
 * @property string|null $place_of_birth
 * @property \Illuminate\Support\Carbon|null $date_of_birth
 * @property int|null $department_id
 * @property int|null $designation_id
 * @property int|null $added_by
 * @property int|null $last_updated_by
 * @property \Illuminate\Support\Carbon $joining_date
 * @property \Illuminate\Support\Carbon|null $last_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Team|null $department
 * @property-read \App\Models\Designation|null $designation
 * @property-read mixed $extras
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeDetails newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeDetails newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeDetails query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeDetails whereAddedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeDetails whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeDetails whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeDetails whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeDetails whereDesignationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeDetails whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeDetails whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeDetails whereJoiningDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeDetails whereLastDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeDetails whereLastUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeDetails wherePlaceOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeDetails whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeDetails whereUserId($value)
 * @mixin \Eloquent
 */
class EmployeeDetails extends BaseModel
{ 
    use CustomFieldsTrait;

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
    public function apj()
    {
        return $this->belongsTo(Dc_apj::class,'apj_id', 'APJ_ID');
    }
    public function gi()
    {
        return $this->belongsTo(Dc_gardu_induk::class, 'gi_id', 'GARDU_INDUK_ID');
    }
}

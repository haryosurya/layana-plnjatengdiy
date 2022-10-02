<?php

namespace App\Models;

use App\Observers\EmployeeDetailsObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserDetail
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
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereAddedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereDesignationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereJoiningDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereLastDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereLastUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail wherePlaceOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDetail whereUserId($value)
 * @mixin \Eloquent
 */
class UserDetail extends BaseModel
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

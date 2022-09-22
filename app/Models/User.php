<?php

namespace App\Models;

use App\Observers\UserObserver;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Fortify\TwoFactorAuthenticationProvider;
use Laravel\Sanctum\HasApiTokens;
use Trebol\Entrust\Traits\EntrustUserTrait;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends BaseModel implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract, JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, EntrustUserTrait, Authenticatable, Authorizable, CanResetPassword,  TwoFactorAuthenticatable;
    
    protected $default = [
        'id',
        'name',
        'email',
        'status'
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $filterable = [
        'id',
        'users.name',
        'email',
        'status'
    ];

    protected $with = ['role', 'session', 'employeeDetail'];
    protected static function boot()
    {
        parent::boot();
        static::observe(UserObserver::class);

        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('users.status', '=', 'active');
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */ 

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at',
    ];

    public $dates = ['created_at', 'updated_at', 'last_login', 'two_factor_expires_at'];

    protected $appends = ['image_url', 'modules', 'user_other_role'];

    public function getImageUrlAttribute()
    {
        $gravatarHash = md5(strtolower(trim($this->email)));
        return ($this->image) ? asset_url('avatar/' . $this->image) : 'https://www.gravatar.com/avatar/' . $gravatarHash . '.png?s=200&d=mp';
    }

    public function hasGravatar($email)
    {
        // Craft a potential url and test its headers
        $hash = md5(strtolower(trim($email)));

        $uri = 'http://www.gravatar.com/avatar/' . $hash . '?d=404';
        $headers = @get_headers($uri);

        $has_valid_avatar = true;

        try{
            if (!preg_match('|200|', $headers[0])) {
                $has_valid_avatar = false;
            }
        }catch(\Exception $e){
            $has_valid_avatar = true;
        }

        return $has_valid_avatar;
    }

    /**
     * Route notifications for the Slack channel.
     *
     * @return string
     */
 
  

    // phpcs:ignore
    public function routeNotificationForEmail($notification = null)
    {
        $containsExample = Str::contains($this->email, 'example');

        if (\config('app.env') === 'demo' && $containsExample) {
            return null;
        }

        return $this->email;
    }
     
    public function employee()
    {
        return $this->hasMany(EmployeeDetails::class, 'user_id');
    }

    public function employeeDetail()
    {
        return $this->hasOne(EmployeeDetails::class, 'user_id');
    }
  
    public function role()
    {
        return $this->hasMany(RoleUser::class, 'user_id');
    }
 
    public function group()
    {
        return $this->hasMany(EmployeeTeam::class, 'user_id');
    }
        
    public static function allEmployees($exceptId = null, $active = false)
    {
        if (!isRunningInConsoleOrSeeding() && user()) {
            $viewEmployeePermission = user()->permission('view_employees');
        }

        $users = User::withRole('employee')
            ->join('employee_details', 'employee_details.user_id', '=', 'users.id')
            ->leftJoin('designations', 'employee_details.designation_id', '=', 'designations.id')
            ->select('users.id', 'users.name', 'users.email', 'users.created_at', 'users.image', 'designations.name as designation_name', 'users.email_notifications', 'users.mobile', 'users.country_id');

        if (!is_null($exceptId)) {
            $users->where('users.id', '<>', $exceptId);
        }

        if (!$active) {
            $users->withoutGlobalScope('active');
        }

        if (!isRunningInConsoleOrSeeding() && user() && isset($viewEmployeePermission)) {
            if ($viewEmployeePermission == 'added' && !in_array('client', user_roles())) {
                $users->where('employee_details.added_by', user()->id);

            } elseif ($viewEmployeePermission == 'owned' && !in_array('client', user_roles())) {
                $users->where('users.id', user()->id);

            } elseif ($viewEmployeePermission == 'both' && !in_array('client', user_roles())) {
                $users->where(function ($q) {
                    $q->where('employee_details.user_id', user()->id);
                    $q->orWhere('employee_details.added_by', user()->id);
                });

            } elseif (($viewEmployeePermission == 'none' || $viewEmployeePermission == '') && !in_array('client', user_roles())) {
                $users->where('users.id', user()->id);
            }
        }

        $users->orderBy('users.name', 'asc');
        $users->groupBy('users.id');
        return $users->get();;
    }

    public static function allAdmins($exceptId = null)
    {
        if (!is_null($exceptId)) {
            $users = User::withRole('admin');

            if (!is_null($exceptId)) {
                $users->where('users.id', '<>', $exceptId);
            }

            return $users->get();
        }

        $users = User::withRole('admin');

        if (!is_null($exceptId)) {
            $users->where('users.id', '<>', $exceptId);
        }

        return $users->get();;
    }

    public static function departmentUsers($teamId)
    {
        $users = User::join('employee_details', 'employee_details.user_id', '=', 'users.id')
            ->select('users.id', 'users.name', 'users.email', 'users.created_at')
            ->where('employee_details.department_id', $teamId);

        return $users->get();
    }
 

    public static function isAdmin($userId)
    {
        $user = User::find($userId);

        if ($user) {
            return $user->hasRole('admin') ? true : false;
        }

        return false;
    }
 
    public static function isEmployee($userId)
    {
        $user = User::find($userId);

        if ($user) {
            return $user->hasRole('employee') ? true : false;
        }

        return false;
    }
  

    public function employeeDetails()
    {
        return $this->hasOne(EmployeeDetails::class);
    }
 

    /**
     * Check if user has a permission by its name.
     *
     * @param string|array $permission Permission string or array of permissions.
     * @param bool $requireAll All permissions in the array are required.
     *
     * @return bool
     */
    public function can($permission, $requireAll = false)
    {
        config(['cache.default' => 'array']);

        if (is_array($permission)) {
            foreach ($permission as $permName) {
                $hasPerm = $this->can($permName);

                if ($hasPerm && !$requireAll) {
                    return true;
                }

                if (!$hasPerm && $requireAll) {
                    return false;
                }
            }

            // If we've made it this far and $requireAll is FALSE, then NONE of the perms were found
            // If we've made it this far and $requireAll is TRUE, then ALL of the perms were found.
            // Return the value of $requireAll;
            return $requireAll;
        }
        else {
            foreach ($this->cachedRoles() as $role) {
                // Validate against the Permission table
                foreach ($role->cachedPermissions() as $perm) {
                    if (Str::is($permission, $perm->name)) {
                        return true;
                    }
                }
            }
        }

        config(['cache.default' => 'file']);
        return false;
    }

    public function getUserOtherRoleAttribute()
    {
        // if (!module_enabled('RestAPI')) {
        //     return true;
        // }

        $userRole = null;
        $roles = cache()->remember(
            'non-client-roles',
            60 * 60 * 24,
            function () {
                return Role::where('name', '<>', 'client')
                    ->orderBy('id', 'asc')->get();
            }
        );

        foreach ($roles as $role) {
            foreach ($this->role as $urole) {
                if ($role->id == $urole->role_id) {
                    $userRole = $role->name;
                }

                if ($userRole == 'admin') {
                    break;
                }
            }
        }

        return $userRole;
    }

    /**
     * @return false|mixed
     */
    public function permission($permission)
    {
        $permissionType = UserPermission::join('permissions', 'user_permissions.permission_id', '=', 'permissions.id')
            ->join('permission_types', 'user_permissions.permission_type_id', '=', 'permission_types.id')
            ->select('permission_types.name')
            ->where('permissions.name', $permission)
            ->where('user_permissions.user_id', $this->id)
            ->first();

        if ($permissionType) {
            return $permissionType->name;
        }

        return false;
    }

    public function permissionTypeId($permission)
    {
        $permissionType = UserPermission::join('permissions', 'user_permissions.permission_id', '=', 'permissions.id')
            ->join('permission_types', 'user_permissions.permission_type_id', '=', 'permission_types.id')
            ->select('permission_types.name', 'permission_types.id')
            ->where('permissions.name', $permission)
            ->where('user_permissions.user_id', $this->id)
            ->first();

        if ($permissionType) {
            return $permissionType->id;
        }

        return false;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissionTypes()
    {
        return $this->belongsToMany(Permission::class, 'user_permissions')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function session()
    {
        return $this->hasOne(Session::class, 'user_id')->select('user_id', 'ip_address', 'last_activity');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contracts()
    {
        return $this->hasMany(Contract::class, 'client_id', 'id');
    }

    public function assignUserRolePermission($roleId)
    {
        $rolePermissions = PermissionRole::where('role_id', $roleId)->get();

        foreach ($rolePermissions as $key => $value) {
            $userPermission = UserPermission::where('permission_id', $value->permission_id)
                ->where('user_id', $this->id)
                ->firstOrNew();

            $userPermission->permission_id = $value->permission_id;
            $userPermission->user_id = $this->id;
            $userPermission->permission_type_id = $value->permission_type_id;
            $userPermission->save();
        }
    }

    public function generateTwoFactorCode()
    {
        $this->timestamps = false;
        $this->two_factor_code = rand(100000, 999999);
        $this->two_factor_expires_at = now()->addMinutes(10);
        $this->save();
    }

    public function resetTwoFactorCode()
    {
        $this->timestamps = false;
        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save();
    }

    public function confirmTwoFactorAuth($code)
    {
        $codeIsValid = app(TwoFactorAuthenticationProvider::class)
            ->verify(decrypt($this->two_factor_secret), $code);

        if ($codeIsValid) {
            $this->two_factor_confirmed = true;
            $this->save();

            return true;
        }

        return false;
    }
    public function getModulesAttribute()
    {
        return user_modules();
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
 
    public function getJWTCustomClaims()
    {
        return [];
    }

    public static function getCacheKey($id)
    {
        return 'user_' . $id;
    }
}

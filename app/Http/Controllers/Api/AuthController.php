<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Auth\EmailVerifyRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Http\Requests\Auth\ResendVerificationMailRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\EmployeeDetails;
use App\Models\User;
use Carbon\Carbon;
use Froiden\RestAPI\ApiController;
use Froiden\RestAPI\ApiResponse;
use Froiden\RestAPI\Exceptions\ApiException;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use RefreshTokenRequest;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends ApiBaseController
{


    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    } 
    public function login(LoginRequest $request)
    {
        
        // Modifications to this function may also require modifications to
        // $email = $request->get('email');
        // $password = $request->get('password');
        // $days =  365;
        // $minutes =  60 * 60 * $days;
        // config()->set('jwt.ttl', $minutes);
        // $claims = ['exp' => (int)Carbon::now()->addYear()->getTimestamp(), 'remember' => 1, 'type' => 1];

        // $token = auth()->claims($claims)->attempt(['email' => $email, 'password' => $password]);
        // // $token = auth()->claims($claims)->attempt(['email' => $email, 'password' => $password]);
 
        // if ($token) {
        //     $user = User::where('email', $email)->first();

        //     if ($user && $user->status === 'deactive') {
        //         $exception = new ApiException('User account disabled', null, 403, 403, 2015);
        //         return ApiResponse::exception($exception);
        //     } 
        //     /** @var Admin $user */
        //     $user = auth()->user();
 
        //     //          $payload = auth()->payload();

        //     $expire = \Carbon\Carbon::now()->addYear(1);
        //     return ApiResponse::make('Logged in successfully', [
        //         // 'token' => $token,
        //         'token' => $user->createToken('token-auth')->plainTextToken,
        //         'user' => $user->load('roles', 'roles.perms', 'roles.permissions'),
        //         'expires' => $expire,
        //         'expires_in' => auth()->factory()->getTTL(),
        //     ]);
        // }

        // $exception = new ApiException('Wrong credentials provided', null, 403, 403, 2001);
        // return ApiResponse::exception($exception);
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(!Auth::attempt($request->only(['email', 'password']))){
                $user = auth()->user();

                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();
            return response()->json([
                'status' => true,
                'token' => $user->createToken('token-auth')->plainTextToken,
                'user' => $user->load('roles', 'roles.perms', 'roles.permissions'),
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function logout()
    { 
        try{
            auth()->user()->tokens()->delete();
            return ApiResponse::make(['status'=>true,'message'=>'Token invalidated successfully']); 
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    { try{
        $input = $request->only('email');
        $validator = Validator::make($input, ['email' => "required|email"]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $response =  Password::sendResetLink($input);
        if($response == Password::RESET_LINK_SENT){
            $message = 'If your email belongs to an account, a password reset email has been sent to it';
        }
        else{
            $message = "Email could not be sent to this email address";
        } 
        return response()->json([
            'status' => true, 
            'message' => $message, 
        ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    protected  function resetPassword(ResetPasswordRequest $request)
    {
        $input = $request->only('email','token', 'password', 'password_confirmation');
        $validator = Validator::make($input, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $response = Password::reset($input, function ($user, $password) {
            $user->forceFill(['password' => Hash::make($password)])->save();
            //$user->setRememberToken(Str::random(60));
            event(new PasswordReset($user));
        });
        if($response == Password::PASSWORD_RESET){
            $message = "Password reset successfully";
        }else{
            $message = "Email could not be sent to this email address";
        }
        $response = ['data'=>'','message' => $message];
        return response()->json($response);
    }
  
    public function me()
    {
        try{
            if (auth()->user()){
                $user = Auth::user();
                return ApiResponse::make([
                    'status' => true, 
                    'message' =>'Authenticated',
                    'user' => $user,
                    'employe' => EmployeeDetails::join('users', 'employee_details.user_id', '=', 'users.id')->first(),
                ]);
            }
            else{
                return ApiResponse::make([
                'status' => false,
                'message'=>'Unauthenticated']);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}

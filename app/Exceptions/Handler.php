<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */

    // public function report(Exception $exception)
    // {
    //     parent::report($exception);
    // }
 
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
            
        });
        
        $this->renderable(function (\Exception $e,$request) {  
            if ($e->getPrevious() instanceof \Illuminate\Session\TokenMismatchException) {
                return redirect()->route('login'); 
            };   
            // if ($request->is('api/*')) {
            //     return response()->json([
            //         'status' => false,
            //         'message' => $e->getMessage(),
            //         'data' => []
            //     ], 200);
            // }
        }); 
    } 
    protected function invalidJson($request, ValidationException $exception)
    {
        return response()->json([
        'message' => __('validation.givenDataInvalid'),
        'errors' => $exception->errors(),
        ], $exception->status);
    }
    
    // protected function shouldReturnJson($request, Throwable $e)
    // {
    //     return true;
    // }
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->is('api/*')) { 
            return response()->json(['status'=>false,'message' => $exception->getMessage()], 200);
        }
        else{
            return redirect()->route('login');
        }
    }
    
}

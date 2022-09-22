<?php
 
namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;

class EmailVerifyRequest extends BaseRequest
{

    public function rules()
    {
        return [
            'token' => 'required'
        ];
    }

    public function authorize()
    {
        return true;
    }
}

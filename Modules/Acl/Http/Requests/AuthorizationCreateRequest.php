<?php 
namespace Modules\Acl\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthorizationCreateRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
 
    public function rules()
    {
        return [
            'user' => 'required',
            'application' => 'required',
            'role' => 'required'
        ];
    }
 
}
<?php 
namespace Modules\Acl\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationUpdateRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
 
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->application;
        return $rules = [
            'slug' => 'required|max:30|unique:applications,slug,'.$id,
        ];
    }
 
}
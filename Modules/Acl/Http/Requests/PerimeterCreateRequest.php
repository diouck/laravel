<?php 
namespace Modules\Acl\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PerimeterCreateRequest extends FormRequest {

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
        return [
            'com' => 'required|max:5|unique:perimeters',
            'nom_com' => 'required|unique:perimeters',
            'epci' => 'required|max:9',
            'dep' => 'required|max:2',
        ];
    }
 
}
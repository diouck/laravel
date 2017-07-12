<?php 
namespace Modules\Acl\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PerimeterUpdateRequest extends FormRequest {

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
        $id = $this->perimeter;
        return $rules = [
            'com' => 'required|max:5|unique:perimeters,com,'.$id,
            'nom_com' => 'required|unique:perimeters,nom_com,'.$id,
            'epci' => 'required|max:9,epci,'.$id,
            'dep' => 'required|max:2,dep,'.$id
        ];
    }
 
}
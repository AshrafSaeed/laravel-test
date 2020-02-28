<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
{
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
        $request = $this->request->all();

        if(isset($request['_method']) && $request['_method'] === 'PATCH'){
            return [
                'name' => 'required|max:200',
                'description' => 'required',
            ];
        } else {
            return [
                'name' => 'required|unique:brands|max:200',
                'description' => 'required',
                'brand_logo' => 'required|image|max:1024',
            ];
        }
    }
}

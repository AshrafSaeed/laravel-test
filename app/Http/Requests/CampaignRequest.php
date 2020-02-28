<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CampaignRequest extends FormRequest
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
                'body' => 'required',
                'location' => 'required',
                'brand' => 'required'
            ];
        } else {
            return [
                'name' => 'required|unique:campaigns|max:200',
                'body' => 'required',
                'banner' => 'required|image|max:1024',
                'location' => 'required',
                'brand' => 'required'
            ];
        }
    }
}

<?php

namespace App\Http\Requests\FarmerCommodity;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
    public function rules(){
        return [
            'id_komoditas' => 'required',
            'id_petani' => 'required'
        ];
    }

    public function messages(){
        return [
          'id_komoditas.required' => "Komoditas harus diisi",
          'id_petani.required' => "Petani harus diisi"
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json(["status_code" => 400, "message" => "Validasi Error", "errors" => $errors]));        
    }
}

<?php

namespace App\Http\Requests\Harvest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
          'id_tanam'       => "required",
          'tanggal_panen'   => "required", 
          'jumlah_panen'    => "required"
        ];
    }

    public function messages(){
        return [
            'id_tanam.required'        => "Komoditas Tanam harus diisi",
            'tanggal_panen.required'   => "Tanggal Panen harus diisi",
            'jumlah_panen.required'    => "Jumlah Panen harus diisi",
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json(["status_code" => 400, "message" => "Validasi Error", "errors" => $errors]));        
    }
}

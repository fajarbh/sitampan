<?php

namespace App\Http\Requests\User;

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
            'nik' => "required|unique:users|min:16|max:16",
            'password' => "required|min:8"
        ];
    }

    public function messages(){
        return [
            'nik.required' => "NIK harus diisi",
            'nik.unique' => "NIK sudah terdaftar",
            'nik.min' => "NIK minimal 16 karakter",
            'nik.max' => "NIK maksimal 16 karakter",
            'password.required' => "Password harus diisi",
            'password.min' => "Password minimal 8 karakter",
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json(["status_code" => 400, "message" => "Validasi Error", "errors" => $errors]));        
    }
}

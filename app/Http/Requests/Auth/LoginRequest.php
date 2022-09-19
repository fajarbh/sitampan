<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class LoginRequest extends FormRequest
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
          'nik' => "required|min:16|max:16|exists:users,nik",
          'password' => "required"
        ];
    }

    public function messages(){
        return [
          'nik.required' => "NIK Tidak Boleh Kosong",
          'password.required' => "Password Tidak Boleh Kosong",
          'nik.min' => "NIK Minimal 16 Karakter",
          'nik.max' => "NIK Maksimal 16 Karakter",
          'nik.exists' => "NIK Tidak Terdaftar",
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json(["status_code" => 400, "message" => "Validasi Error", "errors" => $errors]));        
    }
}

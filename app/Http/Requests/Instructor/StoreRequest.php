<?php

namespace App\Http\Requests\Instructor;

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
            'password' => "required|min:8",  
            'nama_penyuluh' => "required|min:3|max:50|unique:penyuluh",
            'alamat' => "required"
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
            'nama_penyuluh.required' => "Nama penyuluh harus diisi",
            'nama_penyuluh.unique' => "Nama penyuluh sudah terdaftar",
            'nama_penyuluh.min' => "Nama penyuluh minimal 3 karakter",
            'nama_penyuluh.max' => "Nama penyuluh maksimal 50 karakter",
            'alamat.required' => "Alamat harus diisi"
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json(["status_code" => 400, "message" => "Validasi Error", "errors" => $errors]));        
    }
}

<?php

namespace App\Http\Requests\Farmer;

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
            'nik'           => "required|unique:users|min:16|max:16",
            'id_kelompok'   => "required",
            'id_desa'       => "required",
            'nama_petani'   => "required",
            'password'      => "required",
            'alamat'        => "required", 
            'status'        => "required"
        ];
    }

    public function messages(){
        return [
            'nik.required' => "NIK tidak boleh kosong",
            'nik.unique'   => "NIK sudah terdaftar",
            'nik.min'      => "NIK minimal 16 karakter",
            'nik.max'      => "NIK maksimal 16 karakter",
            'id_kelompok.required' => "Kelompok tidak boleh kosong",
            'id_desa.required' => "Desa tidak boleh kosong",
            'nama_petani.required' => "Nama petani tidak boleh kosong",
            'nama_petani.unique' => "Nama petani sudah terdaftar",
            'password.required' => "Password tidak boleh kosong",
            'alamat.required' => "Alamat tidak boleh kosong",
            'status.required' => "Status tidak boleh kosong",
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json(["status_code" => 400, "message" => "Validasi Error", "errors" => $errors]));        
    }
}

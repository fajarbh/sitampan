<?php

namespace App\Http\Requests\Commodity;

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
            'nama_komoditas' => "required|unique:komoditas",
            'icon' => "required",
        ];
    }

    public function messages(){
        return [
            'nama_komoditas.required' => "Nama Komoditas Tidak Boleh Kosong",
            'nama_komoditas.unique'   => "Komoditas Sudah Terdaftar",
            'icon.required' => "Icon Komoditas Tidak Boleh Kosong",
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json(["status_code" => 400, "message" => "Validasi Error", "errors" => $errors]));        
    }
}

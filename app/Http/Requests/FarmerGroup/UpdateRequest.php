<?php

namespace App\Http\Requests\FarmerGroup;

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
            'nama_kelompok' => ["required",Rule::unique("kelompok_tani")->ignore($this->id)],
        ];
    }

    public function messages(){
        return [
            'nama_kelompok.required' => "Nama Kelompok Tidak Boleh Kosong",
            'nama_kelompok.unique'   => "Kelompok Sudah Terdaftar",
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json(["status_code" => 400, "message" => "Validasi Error", "errors" => $errors]));        
    }
}

<?php

namespace App\Http\Requests\News;

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
          'judul'        => "required",
          'isi_berita'   => "required", 
          'status'       => "required",
        ];
    }

    public function messages(){
        return [
          'judul.required'        => "Judul harus diisi",
          'isi_berita.required'   => "Isi berita harus diisi",
          'status.required'       => "Status harus diisi",
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json(["status_code" => 400, "message" => "Validasi Error", "errors" => $errors]));        
    }
}

<?php

namespace App\Http\Requests\Plant;

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
          'id_komoditas'    => "required",
          'tanggal_tanam'   => "required", 
          'luas_tanam'      => "required",
          'jumlah_tanam'    => "required",
          'jenis_pupuk'     => "required",
          'biaya_produksi'  => "required", 
        ];
    }

    public function messages(){
        return [
          'id_komoditas.required'   => "Komoditas harus diisi",
          'tanggal_tanam.required'  => "Tanggal tanam harus diisi",
          'luas_tanam.required'     => "Luas tanam harus diisi",
          'jumlah_tanam.required'   => "Jumlah tanam harus diisi",
          'jenis_pupuk.required'    => "Jenis pupuk harus diisi",
          'biaya_produksi.required' => "Biaya produksi harus diisi"
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json(["status_code" => 400, "message" => "Validasi Error", "errors" => $errors]));        
    }
}

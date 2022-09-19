<?php

namespace App\Http\Requests\FarmerPrice;

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
          'id_petani'      => "required",
          'id_komoditas'   => "required",
          'periode_bulan'  => "required", 
          'harga_tani'     => "required",
        ];
    }

    public function messages(){
        return [
          'id_petani' => 'Petani harus diisi',
          'id_komoditas' => 'Komoditas harus diisi',
          'periode_bulan' => 'Periode bulan harus diisi',
          'harga_tani' => 'Harga harus diisi'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json(["status_code" => 400, "message" => "Validasi Error", "errors" => $errors]));        
    }
}

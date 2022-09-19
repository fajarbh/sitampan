<?php

namespace App\Http\Requests\MarketPrice;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateRequest  extends FormRequest
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
          'id_penyuluh'         => "required",
          'id_komoditas'        => "required",
          'periode_bulan'       => "required", 
          'harga_pasar_lokal'   => "required",
          'harga_pasar_induk'   => "required", 
        ];
    }

    public function messages(){
        return [
          'id_penyuluh.required' => "Penyuluh harus diisi",
          'id_komoditas.required' => "Komoditas harus diisi",
          'periode_bulan.required' => "Periode bulan harus diisi",
          'harga_pasar_lokal.required' => "Harga pasar lokal harus diisi",
          'harga_pasar_induk.required' => "Harga pasar induk harus diisi",
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json(["status_code" => 400, "message" => "Validasi Error", "errors" => $errors]));        
    }
}

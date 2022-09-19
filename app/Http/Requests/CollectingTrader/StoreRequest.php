<?php

namespace App\Http\Requests\CollectingTrader;

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
          'nama_pengepul'       => "required|unique:pengepul",
          'alamat'              => "required",
          'kontak'              => "required", 
          'lokasi_distribusi'   => "required"      
        ];
    }

    public function messages(){
        return [
          'nama_pengepul.required' => "Nama Pengepul Tidak Boleh Kosong",
          'nama_pengepul.unique'   => "Pengepul Sudah Terdaftar",
          'alamat.required'        => "Alamat Pengepul Tidak Boleh Kosong",
          'kontak.required'        => "Kontak Pengepul Tidak Boleh Kosong",
          'lokasi_distribusi.required' => "Lokasi Distribusi Tidak Boleh Kosong",
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json(["status_code" => 400, "message" => "Validasi Error", "errors" => $errors]));        
    }
}

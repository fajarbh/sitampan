<?php 

namespace App\Http\Controllers\API;
use App\Http\Requests\Farmer\StoreRequest as RegisterRequest;
use App\Http\Requests\Auth\LoginRequest as LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Farmer as Model;
use App\Models\User;
use App\Helpers\Context;
use Validator;
use DB;
use Hash;
use Helper;
use Str;
use ResponseModel;

class FarmerAuthController extends Controller {

  public function login(LoginRequest $request){    
      $farmer = User::where('nik', $request->nik)
                ->whereIn('level', [3,4])
                ->first();
      if($farmer != NULL){
        
        if($farmer->is_verified == null){
          return ResponseModel::response(400, "Akun Anda Belum Diverifikasi",null);
        }

        if(Hash::check($request->password, $farmer->password)){
            $farmer->update([
                'api_token' => \Str::random(60)
            ]);
            return ResponseModel::response(200, "Login Berhasil", $farmer, 1);
        }else{
          return ResponseModel::response(500, "Password Salah", null);
        }
      }else{
        return ResponseModel::response(500, "NIK Tidak Ditemukan", null);
      }
  }

  public function register(RegisterRequest $request) {

    DB::beginTransaction();
    try {
        // status = 1 (ketua kelompok) / 2 (anggota kelompok) 
        $level = $request['status'] == 1 ? 3 : 4;
        
        $checkFarmerGroup = Helper::checkFarmerGroup($request->id_kelompok, $request->status);
        if($checkFarmerGroup){
            return response()->json(['status_code' => 500,'message' => 'Ketua Kelompok Tani Sudah Terdaftar',"data" => null]);
        }

        $dataUser = User::create([
            'nik'         => $request['nik'],
            'no_hp'       => $request['no_hp'],
            'password'    => bcrypt($request['password']),
            'is_verified' => false,
            'level'       => $level
        ]);

        $data = Model::create([
            'nama_petani'   => $request['nama_petani'],
            'no_hp'         => $request['no_hp'],
            'status'        => $request['status'],
            'alamat'        => $request['alamat'],
            'id_user'       => $dataUser->id,
            'id_kelompok'   => $request['id_kelompok'],
            'id_desa'       => $request['id_desa']
        ]);

      DB::commit();
      return ResponseModel::response(200, "Berhasil Daftar Akun, Silahkan Menunggu Verifikasi", $data, 1);

    }catch (Exception $e) {
      DB::rollback();
      return ResponseModel::response(500, $e->getMessage(), null);
    }
  }

  public function logout(Request $request){
    $farmer = User::find(Context::user()['id']);
    $farmer->update([
      'api_token' => null
    ]);
    return ResponseModel::response(200, "Logout Berhasil", null, 1);
  }

}
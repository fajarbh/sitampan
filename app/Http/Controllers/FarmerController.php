<?php

namespace App\Http\Controllers;

use App\Http\Requests\Farmer\StoreRequest;
use App\Http\Requests\Farmer\UpdateRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Farmer as Model;
use App\Models\User;
use App\Models\Village;
use App\Models\FarmerGroup;
use App\Models\District;
use Illuminate\Support\Facades\Crypt;
use Auth;
use DB;
use DataTables;
use Helper;
use Log;

class FarmerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Admin,Ketua Kelompok Tani');
    }

    public function index()
    {
        return view('admin.farmer-register.index');
    }

    public function api()
    {
        $data = Auth::user()->level == 1 ? Model::where('status',1) : Model::where('id_kelompok',Auth::user()->farmer->id_kelompok)->whereIn('status',[2,3])->get();
        return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nik',function($data){
                    return $data->id_user ? $data->user->nik : '';
                })
                ->addColumn('nama_kelompok',function($data){
                    return $data->farmer_group ? $data->farmer_group->nama_kelompok : '';
                })
                ->addColumn('nama_desa',function($data){
                    return $data->village ? $data->village->nama_desa : '';
                })
                ->addColumn('status',function($data){
                    return Helper::farmerStatus($data->status);
                })
                ->addColumn('action', function($data) {
                    return view("components.action-page", [
                        "edit"      => url("/pendaftaran-petani/edit/".$data->id),
                        "delete"    => url("/pendaftaran-petani/delete/".$data->id),
                    ]);
                })
                ->rawColumns(['action'])
                ->rawColumns(['photo'])
                ->make(true);
    }

    public function create()
    {
        $district = District::all();
        $farmerGroup = Auth::user()->level == 1 ? FarmerGroup::all() : FarmerGroup::where('id',Auth::user()->farmer->id_kelompok)->first();
        return view("admin.farmer-register.create", compact('district','farmerGroup'));
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $level = $request['status'] == 1 ? 3 : 4;
            $checkFarmerGroup = Helper::checkFarmerGroup($request->id_kelompok, $request->status);
            if($checkFarmerGroup){
                return response()->json(['status_code' => 500,'message' => 'Ketua Kelompok Tani Sudah Terdaftar',"data" => null]);
            }
            $is_verified = $request['status'] == 3 ? 0 : 1;
            $dataUser = User::create([
                'nik'         => $request['nik'],
    			'no_hp'       => $request['no_hp'],
                'password'    => bcrypt($request['password']),
                'is_verified' => $is_verified,
                'level'       => $level
    		]);
            $farmerGroup = Auth::user()->level == 1 ? $request['id_kelompok'] : Auth::user()->farmer->id_kelompok;
            $village = Auth::user()->level == 1 ? $request['id_desa'] : Auth::user()->farmer->id_desa;
            $data = Model::create([
                'nama_petani'   => $request['nama_petani'],
                'no_hp'         => $request['no_hp'],
                'status'        => $request['status'],
                'alamat'        => $request['alamat'],
                'id_user'       => $dataUser->id,
                'id_kelompok'   => $farmerGroup,
                'id_desa'       => $village
            ]);

    		DB::commit();
            Log::addToLog("Ditambah ".substr(Model::class, 11)." Id ". $data->id, $data, "-");

            return response()->json(["status_code" => 200, "message" => "Berhasil Menambahkan Data", "data" => $data]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["status_code" => 500, "message" => $e->getMessage(), "data" => null]);
        }
    }

    public function edit($id)
    {
        $data = Model::findOrFail($id);
        $farmerVillage = Village::where('id', $data->id_desa)->first();
        $farmerDistrict = District::where('id', $farmerVillage->id_kecamatan)->first();
        $district = District::all();
        $village = Village::where('id_kecamatan', $farmerDistrict->id)->get();
        $farmerGroup = FarmerGroup::where('id_desa',$farmerVillage->id)->get();
        return view("admin.farmer-register.edit", compact("data","district","village","farmerDistrict","farmerVillage","farmerGroup"));
    }

    public function update(UpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $data       = Model::findOrFail($id);
            $dataUser   = User::findOrFail($data->id_user);
            $dataOld    = Model::findOrFail($id);
            $level = $request['status'] == 1 ? 3 : 4;
            $farmerGroup = Auth::user()->level == 1 ? $request['id_kelompok'] : Auth::user()->farmer->id_kelompok;
            $village = Auth::user()->level == 1 ? $request['id_desa'] : Auth::user()->farmer->id_desa;
            $is_verified = $request['status'] == 3 ? 0 : 1;
            $request['password'] = $request['password'] == null ? $dataUser->password : bcrypt($request['password']);

            $data->update([
                'nama_petani'   => $request['nama_petani'],
                'no_hp'         => $request['no_hp'],
                'status'        => $request['status'],
                'alamat'        => $request['alamat'],
                'id_user'       => $request['id_user'],
                'id_kelompok'   => $farmerGroup,
                'id_desa'       => $village
    		]);

            $dataUser->update([
                'nik'          => $request['nik'],
                'no_hp'        => $request['no_hp'],
                'password'     => $request['password'],
                'is_verified'  => $is_verified,
                'level'        => $level
            ]);

    		DB::commit();
            Log::addToLog("Diubah ".substr(Model::class, 11)." Id ". $data->id, $dataOld, $data);
            return response()->json(["status_code" => 200, "message" => "Berhasil Mengubah Data", "data" => $data]);

        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["status_code" => 500, "message" => $e->getMessage(), "data" => null]);
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try 
        {
            $data = Model::findOrFail($id);
            $data->delete();

            DB::commit();
            Log::addToLog("Dihapus ".substr(Model::class, 11)." Id ". $data->id, $data, "-");

            return response()->json(["status_code" => 200, "message" => "Successfully Deleted Data", "data" => $data]);
        }
        catch (Exception $e) 
        {
            DB::rollback();
            return response()->json(["status_code" => 500, "message" => $e->getMessage(), "data" => null]);
        }
    }
}
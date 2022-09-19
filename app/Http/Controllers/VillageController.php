<?php

namespace App\Http\Controllers;

use App\Http\Requests\Village\StoreRequest;
use App\Http\Requests\Village\UpdateRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Village as Model;
use App\Models\VillageTemp;
use App\Models\District as District;
use Auth;
use DB;
use DataTables;
use Log;
use Helper;

class VillageController extends Controller
{
    public function index()
    {
        return view('admin.village.index');
    }

    public function api()
    {
        return DataTables::of(Model::orderBy("nama_desa", "ASC"))
                ->addIndexColumn()
                ->addColumn('nama_kecamatan', function ($data) {
                    return $data->district ? $data->district->nama_kecamatan : '';
                })
                ->addColumn('action', function($data) {
                    return view("components.action", [
                        "edit"      => url("/desa/edit/".$data->id),
                        "delete"    => url("/desa/delete/".$data->id),
                    ]);
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function create()
    {
        $district = District::all();
        return view("admin.village.create", compact('district'));
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $geoJson = Helper::geoJsonVillage($request['nama_desa']);
            $data = Model::create([
    			'nama_desa' => $request['nama_desa'], 
                'id_kecamatan' => $request['id_kecamatan'],
                'geoJson' => $geoJson
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
        $village = VillageTemp::where('kecamatan_id',$data->id_kecamatan)->get();
        $district = District::all();
        return view("admin.village.edit", compact('village','data','district'));
    }

    public function update(UpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $data       = Model::findOrFail($id);
            $geoJson = Helper::geoJsonVillage($request['nama_desa']);
            $data ->update([
    			'nama_desa'  => $request['nama_desa'],
                'id_kecamatan' => $request['id_kecamatan'],
                'geoJson' => $geoJson
    		]);

    		DB::commit();
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

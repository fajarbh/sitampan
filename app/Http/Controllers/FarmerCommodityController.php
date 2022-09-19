<?php

namespace App\Http\Controllers;

use App\Http\Requests\FarmerCommodity\StoreRequest;
use App\Http\Requests\FarmerCommodity\UpdateRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\FarmerCommodity as Model;
use App\Models\Farmer;
use App\Models\Commodity;

use Auth;
use DB;
use DataTables;
use Log;

class FarmerCommodityController extends Controller
{

    public function index()
    {
        return view('admin.farmer-commodity.index');
    }

    public function api()
    {
        return DataTables::of(Model::orderBy("id_petani", "ASC"))
                ->addIndexColumn()
                ->addColumn('nama_petani', function ($data) {
                    return $data->farmer ? $data->farmer->nama_petani : '';
                })
                ->addColumn('nama_komoditas', function ($data) {
                    return $data->commodity ? $data->commodity->nama_komoditas : '';
                })
                ->addColumn('action', function($data) {
                    return view("components.action", [
                        "edit"      => url("/komoditas-petani/edit/".$data->id),
                        "delete"    => url("/komoditas-petani/delete/".$data->id),
                    ]);
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function create()
    {
        $farmer = Farmer::all();
        $commodity = Commodity::all();
        return view('admin.farmer-commodity.create', compact('farmer','commodity'));
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = Model::create([
                'id_komoditas'  => $request['id_komoditas'], 
                'id_petani'     => $request['id_petani']
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
        $farmer = Farmer::all();
        $commodity = Commodity::all();
        return view("admin.farmer-commodity.edit", compact('data', 'farmer', 'commodity'));
    }

    public function update(UpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $data       = Model::findOrFail($id);
            $dataOld    = Model::findOrFail($id);

            $data ->update([
              'id_komoditas'  => $request['id_komoditas'], 
              'id_petani'     => $request['id_petani']
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

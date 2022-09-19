<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommoditySector\StoreRequest;
use App\Http\Requests\CommoditySector\UpdateRequest;
use Illuminate\Support\Facades\Validator;
use App\Models\CommoditySector as Model;

use Auth;
use DB;
use DataTables;
use Log;

class CommoditySectorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Admin');
    }

    public function index()
    {
        return view('admin.commodity-sector.index');
    }

    public function api()
    {
        return DataTables::of(Model::orderBy("nama_jenis", "ASC"))
                ->addIndexColumn()
                ->addColumn('action', function($data) {
                    return view("components.action", [
                        "edit"      => url("/jenis-komoditas/edit/".$data->id),
                        "delete"    => url("/jenis-komoditas/delete/".$data->id),
                    ]);
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function create()
    {
        return view("admin.commodity-sector.create");
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = Model::create([
    			'nama_jenis'  => ucwords(strtolower($request->nama_jenis))
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
        $data   = Model::findOrFail($id);
        return view("admin.commodity-sector.edit", compact("data"));
    }

    public function update(UpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $data       = Model::findOrFail($id);
            $dataOld    = Model::findOrFail($id);

            $data ->update([
    			'nama_jenis'  => ucwords(strtolower($request->nama_jenis))
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
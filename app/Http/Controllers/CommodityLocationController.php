<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\CommodityLocation as Model;

use Auth;
use DB;
use DataTables;
use Log;

class CommodityLocationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.commodity-location.index');
    }

    public function api(Request $request)
    {
        return DataTables::of(Model::orderBy("long_komoditas", "ASC"))
                ->addIndexColumn()
                ->addColumn('action', function($data) {
                    return view("components.action", [
                        "edit"      => url("/lokasi-komoditas/edit/".$data->id),
                        "delete"    => url("/lokasi-komoditas/delete/".$data->id),
                    ]);
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function create()
    {
        return view("admin.commodity-location.create");
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'long_komoditas'   => "required",
            'lat_komoditas'   => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(["status_code" => 400, "message" => "Validasi Error", "errors" => $validator->errors()]);
        }

        DB::beginTransaction();
        try {
            $data = Model::create([
    			'long_komoditas'  => $request['long_komoditas'], 
                'lat_komoditas'  => $request['lat_komoditas'], 
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
        return view("admin.commodity-location.edit", compact("data"));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'long_komoditas'   => "required",
            'lat_komoditas'   => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(["status_code" => 400, "message" => "Validasi Error", "errors" => $validator->errors()]);
        }

        DB::beginTransaction();
        try {
            $data       = Model::findOrFail($id);
            $dataOld    = Model::findOrFail($id);

            $data ->update([
                'long_komoditas'  => $request['long_komoditas'], 
                'lat_komoditas'  => $request['lat_komoditas'], 
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
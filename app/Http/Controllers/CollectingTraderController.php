<?php

namespace App\Http\Controllers;

use App\Http\Requests\CollectingTrader\StoreRequest;
use App\Http\Requests\CollectingTrader\UpdateRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\CollectingTrader as Model;
use App\Models\Commodity as Commodity;
use App\Models\Instructor as Instructor;

use Auth;
use DB;
use DataTables;
use Log;

class CollectingTraderController extends Controller
{

    public function _construct(){
        $this->middleware('auth');
        $this->middleware('role:Admin,Penyuluh');
    }

    public function index()
    {
        return view('admin.collecting-trader.index');
    }

    public function api()
    {
        
        return DataTables::of(Model::orderBy("nama_pengepul", "ASC"))
        ->addIndexColumn()
        ->addColumn('action', function($data) {
            return view("components.action", [
                "edit"      => url("/pengepul/edit/".$data->id),
                "delete"    => url("/pengepul/delete/".$data->id),
            ]);
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function create()
    {
        return view("admin.collecting-trader.create");
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = Model::create([
                'nama_pengepul'       => $request['nama_pengepul'], 
                'alamat'              => $request['alamat'],
                'kontak'              => $request['kontak'],
                'lokasi_distribusi'   => $request['lokasi_distribusi']
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
        return view("admin.collecting-trader.edit", compact('data'));
    }

    public function update(UpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $data       = Model::findOrFail($id);
            $dataOld    = Model::findOrFail($id);

            $data ->update([
    			'nama_pengepul'       => $request['nama_pengepul'], 
                'alamat'              => $request['alamat'],
                'kontak'              => $request['kontak'],
                'lokasi_distribusi'   => $request['lokasi_distribusi'],
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

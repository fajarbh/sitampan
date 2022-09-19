<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommodityCollector\StoreRequest;
use App\Http\Requests\CommodityCollector\UpdateRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\CollectingTraderCommodity as Model;
use App\Models\CollectingTrader;
use App\Models\Instructor;
use App\Models\Commodity;
use App\Models\CommoditySector;
use Auth;
use DB;
use DataTables;
use Log;

class CollectingTraderCommodityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Admin,Penyuluh');
    }

    public function index()
    {   
        return view('admin.collecting-trader-commodity.index');
    }

    public function api()
    {
        $data = Auth::user()->level == 2 ? Model::where('id_penyuluh', Auth::user()->instructor->id)->get() : Model::orderBy("id_pengepul", "ASC");
        return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama_pengepul', function ($data) {
                    return $data->collecting_trader ? $data->collecting_trader->nama_pengepul : '';
                })
                ->addColumn('nama_komoditas', function ($data) {
                    return $data->commodity ? $data->commodity->nama_komoditas : '';
                })
                ->addColumn('harga', function ($data) {
                    return 'Rp '.number_format($data->harga, 0, ',', '.');
                })
                ->addColumn('nama_penyuluh', function ($data) {
                    return $data->instructor ? $data->instructor->nama_penyuluh : '';
                })
                ->addColumn('action', function($data) {
                    return view("components.action", [
                        "edit"      => url("/komoditas-pengepul/edit/".$data->id),
                        "delete"    => url("/komoditas-pengepul/delete/".$data->id),
                    ]);
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function create()
    {
        $pengepul = CollectingTrader::all();
        $penyuluh = Auth::user()->level == 2 ? Instructor::where('id_user', Auth::user()->id)->first() : Instructor::all();
        $commoditySector = CommoditySector::all();
        return view('admin.collecting-trader-commodity.create', compact('pengepul', 'penyuluh', 'commoditySector'));
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = Model::create([
                'id_komoditas'  => $request['id_komoditas'], 
                'id_pengepul'   => $request['id_pengepul'], 
                'id_penyuluh'   => $request['id_penyuluh'], 
                'harga'         => str_replace('.', '', $request['harga']),
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
        $pengepul = CollectingTrader::all();
        $penyuluh = Auth::user()->level == 2 ? Instructor::where('id_user', Auth::user()->id)->first() : Instructor::all();
        $commoditySector = CommoditySector::all();
        $commodity = Commodity::all();
        return view("admin.collecting-trader-commodity.edit", compact('data', 'pengepul', 'penyuluh', 'commodity','commoditySector'));
    }

    public function update(UpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $data       = Model::findOrFail($id);
            $dataOld    = Model::findOrFail($id);

            $data ->update([
                'id_komoditas'  => $request['id_komoditas'], 
                'id_pengepul'   => $request['id_pengepul'], 
                'id_penyuluh'   => $request['id_penyuluh'], 
                'harga'         => str_replace('.', '', $request['harga'])
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

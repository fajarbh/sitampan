<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarketPrice\StoreRequest;
use App\Http\Requests\MarketPrice\UpdateRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\MarketPrice as Model;
use App\Models\Commodity;
use App\Models\Instructor;

use Auth;
use DB;
use DataTables;
use Log;
 
class MarketPriceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Admin,Penyuluh');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.market-price.index');
    }

    public function api()
    {
        $data = Auth::user()->level == 2 ? Model::where('id_penyuluh', Auth::user()->instructor->id)->get() : Model::orderBy("id_komoditas", "ASC");
        return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('id_penyuluh', function ($data) {
                    return $data->instructor ? $data->instructor->nama_penyuluh : '';
                })
                ->addColumn('id_komoditas', function ($data) {
                    return $data->commodity ? $data->commodity->nama_komoditas : '';
                })
                ->addColumn('periode_bulan', function ($data) {
                    return $data->periode_bulan;
                })
                ->addColumn('harga_pasar_lokal', function ($data) {
                    return $data->harga_pasar_lokal;
                })
                ->addColumn('harga_pasar_induk', function ($data) {
                    return $data->harga_pasar_induk;
                })
                ->addColumn('action', function($data) {
                    return view("components.action", [
                        "edit"      => url("/harga-pasar/edit/".$data->id),
                        "delete"    => url("/harga-pasar/delete/".$data->id),
                    ]);
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function create()
    {
        $komoditas = Commodity::all();
        $penyuluh = Auth::user()->level == 2 ? Instructor::where('id_user', Auth::user()->id)->first() : Instructor::all();
        return view('admin.market-price.create', compact('penyuluh', 'komoditas'));
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = Model::create([
                'id_penyuluh'         => $request['id_penyuluh'],
                'id_komoditas'        => $request['id_komoditas'],
                'periode_bulan'       => $request['periode_bulan'],
                'harga_pasar_lokal'   => str_replace('.','',$request['harga_pasar_lokal']),
                'harga_pasar_induk'   => str_replace('.','',$request['harga_pasar_induk'])
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
        $komoditas = Commodity::all();
        $penyuluh = Auth::user()->level == 2 ? Instructor::where('id_user', Auth::user()->id)->first() : Instructor::all();
        return view('admin.market-price.edit', compact('data','komoditas', 'penyuluh'));
    }

    public function update(UpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $data       = Model::findOrFail($id);
            $dataOld    = Model::findOrFail($id);
    
            $data ->update([
    			'id_penyuluh'         => $request['id_penyuluh'],
                'id_komoditas'        => $request['id_komoditas'],
                'periode_bulan'       => $request['periode_bulan'],
                'harga_pasar_lokal'   => str_replace('.','',$request['harga_pasar_lokal']),
                'harga_pasar_induk'   => str_replace('.','',$request['harga_pasar_induk']),
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
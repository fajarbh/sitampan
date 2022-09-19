<?php

namespace App\Http\Controllers;

use App\Http\Requests\FarmerPrice\StoreRequest;
use App\Http\Requests\FarmerPrice\UpdateRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\FarmerPrice as Model;
use App\Models\Commodity as Commodity;
use App\Models\Farmer as Farmer;

use Auth;
use DB;
use DataTables;
use Log;
 
class FarmerPriceController extends Controller
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
        return view('admin.farmer-price.index');
    }

    public function api()
    {
        return DataTables::of(Model::orderBy("id_petani", "ASC"))
                ->addIndexColumn()
                ->addColumn('id_petani', function ($data) {
                    return $data->farmer ? $data->farmer->nama_petani : '';
                })
                ->addColumn('id_komoditas', function ($data) {
                    return $data->commodity ? $data->commodity->nama_komoditas : '';
                })
                ->addColumn('periode_bulan', function ($data) {
                    return $data->periode_bulan;
                })
                ->addColumn('harga_tani', function ($data) {
                    return $data->harga_tani;
                })
                ->addColumn('action', function($data) {
                    return view("components.action", [
                        "edit"      => url("/harga-petani/edit/".$data->id),
                        "delete"    => url("/harga-petani/delete/".$data->id),
                    ]);
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function create()
    {
        $komoditas = Commodity::all();
        $petani = Farmer::all();
        return view('admin.farmer-price.create', compact('petani', 'komoditas'));
    }

    public function store(StoreRequest $request)
    {

        DB::beginTransaction();
        try {
            $data = Model::create([
                'periode_bulan'  => $request['periode_bulan'],
                'harga_tani'     => $request['harga_tani'],
                'id_komoditas'   => $request['id_komoditas'],
                'id_petani'      => $request['id_petani'],
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
        $petani = Farmer::all();
        return view('admin.farmer-price.edit', compact('data','komoditas', 'petani'));
    }

    public function update(UpdateRequest $request, $id)
    {

        DB::beginTransaction();
        try {
            $data       = Model::findOrFail($id);
            $dataOld    = Model::findOrFail($id);
            
            $data ->update([
                'periode_bulan'  => $request['periode_bulan'],
                'harga_tani'     => $request['harga_tani'],
                'id_komoditas'   => $request['id_komoditas'],
                'id_petani'      => $request['id_petani'],
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
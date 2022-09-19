<?php

namespace App\Http\Controllers;

use App\Http\Requests\Commodity\StoreRequest;
use App\Http\Requests\Commodity\UpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Commodity as Model;
use App\Models\CommoditySector as CommoditySector;

use Auth;
use DB;
use DataTables;
use Log;
 
class CommodityController extends Controller
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
        return view('admin.commodity.index');
    }

    public function api()
    {
        return DataTables::of(Model::orderBy("nama_komoditas", "ASC"))
                ->addIndexColumn()
                ->addColumn('jenis_komoditas', function ($data) {
                    return $data->commodity_sector ? $data->commodity_sector->nama_jenis : '';
                })
                ->addColumn('icon', function ($data) {
                    return 
                        $data->icon != null ? "<img src='".asset("uploads/".$data->icon)."' width='30px' height='30px'>" : null;    
                    ;            
                })
                ->addColumn('action', function($data) {
                    return view("components.action", [
                        "edit"      => url("/komoditas/edit/".$data->id),
                        "delete"    => url("/komoditas/delete/".$data->id),
                    ]);
                })
                ->rawColumns(['action'])
                ->rawColumns(['icon'])
                ->make(true);
    }

    public function create()
    {
        $jenisKomoditas = CommoditySector::all();
        return view('admin.commodity.create', compact('jenisKomoditas'));
    }

    public function store(StoreRequest $request)
    {
        if ($request->file('icon') != null) {
            $icon  = $request->file('icon')->store("iconkomoditas");
        }

        DB::beginTransaction();
        try {
            $data = Model::create([
    			'nama_komoditas'  => $request['nama_komoditas'],
                'icon' => $icon,
                'id_jenis' => $request['id'],
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
        $jenisKomoditas = CommoditySector::all();
        return view('admin.commodity.edit', compact('data', 'jenisKomoditas'));
    }

    public function update(UpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $data       = Model::findOrFail($id);
            $dataOld    = Model::findOrFail($id);
            
            if($request->file('icon') != null)
        	{
        		$icon = $request->file('icon')->store('iconkomoditas');
        	}
        	else
        	{
        		$icon = $data->icon;
        	}

            $data ->update([
    			'nama_komoditas'  => $request['nama_komoditas'],
                'icon' => $icon,
                'id_jenis' => $request['id_jenis'],
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
<?php

namespace App\Http\Controllers;

use App\Http\Requests\Harvest\StoreRequest;
use App\Http\Requests\Harvest\UpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Harvest as Model;
use App\Models\Farmer;
use App\Models\FarmerGroup;
use App\Models\Commodity;
use App\Models\Plant;
use Helper;
use Auth;
use DB;
use DataTables;
use Log;
 
class HarvestController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Ketua Kelompok Tani');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $id = Auth::user()->farmer->id;
        $farmerGroup = FarmerGroup::find($id);
        return view('admin.harvest.index', compact('farmerGroup'));
    }

    public function api(Request $request)
    {
        return DataTables::of(Farmer::where('id_kelompok',Auth::user()->farmer->id_kelompok)->orderBy("nama_petani", "ASC"))
            ->addIndexColumn()
            ->addColumn('nama_desa', function($data){
                return $data->id_desa ? $data->village->nama_desa : '-';
            })
            ->addColumn('status', function($data){
                return Helper::farmerStatus($data->status);
            })
            ->addColumn('action', function($data) {
                return view("components.farming", [
                    "edit"      => url("/panen/".$data->id),
                    "title"     => 'Kelola Panen',
                ]);
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    public function detail(Request $request,$id)
    {
        $data = Farmer::findOrFail($id);
        [$getHarvest, $geoJson, $center] = null;
        if($request->query('tanggal_panen') != null ){
            $month = date('m',strtotime($request->query('tanggal_panen')));
            $year = date('Y',strtotime($request->query('tanggal_panen')));
            $getHarvest = Model::where('id_petani', $id)->whereMonth('tanggal_panen',$month)->whereYear('tanggal_panen',$year)->get();
            if($getHarvest->count() > 0){
                $geoJson = $data->village->geoJson;
                $center = json_encode($geoJson['coordinates'][0][0][0]);
            }
        }
        return view('admin.harvest.detail', compact('data','geoJson','center','getHarvest'));
    }

    public function create($id)
    {
        $data = Farmer::findOrFail($id);
        return view('admin.harvest.create', compact('data'));
    }

    public function getCommodity(Request $request)
    {   
        $farmer = $request->id_petani;
        $month = date('m',strtotime($request->tanggal_tanam));
        $year = date('Y',strtotime($request->tanggal_tanam));
        try{
            $data = Plant::where('id_petani', $farmer)->whereMonth('tanggal_tanam',$month)->whereYear('tanggal_tanam',$year)->get();
            if($data->count() > 0){
                return response()->json(['status_code' => 200,'message'=>'Berhasil Menampilkan Komoditas','data' => $data]);
            }else{
                return response()->json(['status_code' => 500,'message'=>'Komoditas Tidak Ditemukan']);
            }
        }catch(Exception $e){  
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $plant = Plant::where('id', $request->id_tanam)->first();
            
            $checkPlant = Helper::checkHarvest($request->id_tanam);
            if($checkPlant){
                return response()->json(['status_code' => 500,'message' => 'Komoditas sudah dipanen pada tanggal tersebut']);
            } 
    
            $data = Model::create([
                'id_petani'       => $plant->id_petani,
                'id_tanam'        => $request['id_tanam'],
                'id_komoditas'    => $plant->commodity->id,
                'tanggal_panen'   => $request['tanggal_panen'],
                'jumlah_panen'    => $request['jumlah_panen'],
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
        $month  = date('m',strtotime($data->plant->tanggal_tanam));
        $year   = date('Y',strtotime($data->plant->tanggal_tanam));
        $commodityPlant = Plant::whereMonth('tanggal_tanam',$month)->whereYear('tanggal_tanam',$year)->where('id_petani',$data->id_petani)->get();
        return view('admin.harvest.edit', compact('data','commodityPlant'));
    }

    public function update(UpdateRequest $request, $id)
    {

        DB::beginTransaction();
        try {
            $data       = Model::findOrFail($id);
            $dataOld    = Model::findOrFail($id);
            
            $plant = Plant::where('id', $request->id_tanam)->first();
            
            if($data->id_tanam != $request->id_tanam){
                $checkPlant = Helper::checkHarvest($request->id_tanam);
                if($checkPlant){
                    return response()->json(['status_code' => 500,'message' => 'Komoditas sudah dipanen pada tanggal tersebut']);
                } 
            }
    
            $data->update([
                'id_petani'       => $plant->id_petani,
                'id_tanam'        => $request['id_tanam'],
                'id_komoditas'    => $plant->commodity->id,
                'tanggal_panen'   => $request['tanggal_panen'],
                'jumlah_panen'    => $request['jumlah_panen'],
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
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Plant\StoreRequest;
use App\Http\Requests\Plant\UpdateRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Plant as Model;
use App\Models\Farmer;
use App\Models\FarmerCommodity;
use App\Models\FarmerGroup;
use App\Models\Commodity;
use App\Models\CommoditySector;
use Helper;
use Auth;
use DB;
use DataTables;
use Log;
 
class PlantController extends Controller
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
        return view('admin.plant.index', compact('farmerGroup'));
    }

    // public function farmerGroupByVillage(Request $request)
    // {
    //   try{
    //     $data = FarmerGroup::where('id_desa', $request->id_desa)->get();
    //     if($data->count() > 0){
    //         return response()->json(['status_code' => 200,'message'=>'Berhasil Menampilkan Kelompok Tani','data' => $data]);
    //     }else{
    //         return response()->json(['status_code' => 400,'message' => 'Data tidak ditemukan']);
    //     }
    //   }catch(\Exception $e){
    //     return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
    //   }
    // }

    // public function farmerByFarmerGroup($id){
    //     $farmerGroup = FarmerGroup::find($id);
    //     return view('admin.plant.farmer', compact('farmerGroup'));
    // }

    public function api()
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
                        "edit"      => url("/tanam/".$data->id),
                        "title"     => 'Kelola Tanam',
                    ]);
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
    }

    public function create($id)
    {
        $commoditySector = CommoditySector::all();
        $data = Farmer::findOrFail($id);
        $geoJson = $data->village->geoJson;
        $center = json_encode($geoJson['coordinates'][0][0][0]);
        return view('admin.plant.create', compact('data','geoJson','center','commoditySector'));
    }

    public function detail(Request $request,$id)
    {  
        $data = Farmer::findOrFail($id);
        [$getPlant, $geoJson, $center] = null;
        if($request->query('tanggal_tanam') != null ){
            $month = date('m',strtotime($request->query('tanggal_tanam')));
            $year = date('Y',strtotime($request->query('tanggal_tanam')));
            $getPlant = Model::where('id_petani', $id)->whereMonth('tanggal_tanam',$month)->whereYear('tanggal_tanam',$year)->get();
            if($getPlant->count() > 0){
                $geoJson = $data->village->geoJson;
                $center = json_encode($geoJson['coordinates'][0][0][0]);
            }
        }
        return view('admin.plant.detail', compact('data','geoJson','center','getPlant'));
    }

    public function edit($id)
    {
        $data = Model::findOrFail($id);
        $farmer = Farmer::findOrFail($data->id_petani);
        $commodity = Commodity::all();
        $commoditySector = CommoditySector::all();
        return view('admin.plant.edit', compact('farmer','data','commodity','commoditySector'));
    }

    public function store(StoreRequest $request)
    {
        $checkPlant = Helper::checkPlant($request->id_petani, $request->id_komoditas, $request->tanggal_tanam);
        if($checkPlant){
            return response()->json(['status_code' => 500,'message' => 'Komoditas sudah ditanam pada tanggal tersebut']);
        } 
        DB::beginTransaction();
        try {
            $data = Model::create([
                'id_komoditas'      => $request['id_komoditas'],
                'id_petani'         => $request['id_petani'],
                'tanggal_tanam'     => $request['tanggal_tanam'],
                'jumlah_tanam'      => $request['jumlah_tanam'],
                'luas_tanam'        => $request['luas_tanam'],
                'jenis_pupuk'       => $request['jenis_pupuk'],
                'biaya_produksi'    => str_replace('.', '', $request['biaya_produksi']),
                'longitude'         => $request['longitude'],
                'latitude'          => $request['latitude']
    		]);

    		DB::commit();
            Log::addToLog("Ditambah ".substr(Model::class, 11)." Id ". $data->id, $data, "-");

            return response()->json(["status_code" => 200, "message" => "Berhasil Menambahkan Data", "data" => $data]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["status_code" => 500, "message" => $e->getMessage(), "data" => null]);
        }
    
    }
    
    public function update(UpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $data       = Model::findOrFail($id);
            $dataOld    = Model::findOrFail($id);
            
            if($request->id_petani != $data->id_petani OR $request->id_komoditas != $data->id_komoditas OR $request->tanggal_tanam != $data->tanggal_tanam){
                $checkPlant = Helper::checkPlant($request->id_petani, $request->id_komoditas, $request->tanggal_tanam);
                if($checkPlant){
                    return response()->json(['status_code' => 500,'message' => 'Komoditas sudah ditanam pada tanggal tersebut']);
                } 
            }
            
            $data->update([
                'id_komoditas'      => $request['id_komoditas'],
                'tanggal_tanam'     => $request['tanggal_tanam'],
                'jumlah_tanam'      => $request['jumlah_tanam'],
                'luas_tanam'        => $request['luas_tanam'],
                'jenis_pupuk'       => $request['jenis_pupuk'],
                'biaya_produksi'    => str_replace('.', '', $request['biaya_produksi'])
    		]);

    		DB::commit();
            Log::addToLog("Diubah ".substr(Model::class, 11)." Id ". $data->id, $dataOld, $data);

            return response()->json(["status_code" => 200, "message" => "Berhasil Mengubah Data", "data" => $data]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["status_code" => 500, "message" => $e->getMessage(), "data" => null]);
        }
    }
   
}
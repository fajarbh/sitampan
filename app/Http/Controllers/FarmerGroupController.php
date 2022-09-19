<?php

namespace App\Http\Controllers;

use App\Http\Requests\FarmerGroup\StoreRequest;
use App\Http\Requests\FarmerGroup\UpdateRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\FarmerGroup as Model;
use App\Models\Village;
use App\Models\District;
use App\Models\Instructor;
use Auth;
use DB;
use DataTables;
use Log;
use Helper;
 
class FarmerGroupController extends Controller
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
        return view('admin.farmer-group.index');
    }

    public function api()
    {
        return DataTables::of(Model::orderBy("nama_kelompok", "ASC"))
                ->addIndexColumn()
                ->addColumn('nama_penyuluh', function ($data) {
                    return $data->instructor ? $data->instructor->nama_penyuluh : '';
                })
                ->addColumn('nama_desa', function ($data) {
                    return $data->village ? $data->village->nama_desa : '';
                })
                ->addColumn('icon', function ($data) {
                    return 
                        $data->icon != null ? "<img src='".asset("uploads/".$data->icon)."' width='30px' height='30px'>" : null;    
                    ;            
                })
                ->addColumn('action', function($data) {
                    return view("components.action", [
                        "edit"      => url("/kelompok-tani/edit/".$data->id),
                        "delete"    => url("/kelompok-tani/delete/".$data->id),
                    ]);
                })
                ->rawColumns(['action'])
                ->rawColumns(['icon'])
                ->make(true);
    }

    public function create()
    {
        $village    = Village::all();
        $district   = District::all();
        $instructor = Instructor::all();
        return view('admin.farmer-group.create', compact('village','instructor','district'));
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {

            $checkInstructor = Helper::checkInstructorFarmerGroup($request->id_desa,$request->id_penyuluh);
            if($checkInstructor){
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Penyuluh sudah ada pada kelompok tani di desa tersebut'
                ]);
            }

            $data = Model::create([
    			'id_penyuluh'   => $request['id_penyuluh'],
                'nama_kelompok' => $request['nama_kelompok'],
                'id_desa'       => $request['id_desa'],
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
        $data       = Model::findOrFail($id);
        $farmerGroupVillage = Village::where('id', $data->id_desa)->first();
        $farmerGroupDistrict = District::where('id', $farmerGroupVillage->id_kecamatan)->first();
        $district = District::all();
        $village = Village::where('id_kecamatan', $farmerGroupDistrict->id)->get();
        $instructor = Instructor::all();
        return view('admin.farmer-group.edit', compact('data', 'village','instructor','district','farmerGroupVillage','farmerGroupDistrict'));
    }

    public function update(UpdateRequest $request, $id)
    {

        DB::beginTransaction();
        try {
            $data       = Model::findOrFail($id);
            $dataOld    = Model::findOrFail($id);
            
            if($request->id_desa != $data->id_desa){
                $checkInstructor = Helper::checkInstructorFarmerGroup($request->id_desa,$request->id_penyuluh);
                if($checkInstructor){
                    return response()->json([
                        'status_code' => 500,
                        'message' => 'Penyuluh sudah ada pada kelompok tani di desa tersebut'
                    ]);
                }
            }

            $data->update([
    			'id_penyuluh'   => $request['id_penyuluh'],
                'nama_kelompok' => $request['nama_kelompok'],
                'id_desa'       => $request['id_desa'],
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
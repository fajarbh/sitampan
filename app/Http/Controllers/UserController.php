<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\User as Model;
use Auth;
use DB;
use DataTables;
use Helper;
use Log;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Admin');
    }

    public function index()
    {
        return view('admin.user.index');
    }

    public function api()
    {
        return DataTables::of(Model::orderBy("no_hp", "ASC"))
                ->addIndexColumn()
                ->addColumn('nik', function($data) {
                    return $data->nik;
                })
                ->addColumn('level', function($data) {
                    return Helper::roleName($data->level);
                })
                ->addColumn('action', function($data) {
                    return view("components.action", [
                        "edit"      => url("/akun/edit/".$data->id),
                        "delete"    => url("/akun/delete/".$data->id),
                    ]);
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function create()
    {
        return view("admin.user.create");
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = Model::create([
                'nik'       => $request['nik'],
    			'no_hp'     => $request['no_hp'],
                'password'  => bcrypt($request['password']),
                'level'     => $request['level'],
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
        return view("admin.user.edit", compact("data"));
    }

    public function update(UpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $data       = Model::findOrFail($id);
            $dataOld    = Model::findOrFail($id);
            
            $request['password'] = $request['password'] == null ? $data->password : bcrypt($request['password']);
            
            $data ->update([
                'nik'       => $request['nik'],
    			'no_hp'     => $request['no_hp'],
                'password'  => $request['password']
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
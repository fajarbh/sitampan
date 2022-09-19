<?php

namespace App\Http\Controllers;

use App\Http\Requests\Instructor\StoreRequest;
use App\Http\Requests\Instructor\UpdateRequest;
use App\Models\Instructor as Model;
use App\Models\User;
use Auth;
use DB;
use DataTables;
use Helper;
use Log;

class InstructorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Admin');
    }

    public function index()
    {
        return view('admin.instructor.index');
    }

    public function api()
    {
        return DataTables::of(Model::orderBy("nama_penyuluh", "ASC"))
                ->addIndexColumn()
                ->addColumn('nik', function($data) {
                    return $data->nik;
                })
                ->addColumn('no_hp', function($data) {
                    return $data->user ? $data->user->no_hp : '';
                })
                ->addColumn('action', function($data) {
                    return view("components.action", [
                        "edit"      => url("/pendaftaran-penyuluh/edit/".$data->id),
                        "delete"    => url("/pendaftaran-penyuluh/delete/".$data->id),
                    ]);
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function create()
    {
        return view("admin.instructor.create");
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {

            $dataUser = User::create([
                'nik'       => $request['nik'],
                'no_hp'     => $request['no_hp'],
                'password'  => bcrypt($request['password']), 
                'is_verified' => 1,
                'level'     => 2
            ]);

            $data = Model::create([
    			'nama_penyuluh' => $request['nama_penyuluh'],
                'kontak'        => $request['no_hp'],
                'alamat'        => $request['alamat'],
                'id_user'       => $dataUser->id
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
        return view("admin.instructor.edit", compact("data"));
    }

    public function update(UpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $data       = Model::findOrFail($id);
            $dataUser   = User::findOrFail($data->id_user);
            $dataOld    = Model::findOrFail($id);
            
            $request['password'] = $request['password'] == null ? $data->password : Crypt($request->password, 'sitampan');
            
            $data->update([
    			'nama_penyuluh'  => $request['nama_penyuluh'],
                'kontak'         => $request['no_hp'],
                'alamat'         => $request['alamat']
    		]);

            $dataUser->update([
                'nik'       => $request['nik'],
                'no_hp'     => $request['no_hp']
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
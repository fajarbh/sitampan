<?php

namespace App\Http\Controllers;

use App\Http\Requests\News\StoreRequest;
use App\Http\Requests\News\UpdateRequest;
use Illuminate\Support\Facades\Validator;
use App\Models\News as Model;
use App\Models\User;
use Auth;
use DB;
use DataTables;
use Log;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Admin,Ketua Kelompok Tani');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.news.index');
    }

    public function api()
    {
        $data = Auth::user()->level == 1 ? Model::orderBy("created_at", "DESC") : Model::where("id_user", Auth::user()->id)->orderBy("created_at", "DESC");
        return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('judul', function($data) {
                    return Str::limit($data->judul,30);
                })
                ->addColumn('no_hp', function($data) {
                    return $data->user ? $data->user->nik : '';
                })
                ->addColumn('status', function($data) {
                    return $data->is_verified == 1 ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Tidak Aktif</span>';
                })
                ->addColumn('foto', function($data) {
                    return $data->foto != null ? "<img src='".asset('uploads/'.$data->foto)."' width='30px' height='30px'>" : null;
                    ;
                })
                ->addColumn('action', function($data) {
                    return view("components.action-page", [
                        "edit"            => url("/berita/edit/".$data->id),
                        "delete"          => url("/berita/delete/".$data->id),
                    ]);
                })
                ->rawColumns(['action','status'])
                ->make(true);
    }

    public function create()
    {
        return view("admin.news.create");
    }

    public function store(StoreRequest $request)
    {
        if ($request->file('image') != null) {
            $image  = $request->file('image')->store("fotoberita");
        }else{
            $image = null;
        }
        DB::beginTransaction();

        try {
            $data = Model::create([
    			'judul'         => $request['judul'], 
    			'isi_berita'    => $request['isi_berita'], 
                'gambar'        => $image,
    			'is_verified'   => (int)$request['status'] == 0 ? false : true, 
                'id_user'       => Auth::user()->id
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
        return view("admin.news.edit", compact("data"));
    }

    public function update(UpdateRequest $request, $id)
    {

        DB::beginTransaction();
        try {
            $data       = Model::findOrFail($id);
            $dataOld    = Model::findOrFail($id);

            if($request->file('image') != null){
                $image = $request->file('image')->store("fotoberita");
            }else{
                $image = $data->gambar;
            }

            $data->update([
    			'judul'         => $request['judul'], 
    			'isi_berita'    => $request['isi_berita'], 
                'gambar'        => $image,
    			'is_verified'   => (int)$request['status'] == 0 ? false : true, 
                'id_user'       => Auth::user()->id
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
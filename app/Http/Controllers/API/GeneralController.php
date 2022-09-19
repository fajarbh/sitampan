<?php

namespace App\Http\Controllers\API;
use App\Models\Village;
use App\Models\VillageTemp;
use App\Models\Farmer;
use App\Models\FarmerGroup;
use App\Models\District;
use App\Models\News;
use App\Models\Commodity;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use ResponseModel;
use Context;

class GeneralController extends controller {


    public function getNews(Request $request)
    {
        $data = News::where('is_verified', 1)->paginate(10);
        return ResponseModel::response(200, "GET", $data);
    }

    public function getDetailNews($id)
    {
        $data = News::find($id);
        return ResponseModel::response(200, "GET", $data);
    }

    public function district()
    {
        $data = District::get();
        return ResponseModel::response(200, "GET", $data, count($data));
    }

    public function village($id)
    {
        $data = VillageTemp::where('kecamatan_id', $id)->get();
        return ResponseModel::response(200, "GET", $data);
    }
    
    public function villageGeo($id)
    {
        $data = Village::where('id_kecamatan', $id)->get();
        return ResponseModel::response(200, "GET", $data);
    }    

    public function commoditySector()
    {
        $data = DB::table('jenis_komoditas')->get();
        return ResponseModel::response(200, "GET", $data);
    }

    public function commodity($id)
    {
        $data = Commodity::where('id_jenis',$id)->get();
        return ResponseModel::response(200, "GET", $data);
    }

    public function getFarmerWithCommodity($name)
    {
        $komoditas = DB::table('tanam')
                ->join('petani', 'tanam.id_petani', '=', 'petani.id')
                ->join('komoditas', 'tanam.id_komoditas', '=', 'komoditas.id')
                ->select('komoditas.id', 'komoditas.nama_komoditas')
                ->where('petani.nama_petani', $name)
                ->get();

        $petani = DB::table('petani')
                ->join('kelompok_tani', 'petani.id_kelompok', '=', 'kelompok_tani.id')
                ->join('desa', 'petani.id_desa', '=', 'desa.id')
                ->select('petani.id',
                            'petani.nama_petani', 
                            'desa.nama_desa', 
                            'petani.no_hp', 
                            'petani.alamat', 
                            'kelompok_tani.nama_kelompok',
                            'petani.status')
                ->where('petani.nama_petani', $name)
                ->get();
        
        return ResponseModel::response(200, "GET", [$petani, $komoditas]);
    }

    public function getCollector($name)
    {
        $pengepul = DB::table('pengepul AS p')
                ->join('komoditas_pengepul AS kp', 'kp.id_pengepul', '=', 'p.id')
                ->join('komoditas AS k', 'kp.id_komoditas', '=', 'k.id')
                ->select('p.nama_pengepul', 'k.nama_komoditas', 'p.lokasi_distribusi', 'p.kontak', 'p.alamat', 'kp.harga')
                ->where('p.nama_pengepul', $name)
                ->get();
        
                return ResponseModel::response(200, "GET", $pengepul);
    }

    public function getInstructor($name)
    {
        $penyuluh = DB::table('kelompok_tani AS kt')
                ->join('penyuluh AS p', 'kt.id_penyuluh', '=', 'p.id')
                ->join('desa AS d', 'kt.id_desa', '=', 'd.id')
                ->select('d.nama_desa', 'p.nama_penyuluh', 'p.kontak', 'p.alamat')
                ->where('p.nama_penyuluh', $name)
                ->get();
        
        return ResponseModel::response(200, "GET", $penyuluh);
    }

    public function getPlant($name)
    {
        $tanam = DB::table('tanam AS t')
                ->join('petani AS p', 't.id_petani', '=', 'p.id')
                ->join('desa AS d', 'p.id_desa', '=', 'd.id')
                ->join('komoditas AS k', 't.id_komoditas', '=', 'k.id')
                ->join('kelompok_tani AS kt', 'kt.id', '=', 'p.id_kelompok')
                ->select('d.nama_desa', 'kt.nama_kelompok', 'k.nama_komoditas', 'p.nama_petani', 't.tanggal_tanam', 't.jumlah_tanam', 't.luas_tanam', 't.biaya_produksi', 't.jenis_pupuk')
                ->where('d.nama_desa', $name)
                ->get();
        
        return ResponseModel::response(200, "GET", $tanam);
    }


    public function getHarvest($name)
    {
        $panen = DB::table('panen AS p')
                ->join('petani AS p2', 'p.id_petani', '=', 'p2.id')
                ->join('tanam AS t', 'p.id_tanam', '=', 't.id')
                ->join('desa AS d', 'p2.id_desa', '=', 'd.id')
                ->join('komoditas AS k', 't.id_komoditas', '=', 'k.id')
                ->join('kelompok_tani AS kt', 'kt.id', '=', 'p2.id_kelompok')
                ->select('d.nama_desa', 'p2.nama_petani', 'kt.nama_kelompok', 'k.nama_komoditas', 'd.nama_desa AS lokasi_petani', 'p.tanggal_panen', 'p.jumlah_panen')
                ->where('d.nama_desa', $name)
                ->get();
        
        return ResponseModel::response(200, "GET", $panen);
    }

    public function getCommodityPrice($name)
    {
        $komoditas = DB::table('komoditas AS k')
        ->join('komoditas_pengepul AS kp', 'kp.id_komoditas', '=', 'k.id')
        ->join('harga_pasar AS hp', 'hp.id_komoditas', '=', 'k.id')
        ->select('k.nama_komoditas', 'kp.harga', 'hp.harga_pasar_lokal', 'hp.harga_pasar_induk')
        ->where('k.nama_komoditas', $name)
        ->get();
        return ResponseModel::response(200, "GET", $komoditas);
    }

    public function farmerGroupByName($name)
    {
        $totalFarmerByGroup = DB::table('petani AS p')
                            ->join('kelompok_tani AS kt', 'p.id_kelompok', '=', 'kt.id')
                            ->where('kt.nama_kelompok',$name)
                            ->whereIn('status',[2,3])
                            ->count();

        $kelompok_tani = DB::table('kelompok_tani AS kt')
                ->join('desa AS d', 'kt.id_desa', '=', 'd.id')
                ->join('petani AS p', 'p.id_kelompok', '=', 'kt.id')
                ->join('tanam AS t', 't.id_petani', '=', 'p.id')
                ->join('komoditas AS k', 't.id_komoditas', '=', 'k.id')
                ->join('panen AS p2', 'p2.id_tanam', '=', 't.id')
                ->select('kt.nama_kelompok', 'd.nama_desa', 'k.nama_komoditas', 'd.nama_desa AS alamat', 't.longitude', 't.latitude', 't.jumlah_tanam', 'p2.jumlah_panen')
                ->where('kt.nama_kelompok', $name)
                ->get();

        return ResponseModel::response(200, "GET", [$kelompok_tani, $totalFarmerByGroup]);
    }  
}
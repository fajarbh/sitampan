<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;
use App\Models\Commodity;
use App\Models\Plant;
use App\Models\Harvest;
use App\Models\Farmer;
use Auth;
use DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $totalFarmerByGroup = null;
        if(Auth::user()->level == 3){
            $farmerGroup = Auth::user()->farmer->id_kelompok;
            $totalFarmerByGroup = Farmer::where('id_kelompok',$farmerGroup)->whereIn('status',[2,3])->count();
        }
    	$commodity = Commodity::all();
        return view("home",compact('commodity','totalFarmerByGroup'));
    }

    public function chartPlant(Request $request)
    {  
        $startYear = $request->year;
        $endYear = ($startYear+5);
        $addPlanting = Plant::select(DB::raw("date_part('year',tanggal_tanam) AS item_date"),
                            DB::raw("SUM(luas_tanam) as item_total"))
                            ->where('id_komoditas',$request->id_komoditas)
                            ->whereYear("tanggal_tanam", ">=", $startYear)
                            ->whereYear("tanggal_tanam", "<=", $endYear)
                            ->groupBy(DB::raw("date_part('year',tanggal_tanam)"))
                            ->get();

        $payload[]  = $this->processData("Tambah Tanam", $addPlanting, $startYear, $endYear);
        return response()->json($payload);
    }

        public function chartProduction(Request $request)
    {
        $startYear = $request->year;
        $endYear = ($startYear+5);
        $production = Harvest::select(DB::raw("date_part('year',tanggal_panen) AS item_date"),
                            DB::raw("SUM(jumlah_panen) as item_total"))
                            ->where('id_komoditas',$request->id_komoditas)
                            ->whereYear("tanggal_panen", ">=", $startYear)
                            ->whereYear("tanggal_panen", "<=", $endYear)
                            ->groupBy(DB::raw("date_part('year',tanggal_panen)"))
                            ->get();

        $payload[]  = $this->processData("Produksi", $production, $startYear, $endYear);
        return response()->json($payload);
    }

    public function processData($title,$data,$startYear,$endYear){

        $labels = [];
        $datasets = [];
        $index = 0;

        $data = $data->toArray();
        for ($i = $startYear; $i <= $endYear; $i++) { 
            $is_match   = array_filter($data, function($value) use ($i) { return $value["item_date"] == $i; });

            $labels[]   = (string)$i;
            $dataset[]  = (!empty($is_match[$index])) ? $is_match[$index]["item_total"] : 0;

            if (!empty($is_match))
                $index++;
        }

        return [
            "title"     => $title,
            "data"      => $data,
            "labels"    => $labels,
            "dataset"   => $dataset
        ];

    }
}

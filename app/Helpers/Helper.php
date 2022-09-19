<?php

namespace App\Helpers;
use Illuminate\Support\Str;
use App\Models\Farmer;
use App\Models\FarmerGroup;
use App\Models\Plant;
use App\Models\Harvest;
class Helper
{

    public static function roleName($roleId) {
        $result = "";
        if($roleId == 1) {
            $result = "Admin";
        }
        else if($roleId == 2) { 
            $result = "Penyuluh";
        } 
        else if($roleId == 3) {
            $result = "Ketua Kelompok Tani";
        }
        else if($roleId == 4) {
            $result = "Petani";
        }
        return $result;
    }

    public static function farmerStatus($statusId){
        $result = "";
        if($statusId == 1){
            $result = "Ketua Kelompok Tani";
        }
        else if($statusId == 2){
            $result = "Petani";
        }
        else if($statusId == 3){
            $result = "Petani Tidak Aktif";
        }
        return $result;
    }

    public static function geoJsonVillage($name){
        $array = json_decode(file_get_contents(public_path('garut.json')),true);
            $villageName = 'Desa '.ucwords(strtolower($name));
            $arrayFilter = array_filter($array,
                fn($key) => $key == $villageName,
                ARRAY_FILTER_USE_KEY
            );
            $filter = array_values($arrayFilter);
        return $filter[0];
    }

    public static function checkFarmerGroup($farmerGroup,$status){
        $farmer = Farmer::where('id_kelompok',$farmerGroup)->where('status',$status)->count();
        if($farmer > 0){
            return true;
        }else{
            return false;
        }
    }

    public static function checkInstructorFarmerGroup($village,$instructor){
        $farmerGroup = FarmerGroup::where('id_desa',$village)->Orwhere('id_penyuluh',$instructor)->count();
        if($farmerGroup > 0){
            return true;
        }else{
            return false;
        }
    }

    public static function checkPlant($farmer,$commodity,$date){
        $month = date('m',strtotime($date));
        $year  = date('Y',strtotime($date));
        $plant = Plant::where('id_petani',$farmer)->where('id_komoditas',$commodity)->whereMonth('tanggal_tanam',$month)->whereYear('tanggal_tanam',$year)->count();
        if($plant > 0){
            return true;
        }else{
            return false;
        }
    }

    public static function checkHarvest($plant){
        $harvest = Harvest::where('id_tanam',$plant)->count();
        if($harvest > 0){
            return true;
        }else{
            return false;
        }
    }
}
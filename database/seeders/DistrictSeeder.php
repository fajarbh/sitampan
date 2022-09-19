<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\District;
class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $csvFile = fopen(base_path('database/data/kecamatan.csv'), 'r');
       $firstline = true;
        while(($data = fgetcsv($csvFile, 1000, ",")) !== false) {
            if ($firstline) {
                $firstline = false;
                continue;
            }
                $district = new District();
                $district->id = $data[0];
                $district->nama_kecamatan = $data[1];
                $district->save();
        }
        fclose($csvFile);
    }
}

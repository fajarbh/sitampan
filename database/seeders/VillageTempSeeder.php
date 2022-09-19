<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VillageTemp;

class VillageTempSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csvFile = fopen(base_path('database/data/Desa.csv'), 'r');
        $firstline = true;
        while(($data = fgetcsv($csvFile, 1000, ",")) !== false) {
            if ($firstline) {
                $firstline = false;
                continue;
            }
            $village = new VillageTemp();
            $village->id = $data[0];
            $village->kecamatan_id = $data[1];
            $village->nama_desa = $data[2];
            $village->save();
        }
        fclose($csvFile);
    }
}

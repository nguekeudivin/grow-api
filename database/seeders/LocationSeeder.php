<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Region;
use App\Models\City;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('regions')->delete();
        DB::table('cities')->delete();

        // Create regions
        $cameroonRegions = [
            'Adamawa' => 'AD',
            'Centre' => 'CE',
            'East' => 'ES',
            'Far North' => 'EN',
            'Littoral' => 'LT',
            'North' => 'NO',
            'North-West' => 'NW',
            'West' => 'OU',
            'South' => 'SU',
            'South-West' => 'SW',
        ];

        foreach ($cameroonRegions as $name => $code) {
            DB::table('regions')->insert([
                'region_name' => $name,
                'region_code' => $code
            ]);
        }

        // Load and group cities by region
        $cities = json_decode(file_get_contents(resource_path('content/cities.json')), true);

        $citiesToInsert = [];

        foreach ($cities as $city) {
            $region = Region::where('region_code', $city['region_code'])->first();

            if ($region) {
                $citiesToInsert[] = [
                    'city_name' => $city['city_name'],
                    'region_id' => $region->id,
                ];
            }
        }

        // Bulk insert all cities at once
        DB::table('cities')->insert($citiesToInsert);

    }
}

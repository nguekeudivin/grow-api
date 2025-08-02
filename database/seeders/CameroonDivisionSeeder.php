<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\Division;

class CameroonDivisionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Cameroon if it doesn't exist
        $cameroon = Country::where('code', 'CM')->first();

        // 2. Define regions
        $regions = [
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

        // 3. Build hierarchy: Region > Department > Arrondissement > Village
        foreach ($regions as $regionName => $code) {
            // Create region
            $region = Division::create([
                'name' => $regionName,
                'type' => 'region',
                'country_id' => $cameroon->id,
                'parent_id' => null,
            ]);

            // Create 5 departments
            for ($i = 1; $i <= 5; $i++) {
                $department = Division::create([
                    'name' => "Department {$code}-$i",
                    'type' => 'department',
                    'country_id' => $cameroon->id,
                    'parent_id' => $region->id,
                ]);

                // Create 5 arrondissements per department
                for ($j = 1; $j <= 5; $j++) {
                    $arrondissement = Division::create([
                        'name' => "Arrondissement {$code}-$i-$j",
                        'type' => 'arrondissement',
                        'country_id' => $cameroon->id,
                        'parent_id' => $department->id,
                    ]);

                    // Create 5 villages per arrondissement
                    for ($k = 1; $k <= 5; $k++) {
                        Division::create([
                            'name' => "Village {$code}-$i-$j-$k",
                            'type' => 'village',
                            'country_id' => $cameroon->id,
                            'parent_id' => $arrondissement->id,
                        ]);
                    }
                }
            }
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = [
            [
                'code' => 'fr',
                'name' => 'French'
            ],

            [
                'code' => 'en',
                'name' => 'English'
            ]
        ];

        DB::table('languages')->insert($languages);
    }
}

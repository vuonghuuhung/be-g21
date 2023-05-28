<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jsonData = file_get_contents(database_path('data/cities.json')); // replace with your file path
        $data = json_decode($jsonData, true);

        foreach ($data as $item) {
            City::create([
                'id' => $item['code'],
                'name' => $item['name'],
                'slug' => $item['slug'],
                'type' => $item['type'],
                'name_with_type' => $item['name_with_type'],
            ]);
        }
    }
}

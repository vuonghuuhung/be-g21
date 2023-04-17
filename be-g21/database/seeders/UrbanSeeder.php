<?php

namespace Database\Seeders;

use App\Models\urbans;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UrbanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jsonData = file_get_contents(database_path('data/urbans.json')); // replace with your file path
        $data = json_decode($jsonData, true);

        foreach ($data as $item) {
            urbans::create([
                'id' => $item['code'],
                'name' => $item['name'],
                'slug' => $item['slug'],
                'type' => $item['type'],
                'name_with_type' => $item['name_with_type'],
                'path' => $item['path'],
                'path_with_type' => $item['path_with_type'],
                'parent_code' => $item['parent_code']
            ]);
        }
    }
}

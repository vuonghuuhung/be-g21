<?php

namespace Database\Seeders;

use App\Models\productColors;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 45) as $id) {
            $price = rand(1000, 9000);
            productColors::create([
                "product_id" => rand(1, 45),
                "color_name" => 'Color Name' . $id,
                "code" => '#' . $this->random_color_part() . $this->random_color_part() . $this->random_color_part(),
                "image" => "https://cdn.pixabay.com/photo/2018/10/04/14/22/reading-3723751_960_720.jpg",
                "standard_price" => $price,
                "fixed_price" => $price * 0.8,
                "stock" => rand(0, 45),
            ]);
        }
    }

    public function random_color_part()
    {
        return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
    }
}

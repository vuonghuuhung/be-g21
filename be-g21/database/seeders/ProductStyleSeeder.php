<?php

namespace Database\Seeders;

use App\Models\productStyles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductStyleSeeder extends Seeder
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
            productStyles::create([
                "product_id" => rand(1, 45),
                "style_name" => 'Color Style' . $id,
                "image" => "https://cdn.pixabay.com/photo/2016/11/29/07/22/bible-1868070__340.jpg",
                "standard_price" => $price,
                "fixed_price" => $price * 0.8,
                "stock" => rand(0, 45),
            ]);
        }
    }
}

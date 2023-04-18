<?php

namespace Database\Seeders;

use App\Models\products;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 45) as $id) {
            products::create([
                "product_name" => 'Product name' . $id,
                "description" => 'Mỗi người đều có 96 khối năng lượng mỗi ngày để làm những gì chúng ta muốn. Bạn luôn cần đảm bảo mình đang sử dụng mỗi khối năng lượng một cách khôn ngoan để đạt được tiến bộ nhanh nhất trên các mục tiêu quan trọng của bản thân.',
                "category_id" => rand(1, 15),
                "image" => "https://cdn.pixabay.com/photo/2018/03/19/18/20/tea-time-3240766_960_720.jpg",
                "amount" => rand(0, 45),
                "option_type" => rand(1, 2),
                "relate_to_product" => NULL,
            ]);
        }
    }
}

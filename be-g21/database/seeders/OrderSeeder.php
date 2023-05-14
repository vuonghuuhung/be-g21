<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 3) as $id) {
            Order::create([
                "user_id" => rand(1, 15),
                "address" => 'Name' . $id . ', SĐT: ' . $this->radomPhone() . ', ' . 'Số nhà' . $id . ', ' . $this->radomAddr(),
                "total_price" => 233.7,
                "status" => rand(1, 4),
            ]);
        }
        foreach (range(4, 7) as $id) {
            Order::create([
                "user_id" => rand(1, 15),
                "address" => 'Name' . $id . ', SĐT: ' . $this->radomPhone() . ', ' . 'Số nhà' . $id . ', ' . $this->radomAddr(),
                "total_price" => 293.7,
                "status" => rand(1, 4),
            ]);
        }
        foreach (range(8, 9) as $id) {
            Order::create([
                "user_id" => rand(1, 15),
                "address" => 'Name' . $id . ', SĐT: ' . $this->radomPhone() . ', ' . 'Số nhà' . $id . ', ' . $this->radomAddr(),
                "total_price" => 233.7,
                "status" => rand(1, 4),
            ]);
        }
        foreach (range(10, 15) as $id) {
            Order::create([
                "user_id" => rand(1, 15),
                "address" => 'Name' . $id . ', SĐT: ' . $this->radomPhone() . ', ' . 'Số nhà' . $id . ', ' . $this->radomAddr(),
                "total_price" => 123.7,
                "status" => rand(1, 4),
            ]);
        }
    }

    public function radomPhone()
    {
        return '0' . rand(100000000, 999999999);
    }

    public function radomAddr()
    {
        $addr = [
            'Phường Phúc Xá, Quận Ba Đình, Thành phố Hà Nội',
            'Phường Trại Chuối, Quận Hồng Bàng, Thành phố Hải Phòng',
            'Xã Xuân Tiến, Huyện Xuân Trường, Tỉnh Nam Định',
            'Xã Phong Chương, Huyện Phong Điền, Tỉnh Thừa Thiên Huế',
            'Xã Ea Siên, Thị xã Buôn Hồ, Tỉnh Đắk Lắk',
            'Xã Lang Minh, Huyện Xuân Lộc, Tỉnh Đồng Nai',
            'Xã Thanh Thủy, Huyện Lệ Thủy, Tỉnh Quảng Bình',
            'Xã Vĩnh Hiệp, Thành phố Nha Trang, Tỉnh Khánh Hòa',
            'Xã Bình Xuyên, Huyện Bình Giang, Tỉnh Hải Dương',
            'Xã Minh Đức, Thành phố Phổ Yên, Tỉnh Thái Nguyên',
            'Xã Long Vĩnh, Huyện Duyên Hải, Tỉnh Trà Vinh',
            'Xã Hòa An, Huyện Phụng Hiệp, Tỉnh Hậu Giang',
            'Xã Đông Thọ, Huyện Sơn Dương, Tỉnh Tuyên Quang',
            'Thị trấn Tiểu Cần, Huyện Tiểu Cần, Tỉnh Trà Vin',
            'Xã Trí Lực, Huyện Thới Bình, Tỉnh Cà Mau',
        ];
        return $addr[rand(0, 14)];
    }
}

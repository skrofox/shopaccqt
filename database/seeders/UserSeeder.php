<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $name = [
            'Mai Thu',
            'Nguyen A',
            'Nguyễn Văn Chung',
            'Phan Văn Tài Em',
            'Phan Văn Tài',
            'Trần Hà Linh',
            'Nguyễn Sang',
            'Quế Trâm',
            'Thợ Săn Trợ Em',
            'Thợ Đụng',
            'Anh Zai C2',
            'Đỗ Giảng',
            'Lý Hùng',
            'Phạm Thượng',
            'Phạm Pháp',
            'Nguyên Cửu Khôi Lang',
            'Lưu Ly',
            'Nguyên Cửu Khôi Tây',
            'Hà Khắc',
            'Mai Quốc Khánh',
        ];
        $max_name = count($name) - 1;
        $password = "user1234";

        for ($i = 0; $i < 200; $i++) {
            $rand = random_int(0, $max_name);

            \App\Models\User::factory()->create([
                'name' => $name[$rand],
                'email' => 'superuser' . $i + 1 . '@gmail.com',
                'password' => bcrypt($password),
            ]);
        }
    }
}

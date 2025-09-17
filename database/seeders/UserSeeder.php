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
        ];
        $password = "user1234";

        for ($i = 0; $i < 200; $i++) {
            \App\Models\User::factory()->create([
                'name' => $name[$i],
                'email' => 'superuser' . $i + 1 . '@gmail.com',
                'password' => bcrypt($password),
            ]);
        }
    }
}

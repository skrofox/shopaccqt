<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $imageName = "categories/8DKL8NzSuoeByjBL9qndTGq6DCDVMItFm8fk7iXy.png";
        $categoryNames = [
            'Son Dưỡng',
            'Son Môi',
            'Son Lì',
            'Son Kem',
            'Son Bóng',
            'Son Lót Môi',
        ];

        for($i = 0; $i <= count($categoryNames) - 1; $i++) {
            Category::create([
                'name' => $categoryNames[$i],
                'slug' => Str::slug(Str::title($categoryNames[$i])),
                'image' => $imageName,
                'is_active' => true,
            ]);
        }
    }
}

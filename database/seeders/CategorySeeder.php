<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ar = ['موبيل','كمبيوتر','اجهزة','تلفاز','كورة'];
        $en = ['phone','computer','application','tv','football'];
        for($i=0;$i<5;$i++){
            Category::create([
                'name' => [
                    'ar' => $ar[$i],
                    'en' => $en[$i],
                ]
            ]);
        }
    }
}

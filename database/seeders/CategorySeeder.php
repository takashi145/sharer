<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'プログラミング言語',
            '資格',
            'AI',
            'IoT',
            'Web',
            'VR/AR',
            'ゲーム',
            'モバイル',
            'デザイン',
            'ネットワーク',
            'セキュリティ',
            'ハードウェア',
            'その他'
        ];

        foreach($categories as $c) {
            DB::table('categories')->insert([
                'name' => $c
            ]);
        }
    }
}

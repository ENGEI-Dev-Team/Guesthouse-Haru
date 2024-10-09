<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $adminId = '9f59c804-8c2f-4da3-901f-d3b18e7cd010';

        // カテゴリーの挿入
        DB::table('categories')->insert([
            ['id' => (string) Str::uuid(), 'admin_id' => $adminId, 'name' => 'Haru'],
            ['id' => (string) Str::uuid(), 'admin_id' => $adminId, 'name' => 'Teshima'],
            ['id' => (string) Str::uuid(), 'admin_id' => $adminId, 'name' => 'Art'],
            ['id' => (string) Str::uuid(), 'admin_id' => $adminId, 'name' => 'Sightseeing'],
            ['id' => (string) Str::uuid(), 'admin_id' => $adminId, 'name' => 'Lifestyle'],
            ['id' => (string) Str::uuid(), 'admin_id' => $adminId, 'name' => 'Event'],
            ['id' => (string) Str::uuid(), 'admin_id' => $adminId, 'name' => 'Food'],
            ['id' => (string) Str::uuid(), 'admin_id' => $adminId, 'name' => 'News'],
        ]);
    }
}



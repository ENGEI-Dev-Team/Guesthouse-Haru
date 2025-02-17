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
        $adminId = '5b4fdce2-7be8-469a-8d0e-dc3028ef8bcc';

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



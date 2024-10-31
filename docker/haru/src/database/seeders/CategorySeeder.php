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
        $adminId = 'aa47ecd7-c483-4233-bf71-7e5caf77d69b';

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



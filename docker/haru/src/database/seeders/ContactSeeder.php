<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 20; $i++) {
            DB::table('contacts')->insert([
                'id' => (string) Str::uuid(),
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'message' => $faker->text(200),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

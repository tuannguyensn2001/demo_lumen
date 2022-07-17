<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("products")
            ->insert([
                [
                    'name' => 'san pham 1',
                    'created_at' => Carbon::now(),
                    'updated_at'  => Carbon::now()
                ],
                [
                    'name' => 'san pham 2',
                    'created_at' => Carbon::now(),
                    'updated_at'  => Carbon::now()
                ],
                [
                    'name' => 'san pham 3',
                    'created_at' => Carbon::now(),
                    'updated_at'  => Carbon::now()
                ]
            ]);
    }
}

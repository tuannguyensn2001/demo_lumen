<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');
        $user = new User();
        $user->username = 'tuannguyesnn2001a';
        $user->email = 'tuannguyensn2001a@gmail.com';
        $user->password = Hash::make('java2001');
        $user->save();
        $this->call(ProductSeeder::class);
    }
}

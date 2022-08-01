<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([  'name' => 'David', 
                        'role' => 1, 
                        'email' => 'davidgubik1@gmail.com', 
                        'password' => Hash::make('AdminAdmin123')]);
        
    }
}

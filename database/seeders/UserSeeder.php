<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'first_name' =>'ali',
            'last_name' =>'ahmed',
            'phone' => '01234567890',
            'email' => 'ali@example.com',
            'password' => '123456',
        ]);

        $user->addRole('super_admin');

    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'phone' => '3104051587',
            'email' => 'manuelcardona181@gmail.com',
            'profile' => 'ADMIN',
            'status' => 'ACTIVE',
            'password' => bcrypt('hola1234'),
        ]);

        User::create([
            'name' => 'employee',
            'phone' => '3104051581',
            'email' => 'test@test.test',
            'profile' => 'EMPLOYEE',
            'status' => 'ACTIVE',
            'password' => bcrypt('hola1234'),
        ]);
    }
}

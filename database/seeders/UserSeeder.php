<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
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
          'name' => 'Joaco Paradela',
          'phone' => '3511159550',
          'email' => 'paradela@gmail.com',
          'profile' => 'ADMIN',
          'status' => 'ACTIVE',
          'password' => bcrypt('12345'),
        ]);
        User::create([
            'name' => 'Melisa Adela',
            'phone' => '3511159655',
            'email' => 'melisa@gmail.com',
            'profile' => 'EMPLOYEE',
            'status' => 'ACTIVE',
            'password' => bcrypt('12345'),
          ]);
    }
}

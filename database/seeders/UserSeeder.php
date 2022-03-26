<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $admin = User::create([
            'email' => 'admin@dcc.ru',
            'password' => Hash::make('secret'),
            'status' => User::STATUS_ACTIVE,
        ]);

        $admin->assign('admin');

        User::create([
            'email' => 'user@dcc.ru',
            'phone' => '+8999080825',
            'password' => Hash::make('secret'),
            'status' => User::STATUS_ACTIVE,
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                "name" => "Yinka",
                "email" => "yinkja@user.com",
                "password" => Hash::make("p@ssword"),
                "created_at"  => now(),
                "updated_at" => now(),
            ],
        ];

        User::insert($users);
    }
}

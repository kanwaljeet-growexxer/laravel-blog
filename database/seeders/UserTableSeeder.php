<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        $user = new User;
        $user->name = "kanwaljeet";
        $user->email = "kj@gmail.com";
        $user->password = Hash::make('12345678');
        $user->save();
    }
}
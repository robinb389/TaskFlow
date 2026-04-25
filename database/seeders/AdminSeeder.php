<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'name'     => 'Admin',
            'email'    => 'admin@taskflow.test',
            'password' => Hash::make('password'),
        ]);

        $user->forceFill(['is_admin' => true])->save();
    }
}

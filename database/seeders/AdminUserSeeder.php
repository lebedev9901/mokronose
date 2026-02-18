<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'Алексей',
            'last_name' => 'Лебедев',
            'middle_name' => 'Владиславович',
            'email' => 'lebedew99080@gmail.com',
            'password' => Hash::make('Lebedew13'),
            'role' => 'admin',
        ]);
    }
}

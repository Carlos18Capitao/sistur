<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name'     => 'Admin Sistur',
            'email'    => 'admin@sistur.ao',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'phone'    => '+244 923 000 001',
        ]);

        // Demo users
        $users = [
            ['name' => 'João Manuel', 'email' => 'joao@exemplo.ao', 'phone' => '+244 912 345 678'],
            ['name' => 'Maria da Conceição', 'email' => 'maria@exemplo.ao', 'phone' => '+244 923 456 789'],
            ['name' => 'António Sebastião', 'email' => 'antonio@exemplo.ao', 'phone' => '+244 934 567 890'],
            ['name' => 'Ana Luísa Ferreira', 'email' => 'ana@exemplo.ao', 'phone' => '+244 912 111 222'],
            ['name' => 'Carlos Eduardo Neto', 'email' => 'carlos@exemplo.ao', 'phone' => '+244 923 333 444'],
        ];

        foreach ($users as $user) {
            User::create(array_merge($user, [
                'password' => Hash::make('password'),
                'role'     => 'user',
            ]));
        }
    }
}

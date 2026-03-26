<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Stand;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin Maestro',
                'password' => Hash::make('password'),
                'rol' => 'admin',
                'active' => true,
            ]
        );
        
        // Supervisor
        User::updateOrCreate(
            ['email' => 'supervisor@supervisor.com'],
            [
                'name' => 'Supervisor General',
                'password' => Hash::make('password'),
                'rol' => 'supervisor',
                'active' => true,
            ]
        );
        
        // Create a couple of Stands and Staff
        for ($i = 1; $i <= 3; $i++) {
            $staff = User::updateOrCreate(
                ['email' => "stand$i@stand.com"],
                [
                    'name' => "Staff Stand $i",
                    'password' => Hash::make('password'),
                    'rol' => 'user',
                    'active' => true,
                ]
            );
            
            $stand = Stand::updateOrCreate(
                ['name' => "Stand $i"],
                [
                    'description' => "Descripción del Stand $i de la feria",
                    'active' => true,
                    'qrToken' => "token_unico_stand_$i",
                    'ownerUserId' => $staff->id,
                ]
            );
            
            $staff->update(['standId' => $stand->id]);
        }
    }
}

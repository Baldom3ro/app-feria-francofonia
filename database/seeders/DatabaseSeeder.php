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
        User::create([
            'name' => 'Admin Maestro',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'rol' => 'admin',
            'active' => true,
        ]);
        
        // Supervisor
        User::create([
            'name' => 'Supervisor General',
            'email' => 'supervisor@supervisor.com',
            'password' => Hash::make('password'),
            'rol' => 'supervisor',
            'active' => true,
        ]);
        
        // Create a couple of Stands and Staff
        for ($i = 1; $i <= 3; $i++) {
            $staff = User::create([
                'name' => "Staff Stand $i",
                'email' => "stand$i@stand.com",
                'password' => Hash::make('password'),
                'rol' => 'user',
                'active' => true,
            ]);
            
            $stand = Stand::create([
                'name' => "Stand $i",
                'description' => "Descripción del Stand $i de la feria",
                'active' => true,
                'qrToken' => "token_unico_stand_$i",
                'ownerUserId' => $staff->id,
            ]);
            
            $staff->update(['standId' => $stand->id]);
        }
    }
}

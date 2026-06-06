<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Taufik',
                'username' => 'taufik',
                'role_id' => 1,
                'email' => 'taufik@example.com',
                'telepon' => null,
                'alamat' => null,
                'status' => 'Aktif',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'name' => 'Sales Demo',
                'username' => 'sales',
                'role_id' => 2,
                'email' => 'sales@example.com',
                'telepon' => '081234567802',
                'alamat' => 'Bandung, Indonesia',
                'status' => 'Aktif',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'name' => 'Desainer Demo',
                'username' => 'desainer',
                'role_id' => 3,
                'email' => 'desainer@example.com',
                'telepon' => '081234567803',
                'alamat' => 'Jakarta, Indonesia',
                'status' => 'Aktif',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 4,
                'name' => 'Admin Demo',
                'username' => 'admin',
                'role_id' => 4,
                'email' => 'admin@example.com',
                'telepon' => '081234567804',
                'alamat' => 'Surabaya, Indonesia',
                'status' => 'Aktif',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 5,
                'name' => 'Finance Demo',
                'username' => 'finance',
                'role_id' => 5,
                'email' => 'finance@example.com',
                'telepon' => '081234567805',
                'alamat' => 'Medan, Indonesia',
                'status' => 'Aktif',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 6,
                'name' => 'Purchasing Demo',
                'username' => 'purchasing',
                'role_id' => 6,
                'email' => 'purchasing@example.com',
                'telepon' => '081234567806',
                'alamat' => 'Semarang, Indonesia',
                'status' => 'Aktif',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
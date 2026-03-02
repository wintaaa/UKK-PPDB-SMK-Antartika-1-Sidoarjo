<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Jalankan seed database.
     */
    public function run(): void
    {
        // Buat user untuk peran Ketua/Admin
        User::updateOrCreate(
    ['email' => 'admin@smk-antartika.sch.id'], // Kunci pengecekan
    [
        'name' => 'Admin PPDB',
        'password' => Hash::make('password'), // Password akan diperbarui
        'role' => 'ketua'
    ]
);
        
        // Buat user untuk peran Panitia
        User::create([
            'name' => 'Panitia PPDB',
            'email' => 'panitia@smk-antartika.sch.id',
            'password' => Hash::make('password'),
            'role' => 'panitia',
        ]);
        
        // Buat user untuk peran Bendahara
        User::create([
            'name' => 'Bendahara PPDB',
            'email' => 'bendahara@smk-antartika.sch.id',
            'password' => Hash::make('password'),
            'role' => 'bendahara',
        ]);
    }
}
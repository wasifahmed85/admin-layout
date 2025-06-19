<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\AuthBaseModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@dev.com',
            'email_verified_at' => now(),
            'password' => 'superadmin@dev.com',
            'status' => AuthBaseModel::STATUS_ACTIVE,
        ]);
    }
}

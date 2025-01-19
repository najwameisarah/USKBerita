<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       Role::create(['name' => 'Admin']);
       Role::create(['name' => 'Member']);

       $admin = User::create([
        'name' => 'admin',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
       ]);

       $admin->assignRole('Admin');

       $member = User::create([
        'name' => 'member',
        'email' => 'member@example.com',
        'password' => bcrypt('password'),
       ]);

       $member->assignRole('Member');

       Category::create(['name' => 'Sport']);
       Category::create(['name' => 'Politic']);
       Category::create(['name' => 'Lifestyle']);
    }
}

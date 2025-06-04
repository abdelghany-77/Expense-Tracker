<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
  public function run(): void
  {
    // Create the main test user (using your login)
    User::create([
      'name' => 'Abdelghany Mohamed',
      'email' => 'abdelghany-77@example.com',
      'password' => Hash::make('password123'),
      'email_verified_at' => now(),
    ]);

    // Create additional test users
    User::create([
      'name' => 'John Doe',
      'email' => 'john@example.com',
      'password' => Hash::make('password123'),
      'email_verified_at' => now(),
    ]);

    User::create([
      'name' => 'Sarah Johnson',
      'email' => 'sarah@example.com',
      'password' => Hash::make('password123'),
      'email_verified_at' => now(),
    ]);

    User::create([
      'name' => 'Mike Wilson',
      'email' => 'mike@example.com',
      'password' => Hash::make('password123'),
      'email_verified_at' => now(),
    ]);
  }
}

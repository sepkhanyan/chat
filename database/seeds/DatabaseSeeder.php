<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'User 1',
            'email' => 'user1@test.com',
            'password' => Hash::make('secret'),
        ]);
        User::create([
            'name' => 'User 2',
            'email' => 'user2@test.com',
            'password' => Hash::make('secret'),
        ]);
        User::create([
            'name' => 'User 3',
            'email' => 'user3@test.com',
            'password' => Hash::make('secret'),
        ]);
        User::create([
            'name' => 'User 4',
            'email' => 'user4@test.com',
            'password' => Hash::make('secret'),
        ]);
        User::create([
            'name' => 'User 5',
            'email' => 'user5 @test.com',
            'password' => Hash::make('secret'),
        ]);
    }
}

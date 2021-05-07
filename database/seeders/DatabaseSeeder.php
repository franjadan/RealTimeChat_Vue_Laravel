<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'name' => 'John Doe',
            'email' => 'user1@qastusoft.com',
            'email_verified_at' => now(),
            'password' => \bcrypt("qwerasdf"),
            'remember_token' => Str::random(10),
        ]);

        \App\Models\User::create([
            'name' => 'Jane Doe',
            'email' => 'user2@qastusoft.com',
            'email_verified_at' => now(),
            'password' => \bcrypt("qwerasdf"),
            'remember_token' => Str::random(10),
        ]);

        \App\Models\User::create([
            'name' => 'Joe Doe',
            'email' => 'user3@qastusoft.com',
            'email_verified_at' => now(),
            'password' => \bcrypt("qwerasdf"),
            'remember_token' => Str::random(10),
        ]);
    }
}

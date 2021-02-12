<?php

namespace Database\Seeders;

use Database\Factories\BookFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(RoleUserSeeder::class);
        $this->call(BookSeeder::class);
        $this->call(AuthorSeeder::class);
        $this->call(AuthorBookSeeder::class);
        $this->call(GenreSeeder::class);
        $this->call(GenreBookSeeder::class);
        $this->call(ReviewSeeder::class);
    }
}

<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Database\AdminTablesSeeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (env('DB_SEED_MOCK'))
        {
            $this->call(UsersTableSeeder::class);
            $this->call(TopicTableSeeder::class);
            $this->call(RepliesTableSeeder::class);
            $this->call(LinksTableSeeder::class);
        }
        if (env('DB_SEED_INSTALL'))
        $this->call(AdminTablesSeeder::class);
    }
}

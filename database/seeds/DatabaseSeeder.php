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
        if (env('APP_ENV') == 'local')
        {
            $this->call(UsersTableSeeder::class);
            $this->call(TopicTableSeeder::class);
            $this->call(RepliesTableSeeder::class);
            $this->call(LinksTableSeeder::class);
        }
        $this->call(AdminTablesSeeder::class);
    }
}

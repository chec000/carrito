<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => str_random(10),
            'username' => 'all',
            'role_id' => 1,
            'modified_by' => 1,
            'email' => 'edgar.flores@omnilife.com',
            'password' => bcrypt('secret'),
        ]);
        // $this->call(UsersTableSeeder::class);
    }
}

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
        // $this->call(UsersTableSeeder::class);
        App\User::create([
        	'name' => 'Admin',
        	'email' => 'admin@zappa.com',
        	'role_id' => -1,
        	'status' => 1,
        	'password' => bcrypt(123456),
        ]);
    }
}

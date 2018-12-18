<?php

use Illuminate\Database\Seeder;

class AdminUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = date('Y-m-d H:i:s');
        DB::table('admin_users')->insert([
            'username' => 'admin',
            'password' => Hash::make('123456'),
            'name' => 'admin',
            'created_at' => $time,
            'updated_at' => $time,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'phone' => '+2547000000',
            'first_name' => 'FirstName',
            'last_name' => 'FirstName'
        ]);
        \App\Models\User::find($user->id)->assignRole('Super Admin');
    }
}

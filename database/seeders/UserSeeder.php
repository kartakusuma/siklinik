<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::withoutTrashed()->updateOrCreate(
            [
                'id' => 1,
            ],
            [
                'nama' => 'Super Admin',
                'username' => 'administrator',
                'password' => bcrypt('siklinik123'),
                'email' => 'admin@mail.com',
                'role_id' => 1
            ]
        );
    }
}

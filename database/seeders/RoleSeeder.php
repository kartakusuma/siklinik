<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            ['id' => 1, 'name' => 'Administrator'],
            ['id' => 10, 'name' => 'Dokter'],
            ['id' => 20, 'name' => 'Perawat'],
            ['id' => 30, 'name' => 'Apoteker'],
        ];

        foreach ($datas as $key => $value) {
            Role::withTrashed()->updateOrCreate(
                [
                    'id' => $value['id'],
                ],
                [
                    'nama' => $value['name'],
                    'deleted_at' => null
                ]
            );
        }
    }
}

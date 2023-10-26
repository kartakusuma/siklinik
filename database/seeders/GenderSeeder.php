<?php

namespace Database\Seeders;

use App\Models\Gender;
use Illuminate\Database\Seeder;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            ['id' => 1, 'name' => 'Laki-laki'],
            ['id' => 2, 'name' => 'Perempuan'],
        ];

        foreach ($datas as $key => $value) {
            Gender::withTrashed()->updateOrCreate(
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

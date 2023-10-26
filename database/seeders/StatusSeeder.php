<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'nama' => 'Baru'],
            ['id' => 2, 'nama' => 'Diproses'],
            ['id' => 3, 'nama' => 'Selesai'],
        ];

        foreach ($data as $key => $value) {
            Status::withTrashed()->updateOrCreate(
                [
                    'id' => $value['id']
                ],
                [
                    'nama' => $value['nama'],
                    'deleted_at' => null,
                ]
            );
        }
    }
}

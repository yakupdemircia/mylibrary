<?php

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $datas = [
            1 => [
                'id'       => 1,
                'name'     => 'Admin ',
                'email'    => 'admin@mylibrary.com',
                'password' => bcrypt('132435'),
            ]
        ];

        foreach ($datas as $data) {
            Admin::updateOrCreate(['id' => $data['id']], $data);
        }

    }
}

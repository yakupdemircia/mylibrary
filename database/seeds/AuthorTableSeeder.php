<?php

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorTableSeeder extends Seeder
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
                'name'     => 'John Doe',
            ],
            2 => [
                'id'       => 2,
                'name'     => 'Jane Doe',
            ],
        ];

        foreach ($datas as $data) {
           Author::updateOrCreate(['id' => $data['id']], $data);
        }
    }
}

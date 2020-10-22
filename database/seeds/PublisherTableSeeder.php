<?php

use App\Models\Publisher;
use Illuminate\Database\Seeder;

class PublisherTableSeeder extends Seeder
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
                'id'          => 1,
                'title'       => 'Publisher 1',
                'description' => 'Lorem ipsum',
            ],
            2 => [
                'id'          => 2,
                'title'       => 'Publisher 2',
                'description' => 'Lorem ipsum',
            ],
        ];

        foreach ($datas as $data) {
           Publisher::updateOrCreate(['id' => $data['id']], $data);
        }
    }
}

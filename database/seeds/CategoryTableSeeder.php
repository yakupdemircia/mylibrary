<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
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
                'title'       => 'Category 1',
                'description' => 'Lorem ipsum',
            ],
            2 => [
                'id'          => 2,
                'title'       => 'Category 2',
                'description' => 'Lorem ipsum',
            ],
        ];

        foreach ($datas as $data) {
           Category::updateOrCreate(['id' => $data['id']], $data);
        }
    }
}

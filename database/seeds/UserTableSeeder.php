<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
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
                'name'     => 'Yakup Demirci',
                'email'    => 'yakup@mylibrary.com',
                'image'    => 'uploads/user/0.png',
                'password' => bcrypt('123'),
                'gender'   => 1,
                'bio'      => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec tortor ex, porta ac ex a, luctus posuere libero. Maecenas ullamcorper accumsan enim, in dignissim libero sagittis ac.</p>',
                'phone'    => '5551234567',
                'birthday' => '1985-08-27',
                'email_verified_at' => '2020-04-05 01:24:16',
            ],
            2 => [
                'id'       => 2,
                'name'     => 'User User1',
                'email'    => 'user1@mylibrary.com',
                'image'    => 'uploads/user/0.png',
                'password' => bcrypt('123'),
                'gender'   => 1,
                'bio'      => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec tortor ex, porta ac ex a, luctus posuere libero. Maecenas ullamcorper accumsan enim, in dignissim libero sagittis ac.</p>',
                'phone'    => '5551234567',
                'birthday' => '1985-08-27',
                'email_verified_at' => '2020-04-05 01:24:16',
            ],
            3 => [
                'id'       => 3,
                'name'     => 'User User2',
                'email'    => 'user2@mylibrary.com',
                'image'    => 'uploads/user/0.png',
                'password' => bcrypt('123'),
                'gender'   => 1,
                'bio'      => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec tortor ex, porta ac ex a, luctus posuere libero. Maecenas ullamcorper accumsan enim, in dignissim libero sagittis ac.</p>',
                'phone'    => '5551234567',
                'birthday' => '1985-08-27',
                'email_verified_at' => '2020-04-05 01:24:16',
            ],
            4 => [
                'id'       => 4,
                'name'     => 'User User3',
                'email'    => 'user3@mylibrary.com',
                'image'    => 'uploads/user/0.png',
                'password' => bcrypt('123'),
                'gender'   => 1,
                'bio'      => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec tortor ex, porta ac ex a, luctus posuere libero. Maecenas ullamcorper accumsan enim, in dignissim libero sagittis ac.</p>',
                'phone'    => '5551234567',
                'birthday' => '1985-08-27',
                'email_verified_at' => '2020-04-05 01:24:16',
            ],
            5 => [
                'id'       => 5,
                'name'     => 'User User4',
                'email'    => 'user4@mylibrary.com',
                'image'    => 'uploads/user/0.png',
                'password' => bcrypt('123'),
                'gender'   => 1,
                'bio'      => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec tortor ex, porta ac ex a, luctus posuere libero. Maecenas ullamcorper accumsan enim, in dignissim libero sagittis ac.</p>',
                'phone'    => '5551234567',
                'birthday' => '1985-08-27',
                'email_verified_at' => '2020-04-05 01:24:16',
            ],
            6 => [
                'id'       => 6,
                'name'     => 'User User5',
                'email'    => 'user5@mylibrary.com',
                'image'    => 'uploads/user/0.png',
                'password' => bcrypt('123'),
                'gender'   => 1,
                'bio'      => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec tortor ex, porta ac ex a, luctus posuere libero. Maecenas ullamcorper accumsan enim, in dignissim libero sagittis ac.</p>',
                'phone'    => '5551234567',
                'birthday' => '1985-08-27',
                'email_verified_at' => '2020-04-05 01:24:16',
            ]
        ];

        foreach ($datas as $data) {
            User::updateOrCreate(['id' => $data['id']], $data);
        }
    }
}

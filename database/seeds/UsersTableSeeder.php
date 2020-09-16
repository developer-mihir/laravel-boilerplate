<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new \App\User();

        $user->create([
            'name'     => 'John Doe',
            'email'    => 'john.doe@mail.com',
            'password' => bcrypt(123456)
        ]);

        $user->create([
            'name'     => 'Elon Musk',
            'email'    => 'elon.musk@mail.com',
            'password' => bcrypt(123456)
        ]);
    }
}

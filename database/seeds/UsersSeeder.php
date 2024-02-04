<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
               'username'=>'admin',
               'email'=>'aglapay.markranny@gmail.com',
               'employee_no'=>'7889',
               'password'=> bcrypt('`'),
            ],
        ];
    }
}

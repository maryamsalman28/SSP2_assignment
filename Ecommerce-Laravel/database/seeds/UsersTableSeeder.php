<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=array(
            array(
                'name'=>'maryam',
                'email'=>'maryamsalman288@gmail.com',
                'password'=>Hash::make('maryam123'),
                'role'=>'admin',
                'status'=>'active'
            ),
            array(
                'name'=>'Customer 1',
                'email'=>'customer@mail.com',
                'password'=>Hash::make('customer123'),
                'role'=>'user',
                'status'=>'active'
            ),
        );

        DB::table('users')->insert($data);
    }
}

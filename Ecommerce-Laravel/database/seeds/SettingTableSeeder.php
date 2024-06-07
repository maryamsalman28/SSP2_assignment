<?php

use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=array(
            'description'=>"Chefzen is an online platform that connects users with chefs for healthy meal prep. It offers diet-specific meals like keto and vegan, making meal planning and ordering easy and convenient.",
            'short_des'=>"Chefzen connects users with chefs for healthy, diet-specific meal prep, offering easy and convenient meal planning and ordering.",
            'photo'=>"image.jpg",
            'logo'=>'logo.jpg',
            'address'=>"123, Test Street, Chefzen City",
            'email'=>"chefzen@gmail.com",
            'phone'=>"0777123456",
        );
        DB::table('settings')->insert($data);
    }
}

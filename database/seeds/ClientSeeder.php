<?php

use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $faker = \Faker\Factory::create();
        for($x=0;$x<=25;$x++){
            $id = DB::table('clients')->insertGetId([
                'lastname'=>$faker->lastname,
                'firstname'=>$faker->firstname,
                'middlename'=>$faker->lastname,
                'branch_id'=>\Auth::user()->id,
                'client_code'=>generateClientCode(),
                'suffix'=>$faker->suffix,
                'nickname'=>substr($faker->firstname,0,5),
                'mother_name'=>$faker->firstNameFemale.' '.$faker->lastname,
                'spouse_name'=>$faker->firstNameFemale.' '.$faker->lastname,
                'TIN'=>str_random(9),
                'birthday'=>$faker->dateTimeThisCentury->format('Y-m-d'),
                'home_address'=>$faker->address,
                'home_year'=>$faker->year($max='now'),
                'business_address'=>$faker->address,
                'business_year'=>$faker->year($max='now'),
                'mobile_number'=>'09'.str_random(9),
                'telephone_number'=>'222'.str_random(4),
                'civil_status'=> 'Single',
                'sex'=> 'Male',
                'education'=> 'Elementary',
                'house_type'=>'Rented'
            ]);

            DB::table('client_incomes')->insert([
                'client_id'=>$id,
                'member_lastname'=>$faker->lastname,
                'member_firstname'=>$faker->firstname,
                'member_middlename'=>$faker->firstname,
                'member_suffix'=>$faker->suffix,
                'member_age'=>str_random(2),
                'member_relationship'=>'cousin',
                'member_occupation'=>$faker->jobTitle,
                'member_occupation_years'=>str_random(10),
                'member_monthly_income'=>rand(10000,100000),
                'member_address'=>$faker->address
            ]);
            DB::table('client_businesses')->insert([
                'client_id'=>$id,
                'main_business'=>$faker->jobTitle,
                'secondary_business'=>str_random(10),
                'main_business_years'=>rand(1990,2016),
                'number_of_paid_employees'=>rand(0,100),
                'business_place_characteristic'=>'Owned',
            ]);
        }
    }
}

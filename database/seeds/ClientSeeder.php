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
        for($x=0;$x<=50;$x++){
            $id = DB::table('clients')->insertGetId([
                    'lastname'=>str_random(10),
                    'firstname'=>str_random(10),
                    'middlename'=>str_random(10),
                    'branch_id'=>1,
                    'suffix'=>str_random(2),
                    'nickname'=>str_random(4),
                    'mother_name'=>str_random(10),
                    'spouse_name'=>str_random(10),
                    'TIN'=>rand(0,10),
                    'birthday'=>'1994-11-26',
                    'home_address'=>str_random(10),
                    'home_year'=>rand(1990,2016),
                    'business_address'=>str_random(10),
                    'business_year'=>rand(1990,2016),
                    'mobile_number'=>str_random(11),
                    'telephone_number'=>str_random(10),
                    'civil_status'=>'Single',
                    'sex'=>'Male',
                    'education'=>'Elementary',
                    'house_type'=>'Rented',

            ]);

            DB::table('client_incomes')->insert([
                'client_id'=>$id,
                'member_lastname'=>str_random(10),
                'member_firstname'=>str_random(10),
                'member_middlename'=>str_random(10),
                'member_suffix'=>1,
                'member_age'=>str_random(2),
                'member_relationship'=>str_random(4),
                'member_occupation'=>str_random(10),
                'member_occupation_years'=>str_random(10),
                'member_monthly_income'=>rand(0,10),
                'member_address'=>str_random(20)
            ]);
            DB::table('client_businesses')->insert([
                'client_id'=>$id,
                'main_business'=>str_random(10),
                'secondary_business'=>str_random(10),
                'main_business_years'=>rand(1990,2016),
                'number_of_paid_employees'=>rand(0,100),
                'business_place_characteristic'=>str_random(10),
            ]);
        }
    }
}

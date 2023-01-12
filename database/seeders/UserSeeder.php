<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Department;
use App\Models\Location;
use App\Models\Country;
use App\Models\Job;
use App\Models\Region;
use App\Models\User;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   

        //User As Admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin@123')
        ]);

        Region::create(['region_name' => 'EASTERN REGION']);
        Region::create(['region_name' => 'WESTERN REGION']);
     
        Country::create(['country_name' => 'India','region_id' => 1]);
        Country::create(['country_name' => 'USA','region_id' => 2]);
       

     Location::create([
                'street_address' => '11 Gayatri Nagar Rd Gayatri Nagar, Pratap Nagar, Nagpur',
                'postal_code' => 440022,
                'city' => 'Nagpur',
                'state_province' => 'Maharashtra',
                'country_id' => 1
                ]);
                
    Location::create([
                'street_address' => 'Manewada road,Jaitala Nagpur',
                'postal_code' => 440036,
                'city' => 'Nagpur',
                'state_province' => 'Maharashtra',
                'country_id' => 1
               ]);
    
        

 Department::create(['department_name' => 'Marketing','location_id' => 1]);
 Department::create(['department_name' => 'Sales','location_id' => 1]);
 Department::create(['department_name' => 'Web Development','location_id' => 2]);
 Department::create(['department_name' => 'HR Department','location_id' => 2]);
 
Job::create(['job_title' => 'Laravel Developer','min_salary' => 45000,'max_salary' => 85000]);
Job::create(['job_title' => 'React Developer','min_salary' => 50000,'max_salary' => 90000]);
Job::create(['job_title' => 'Full Stack Developer','min_salary' => 60000,'max_salary' => 95000]);

}
}

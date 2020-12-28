<?php

use Illuminate\Database\Seeder;
use App\Countries;



class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $countries = [
            ['name' => 'Afghanistan'],
	        ['name' => 'Angola'],
	        ['name' => 'India'],
	        ['name' => "United States"]
        ];

        foreach ($countries as $country) {
            Countries::create($country);
        }
    }
}

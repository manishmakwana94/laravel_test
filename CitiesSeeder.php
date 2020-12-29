<?php

use Illuminate\Database\Seeder;
use App\Cities;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $cities = [
            ['country_id'=> '1', 'name' => 'Garacharma'],
	        ['country_id'=> '1', 'name' => 'Rangat'],
	        ['country_id'=> '1', 'name' => 'Port Blair'],
	        ['country_id'=> '1', 'name' => "Bombuflat"],
	        ['country_id'=> '2', 'name' => 'Huambo'],
	        ['country_id'=> '2', 'name' => 'Lobito'],
	        ['country_id'=> '2', 'name' => 'Malanje'],
	        ['country_id'=> '2', 'name' => "Cuanza Norte"],
	        ['country_id'=> '3', 'name' => 'Baroda'],
	        ['country_id'=> '3', 'name' => 'Surat'],
	        ['country_id'=> '3', 'name' => 'Rajkot'],
	        ['country_id'=> '3', 'name' => "Amaravati"],
	        ['country_id'=> '4', 'name' => 'Houston'],
	        ['country_id'=> '4', 'name' => 'Chicago'],
	        ['country_id'=> '4', 'name' => 'Los Angeles'],
	        ['country_id'=> '4', 'name' => "New York"],
        ];

        foreach ($cities as $city) {
            Cities::create($city);
        }
    }
}

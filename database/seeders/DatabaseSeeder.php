<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Province;
use App\Services\RajaOngkirService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $RajaOngkir = new RajaOngkirService();

        $provinces = $RajaOngkir->getProvinces();
        $cities = $RajaOngkir->getCities();

        foreach($provinces as $prov) {
            Province::create([
                'province_id' => $prov->province_id,
                'province' => $prov->province,
            ]);
        }

        foreach($cities as $city) {
            City::create([
                'city_id' => $city->city_id,
                'city' => $city->city_name,
                'province_id' => $city->province_id,
                'type' => $city->type
            ]);
        }

    }
}

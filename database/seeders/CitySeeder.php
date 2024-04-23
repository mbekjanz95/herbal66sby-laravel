<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Province;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $response = Http::withHeaders([
            'key' =>  '67056b67dbf8899066b352b5c0281b11'])
            ->withOptions(["verify"=>false])
            ->get('https://api.rajaongkir.com/starter/city');

        $collection= $response->collect();

        $fix = $collection->mapWithKeys(function ($item) {
            return ($item['results']);
        });

        foreach ($fix as $city) {
            City::create([
                'city_id'=>  $city['city_id'],
                'province_id'=>  $city['province_id'],
                'province'=>  $city['province'],
                'type'=>  $city['type'],
                'city_name'=>  $city['city_name'],
                'postal_code'=>  $city['postal_code'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Province;
use App\Models\Provinsi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class ProvinceSeeder extends Seeder
{
    public function run(): void
    {
        $response = Http::withHeaders([
            'key' =>  '67056b67dbf8899066b352b5c0281b11'])
            ->withOptions(["verify"=>false])
            ->get('https://api.rajaongkir.com/starter/province');

        $collection= $response->collect();

        $fix = $collection->mapWithKeys(function ($item) {
            return ($item['results']);
        });

        foreach ($fix as $province) {
            Province::create([
                'province_id'=>  $province['province_id'],
                'province'=>  $province['province'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}

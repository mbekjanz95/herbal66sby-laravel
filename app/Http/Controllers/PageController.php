<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Produk;

class PageController extends Controller
{
    public function index(Request $request)
    {
        // $response = Http::withHeaders([
        //     'key' =>  '67056b67dbf8899066b352b5c0281b11'])
        //     ->withOptions(["verify"=>false])
        //     ->get('https://api.rajaongkir.com/starter/city');

        // $collection= $response->collect();

        // $items = $collection->mapWithKeys(function ($item) {
        //     return ($item['results']);
        // });
         
        // return $items;

        $response = Http::withHeaders([
            'key' =>  '67056b67dbf8899066b352b5c0281b11',
            'content-type' => 'application/x-www-form-urlencoded'])
                ->withOptions(["verify"=>false])
                ->asForm()->post('https://api.rajaongkir.com/starter/cost', [
            'origin'      => '444',
            'destination' => '445',
            'weight'      => '1000',
            'courier'     => 'pos']);

        $collection= $response->collect();

        $results = $collection->mapWithKeys(function (array $item) {
            return ($item['results']);
        });

        $costs = $results->mapWithKeys(function (array $item) {
            return ($item['costs']);
        });

        $harga = $costs->where('service','YES')
                 ->pluck('cost')->collapse()
                 ->pluck('value')
                 ->first();

        // $service = $costs->pluck('cost')->collapse();

        // $cost_service = $costs->pluck('cost')
        //                 ->collapse()->pluck('value');
                        
        // $harga = $cost_service->values();

        // return view ('post', compact('items'));
        return $results;

    }

    public function home()
    {
        $products = Produk::paginate(7);
        return view('layouts.main', compact('products'));
    }

    public function tampil_ongkir(Request $request)
    {
        $response = Http::withHeaders([
                // 'key' =>  '67056b67dbf8899066b352b5c0281b11',
                'key' =>  'ca426fd832ce5b891234f4909ff1d13e',
                'content-type' => 'application/x-www-form-urlencoded'])
                    ->withOptions(["verify"=>false])
                    ->asForm()->post('https://api.rajaongkir.com/starter/cost', [
                'origin'      => '444',
                'destination' => $request->destination,
                'weight'      => $request->weight,
                'courier'     => $request->courier]);

        $collection= $response->collect();

        $results = $collection->mapWithKeys(function (array $item) {
            return ($item['results']);
        });

        $costs = $results->mapWithKeys(function (array $item) {
            return ($item['costs']);
        }); 

        return $costs;
    }

    public function tampil_harga(Request $request)
    {
        $response = Http::withHeaders([
                // 'key' =>  '67056b67dbf8899066b352b5c0281b11',
                'key' =>  'ca426fd832ce5b891234f4909ff1d13e',
                'content-type' => 'application/x-www-form-urlencoded'])
                    ->withOptions(["verify"=>false])
                    ->asForm()->post('https://api.rajaongkir.com/starter/cost', [
                'origin'      => '444',
                'destination' => $request->destination,
                'weight'      => $request->weight,
                'courier'     => $request->courier]);

        $collection= $response->collect();

        $results = $collection->mapWithKeys(function (array $item) {
            return ($item['results']);
        });

        $costs = $results->mapWithKeys(function (array $item) {
            return ($item['costs']);
        });
        
        $harga = $costs->where('service',$request->layanan)
        ->pluck('cost')->collapse()
        ->pluck('value')
        ->first();


        return $harga;
    }
}

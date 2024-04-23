<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class KeranjangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $qty = Keranjang::where('nama_produk', $request->nama_produk)->pluck('qty')->first();
        $stok = Produk::where('nama_produk', $request->nama_produk)->pluck('stok')->first();
        $req_qty = intval($request->qty);
        $qtyIncrement = $req_qty + $qty;

        if (Keranjang::where('nama_produk', $request->nama_produk)
        ->where('username', auth()->user()->username)
        ->exists())
        {
            if ($qty >= $stok || $qtyIncrement > $stok )
            {
                return response()->json([], 422);
            } else 
            {
                DB::collection('keranjang')
                ->where('nama_produk', $request->nama_produk )
                ->where('username', auth()->user()->username )
                ->increment('qty', $req_qty);
            }
        } else
        {
            Keranjang::create([
                'username' => auth()->user()->username,
                'nama_produk' => $request->nama_produk,
                'url_gambar' => $request->url_gambar,
                'harga' => $request->harga,
                'berat' => $request->berat,
                'stok' => $request->stok,
                // 'qty' => Keranjang::where('nama_produk', $request->nama_produk )
                //          ->where('username', auth()->user()->username )
                //          ->max('qty')+1
                'qty' => $req_qty
                ]);
        } 
    }

    /**
     * Display the specified resource.
     */
    public function show(Keranjang $keranjang)
    {
        $keranjang   = Keranjang::where('username', auth()->user()->username)
                       ->get();
        $total_produk= Keranjang::where('username', auth()->user()->username)
                       ->count();
        $total_bayar = Keranjang::all()->sum('harga');

        return view ('keranjang', compact('keranjang','total_produk','total_bayar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Keranjang $keranjang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Keranjang $keranjang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Keranjang $keranjang)
    {
        //
    }

    public function qty($nama_produk)
    {
        DB::collection('keranjang')
        ->where('nama_produk', $nama_produk )
        ->where('username', auth()->user()->username )
        ->increment('qty', 1);
    }

    public function qty_keranjang(Request $request)
    {
        $qty = intval($request->qty);

        DB::collection('keranjang')
        ->where('nama_produk', $request->nama_produk )
        ->where('username', auth()->user()->username )
        ->update(['qty' => $qty]);
    }

    public function delete_keranjang(Request $request)
    {
        DB::collection('keranjang')
        ->where('nama_produk', $request->nama_produk )
        ->where('username', auth()->user()->username )
        ->delete();
    }
}

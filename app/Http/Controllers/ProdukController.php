<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produk = Produk::paginate(7);
        return response()->json($produk->items());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $produk=Produk::create([
        'nama_produk' => $request->nama_produk,
        'kegunaan' => $request->kegunaan,
        'stok' => $request->stok,
        'url_gambar' => $request->url_gambar,
        'harga' => $request->harga
        ]);

        return response()-> json($produk);
    }

    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
        return response()-> json([
            'data' => $produk
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produk $produk)
    {
        $produk->nama_produk = $request->nama_produk;
        $produk->kegunaan = $request->kegunaan;
        $produk->stok = $request->stok;
        $produk->url_gambar = $request->no_url_gambarhp;

        return response()-> json($produk);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        $produk->delete();
        return response()-> json([
            'message' => 'berhasil dihapus'
        ],204);
    }

    public function link($nama_produk)
    {
        $produk=Produk::where('nama_produk', $nama_produk)->first();
        return view ('produk', compact('produk'));
    }

    public function cari(Request $request)
    {
        $hasil=Produk::where('nama_produk', 'like','%'.$request->cari.'%')
               ->orWhere('kegunaan', 'like','%'.$request->cari.'%')
               ->get();
        return view ('cari', compact('hasil'));
    }

    public function list()
    {
        $data = Produk::paginate(7);
        return view('daftarproduk',compact('data'));
    }
}

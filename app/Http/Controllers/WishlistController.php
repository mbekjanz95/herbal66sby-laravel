<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
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
        Wishlist::create([
            'username' => auth()->user()->username,
            'nama_produk' => $request->nama_produk,
            'url_gambar' => $request->url_gambar,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Wishlist $wishlist)
    {
        $wishlist=Wishlist::where('username', auth()->user()->username)->get();
        return view ('wishlist', compact('wishlist'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wishlist $wishlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wishlist $wishlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $delete = Wishlist::where('nama_produk', $request->nama_produk)->delete();
        return $delete;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Keranjang;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all(); // Retrieve all customers
        return response()->json($customers);
    }

    public function tampil()
    {
        return view ('registration');
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
        try 
        {
        $validated = $request->validate([
            'email' => 'required|email|unique:customer,email',
            'username' => 'required|string|max:6|unique:customer,username',
            'nama_lengkap' => 'required|string',
            'no_hp' => 'required|digits_between:11,13|unique:customer,no_hp',
            'password' => 'required|string|min:6|max:10'
        ]);

        $validated['password'] = Hash::make($validated['password']);
        Customer::create($validated);
        } catch (\Illuminate\Validation\ValidationException $e) 
        {
            $errors = $e->validator->errors()->all();

            // return response()->json(['errors' => $errors], 422);
            return response()->json([$errors], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return response()-> json([
            'data' => $customer
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $customer->email = $request->email;
        $customer->username = $request->username;
        $customer->nama_lengkap = $request->nama_lengkap;
        $customer->no_hp = $request->no_hp;
        $customer->password = $request->password;
        $customer->konf_password = $request->konf_password;

        return response()-> json([
            'data' => $customer
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()-> json([
            'message' => 'berhasil dihapus'
        ],204);
    }

    public function checkout()
    {
        $customer  = Customer::where('username', auth()->user()->username)
                    ->first();
        $keranjang = Keranjang::where('username', auth()->user()->username)
                    ->get();
        $kota = City::all();

        return view('checkout', compact('customer','keranjang','kota'));
    }

}

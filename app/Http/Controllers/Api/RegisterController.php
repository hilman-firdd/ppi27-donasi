<?php

namespace App\Http\Controllers\Api;

use App\Models\Donatur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function register(Request $request){
        //set validasi
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:donaturs',
            'password' => 'required|min:8|confirmed'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        //create donatur
        $donatur = Donatur::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        //return json
        return response()->json([
            'success' => true,
            'message' => 'Register Berhasil',
            'data' => $donatur,
            'token' => $donatur->createToken('authToken')->accessToken
        ], 201);
    }
}

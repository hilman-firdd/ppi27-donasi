<?php

namespace App\Http\Controllers\Api;

use App\Models\Donatur;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //return with response JSON
        return response()->json([
            'success' => true,
            'message' => 'Data Profile',
            'data'    => auth()->guard('api')->user(),
        ], 200);
    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @return void
     */
    public function update(Request $request)
    {
        //dd($request->all());


        $validator = Validator::make($request->all(), [
            'name'             => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //get data profile
        $donatur = Donatur::whereId(auth()->guard('api')->user()->id)->first();

        //update with upload avatar
        if($request->file('avatar')) {

            //hapus image lama
            Storage::disk('local')->delete('public/donaturs/'.basename($donatur->image));

            //upload image baru
            $image = $request->file('avatar');
            $image->storeAs('public/donaturs', $image->hashName());

            $donatur->update([
                'name'      => $request->name,
                'avatar'    => $image->hashName()
            ]);

        } 

        //update without avatar
        $donatur->update([
            'name'      => $request->name,
        ]);

        //return with response JSON
        return response()->json([
            'success' => true,
            'message' => 'Data Profile Berhasil Diupdate!',
            'data'    => $donatur,
        ], 201);

    }
    
    /**
     * updatePassword
     *
     * @param  mixed $request
     * @return void
     */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $donatur = Donatur::whereId(auth()->guard('api')->user()->id)->first();
        $donatur->update([
            'password'  => Hash::make($request->password)
        ]);
            

        //return with response JSON
        return response()->json([
            'success' => true,
            'message' => 'Password Berhasil Diupdate!',
            'data'    => $donatur,
        ], 201);
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slider;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class SliderController extends Controller
{
    public function index(){
        $sliders = Slider::latest()->paginate(5);
        return view('admin.slider.index', compact('sliders'));
    }   

    public function store(Request $request ){
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'link' => 'required'
        ]);

        //uplode image
        $image = $request->file('image');
        $image->storeAs('public/sliders', $image->hashName());

        //save db
        $slider = Slider::create([
            'image' => $image->hashName(),
            'link' => $request->link
        ]);

        if($slider){
            //redirect dengan pesan sukses
            return redirect()->route('admin.slider.index')->with(['success' => 'Data Berhasil ditambahkan']);
        }else{
            //redirect pesan error
            return redirect()->route('admin.slider.index')->with(['error' => 'Data gagal disimpan']);
        }
    }

    public function destroy($id){
        $slider = Slider::findOrFail($id);
        Storage::disk('local')->delete('public/sliders'. basename($slider->image));
        $slider->delete();

        if($slider){
            return response()->json([
                'status' => 'sukses'
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }

    
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;

class SliderController extends Controller
{
    public function index() {
        //get data sliders
        $sliders = Slider::latest()->get();

        //return with response json
        return response()->json([
            'success' => true,
            'message' => 'list data Sliders',
            'data' => $sliders
        ], 200);
    }
}

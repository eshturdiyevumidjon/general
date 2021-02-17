<?php

namespace App\Http\Controllers\General;

use App\UzRegions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MapController extends Controller
{
    public function index()
    {
        $uz_regions = UzRegions::all();

        return view('general.pages.map.map',[
            'uz_regions'=>$uz_regions
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CityController extends Controller
{
    public function __invoke()
    {   
        $cities = City::all();
        return response()->json($cities, Response::HTTP_OK);
    }
}

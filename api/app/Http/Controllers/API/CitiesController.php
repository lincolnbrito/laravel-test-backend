<?php

namespace App\Http\Controllers\API;

use App\City;
use App\State;
use App\Http\Controllers\Controller;
use App\Http\Resources\City as Resource;
use Illuminate\Http\Request;

class CitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(State $state)
    {
        return Resource::collection(City::where('state_id', $state->id)->get());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(State $state, City $city)
    {
        return Resource::make($city);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PropertyStoreRequest;
use App\Http\Requests\PropertyUpdateRequest;
use App\Http\Resources\Property as Resource;
use App\Property;
use Illuminate\Http\Request;
use App\Jobs\SendEmail;

class PropertiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $properties = Property::all();

        return Resource::collection($properties);
    }

    /**
     * Display a listing of unhired properties
     *
     * @return \Illuminate\Http\Response
     */
    public function unhired()
    {
        $properties = Property::doesntHave('contract')->get();

        return Resource::collection($properties);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\PropertyStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PropertyStoreRequest $request)
    {
        try {
            $property = Property::create($request->all());
            $property->load('city:id,name','state:id,name');

            $details = ['email' => $property->email];
            SendEmail::dispatch($details);

            return response()->json([
                'data' => $property
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e
            ], $e->getStatusCode ?? 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function show(Property $property)
    {
        return Resource::make($property);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\PropertyUpdateRequest  $request
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function update(PropertyUpdateRequest $request, Property $property)
    {
       //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property)
    {
        $deleted = $property->delete();

        return response()->json([], 204);
    }
}

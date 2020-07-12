<?php

namespace App\Http\Controllers\API;

use App\Contract;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContractStoreRequest;
use App\Http\Resources\Contract as Resource;
use Illuminate\Http\Request;

class ContractsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contracts = Contract::all();

        return Resource::collection($contracts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ContractStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContractStoreRequest $request)
    {
        try {
            $contract = Contract::create($request->all());

            return response()->json([
                'data' => $contract
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
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function show(Contract $contract)
    {
        return Resource::make($contract);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contract $contract)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contract $contract)
    {
        $deleted = $property->delete();

        return response()->json([], 204);
    }
}

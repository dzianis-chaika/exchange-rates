<?php

namespace App\Http\Controllers;

use App\Http\Resources\CurrencyResource;
use App\Models\Currency;
use Illuminate\Http\Request;

class ApiV1CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Currency::query();

        if ($request->query('valuteID')) {
            $query->where('valuteID', $request->query('valuteID'));
        }

        if ($request->query('from')) {
            $query->whereDate('date', '>=', $request->date('from'));
        }

        if ($request->query('to')) {
            $query->whereDate('date', '<=', $request->date('to'));
        }

        return CurrencyResource::collection($query->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'valuteID' => 'required',
            'numCode' => 'required',
            'charCode' => 'required',
            'name' => 'required',
            'value' => 'required|numeric',
            'date' => 'required|date',
        ]);

        return new CurrencyResource(
            Currency::create($request->input())
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function show(Currency $currency)
    {
        return new CurrencyResource($currency);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Currency $currency)
    {
        $request->validate([
            'value' => 'numeric',
            'date' => 'date',
        ]);

        $currency->update($request->input());

        return new CurrencyResource($currency);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Currency $currency)
    {
        $currency->delete();

        return response('', 204);
    }
}

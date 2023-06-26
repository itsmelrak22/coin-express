<?php

namespace App\Http\Controllers;

use App\Models\ExchangeHistory;
use Illuminate\Http\Request;

class ExchangeHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = ExchangeHistory::orderBy('created_at', 'desc')->get();
        return $data;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $market = new ExchangeHistory;
        $market->client_id = $request->client_id;
        $market->client_name = $request->client_name;
        $market->exchange_name = $request->exchange_name;
        $market->remarks = $request->remarks;

        $market->agent_id = $request->agent_id;
        $market->email = $request->email;
        $market->inviter_email = $request->inviter_email;
        $market->Amount = $request->Amount;
        $market->Asset = $request->Asset;
        $market->prev_Asset = $request->prev_Asset;
        $market->invitation_code = $request->invitation_code;

        $market->save();
        return response()->json('The post successfully Save');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExchangeHistory  $exchangeHistory
     * @return \Illuminate\Http\Response
     */
    public function show(ExchangeHistory $exchangeHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExchangeHistory  $exchangeHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(ExchangeHistory $exchangeHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExchangeHistory  $exchangeHistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExchangeHistory $exchangeHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExchangeHistory  $exchangeHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExchangeHistory $exchangeHistory)
    {
        //
    }
}

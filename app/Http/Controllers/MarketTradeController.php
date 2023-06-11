<?php

namespace App\Http\Controllers;

use App\Models\MarketTrade;
use Illuminate\Http\Request;

class MarketTradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return MarketTrade::all();
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
        $market = new MarketTrade;
        $market->No = $request->No;
        $market->Count = $request->Count;
        $market->Direction = $request->direction;
        $market->Price = $request->lastPrice;
        $market->Number = $request->price24hPcnt;

        $market->save();
        return response()->json('The post successfully Save');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MarketTrade  $marketTrade
     * @return \Illuminate\Http\Response
     */
    public function show(MarketTrade $marketTrade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MarketTrade  $marketTrade
     * @return \Illuminate\Http\Response
     */
    public function edit(MarketTrade $marketTrade)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MarketTrade  $marketTrade
     * @return \Illuminate\Http\Response
     */
 public function update(Request $request)
 {
     // Get the maximum row limit
    //  return $request;
//  return dd($MarketTrade::desc('updated_at')->get(););
     // Retrieve all the existing rows from the database
     $marketRows = MarketTrade::all();
     $maxRows = 15;
//  return dd($maxRows);
     // Check if the maximum row limit has been reached
   
         // Move each row to the next position in reverse order
         for ($i = $maxRows - 1; $i >= 1; $i--) {
             $marketRows[$i]->No = $marketRows[$i - 1]->No;
             $marketRows[$i]->Count = $marketRows[$i - 1]->Count;
             $marketRows[$i]->Direction = $marketRows[$i - 1]->Direction;
             $marketRows[$i]->Price = $marketRows[$i - 1]->Price;
             $marketRows[$i]->Number = $marketRows[$i - 1]->Number;
             $marketRows[$i]->updated_at = $marketRows[$i - 1]->updated_at;
             $marketRows[$i]->save();
         }
         // Update the first row with the new data
         $marketRows[0]->No = $request->No;
         $marketRows[0]->Count = $request->Count;
         $marketRows[0]->Direction = $request->direction;
         $marketRows[0]->Price = $request->lastPrice;
         $marketRows[0]->Number = $request->price24hPcnt;
         $marketRows[0]->updated_at = $request->updated_at;
         $marketRows[0]->save();
   
     return response()->json('The post has been successfully updated.');
 }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MarketTrade  $marketTrade
     * @return \Illuminate\Http\Response
     */
    public function destroy(MarketTrade $marketTrade)
    {
        //
    }
}

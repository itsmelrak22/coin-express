<?php

namespace App\Http\Controllers;

use App\Models\TradeOrder;
use Illuminate\Http\Request;

class TradeOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return TradeOrder::all();

    }

    public function GetTID(){
        $data = TradeOrder::orderBy('created_at', 'desc')
        ->pluck('T_id');

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
        $profit = 0.000;

        $TradeOrder = new TradeOrder;
        $TradeOrder->User_code = $request->userId;
        $TradeOrder->T_id = $request->T_id;
        $TradeOrder->user_account = $request->email;
        $TradeOrder->contract = $request->symbolDisplayName;
        $TradeOrder->type = $request->direction;
        $TradeOrder->seconds = $request->discountResult;
        $TradeOrder->trading = $request->trading;
        $TradeOrder->quantity = $request->recharge;
        $TradeOrder->opening_price = $request->open;
        $TradeOrder->closing_price = $request->close;
        $TradeOrder->profit =$request->profit;
        $TradeOrder->order_time = $request->order_time;
       
        $TradeOrder->closing_time = $request->closing_time;
        $TradeOrder->Updated_by = $request->name;
        $TradeOrder->save();
        return response()->json('The post successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TradeOrder  $tradeOrder
     * @return \Illuminate\Http\Response
     */
    public function show(TradeOrder $tradeOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TradeOrder  $tradeOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(TradeOrder $tradeOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TradeOrder  $tradeOrder
     * @return \Illuminate\Http\Responsev
     */
    public function update(Request $request)
    {
        // 
        // return dd($request);
        $TradeOrder = TradeOrder::find($request->id);

        // $TradeOrder->complete_time = $request->complete_time;
        // $TradeOrder->result = $request->result;
        $TradeOrder->preset = $request->preset;
        // $TradeOrder->closing_time = $request->closing_time;

        $TradeOrder->save();
        return response()->json('The book successfully added');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TradeOrder  $tradeOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(TradeOrder $tradeOrder)
    {
        //
    }
    public function calculateCount(Request $request)
    {
        $data = TradeOrder::all();
        
        foreach ($data as $item) {
            // return dd($item);
            if ($item['counting'] <= 0  && $item['T_id'] == $request->T_id){
                if($item['preset'] === null){
                    $item['trading'] = 'closed'; // Replace 'updated value' with the desired updated value for item.trading
                    $item['complete_time'] = date('Y-m-d H:i:s'); 
                    $item['preset'] = 'Win';
                    $item['result'] = $request->result;
                    $item->save(); // Save the updated item to the database if needed
                }else if($item['preset'] === 'Win'){
                    $item['trading'] = 'closed'; // Replace 'updated value' with the desired updated value for item.trading
                    $item['complete_time'] = date('Y-m-d H:i:s'); 
                    $item['result'] = $request->result;
                    $item->save(); // Save the updated item to the database if needed
                }else if($item['preset'] === 'Lost'){
                    $item['trading'] = 'closed'; // Replace 'updated value' with the desired updated value for item.trading
                    $item['complete_time'] = date('Y-m-d H:i:s'); 
                    $item['quantity'] = $request->quantity;
                    $item->save(); // Save the updated item to the database if needed
                }
              
            }
        }
        return response()->json('Items updated successfully');
    }
}

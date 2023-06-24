<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return Deposit::all();

        $data = Deposit::orderBy('created_at', 'desc')
        ->pluck('OrderNumber');

        return $data;
    }

    public function RechargeDetailsAdmin()
    {
       $data =  Deposit::orderBy('created_at', 'desc')->get();
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
        $deposit = new Deposit;
        $deposit->OrderNumber = $request->ordernumber;
        $deposit->UserID = $request->userid;
        $deposit->UserAccount = $request->useraccount;
        $deposit->Type = $request->methods;
        $deposit->Amount = $request->amount;
        $deposit->State = $request->state;
        $deposit->Methods = $request->methods;
        $deposit->save();
        return response()->json('The post successfully Save');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function show(Deposit $deposit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function edit(Deposit $deposit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // return dd($request);
        try{
            Deposit::where('ordernumber', $request->ordernumber)
            ->update([
                'OrderNumber' => $request->ordernumber,
                'UserID' => $request->userid,
                'UserAccount' => $request->useraccount,
                'Type' => $request->methods,
                'Amount' => $request->amount,
                'State' => 'Waiting for Payment',
                'Methods' => $request->methods,
            ]);
        return response()->json('The post successfully Updated');
        }catch(Exception $e){
            echo "Error updating";
        }
    }



    public function CancelOrderClient(Request $request)
    {
        // return dd($request);
        try{
            Deposit::where('ordernumber', $request->ordernumber)
            ->update([
                'OrderNumber' => $request->ordernumber,
                'UserID' => $request->userid,
                'UserAccount' => $request->useraccount,
                'Type' => $request->methods,
                'Amount' => $request->amount,
                'State' => 'Cancelled Order Client',
                'Methods' => $request->methods,
            ]);
        return response()->json('The post successfully Updated');
        }catch(Exception $e){
            echo "Error updating";
        }
    }


    //admin function
    public function update2(Request $request)
    {

        try{
            Deposit::where('ordernumber', $request->OrderNumber)
            ->update([
                'OrderNumber' => $request->OrderNumber,
                'UserID' => $request->UserID,
                'UserAccount' => $request->UserAccount,
                'Type' => $request->Methods,
                'Amount' => $request->Amount,
                'State' => 'Paid',
                'Methods' => $request->Methods,
            ]);
        return response()->json('The post successfully Updated');
        }catch(Exception $e){
            echo "Error updating";
        }

    }

    public function CancelOrderAdmin(Request $request)
    {

        try{
            Deposit::where('ordernumber', $request->OrderNumber)
            ->update([
                'OrderNumber' => $request->OrderNumber,
                'UserID' => $request->UserID,
                'UserAccount' => $request->UserAccount,
                'Type' => $request->Methods,
                'Amount' => $request->Amount,
                'State' => 'Cancelled Order Admin',
                'Methods' => $request->Methods,
            ]);
        return response()->json('The post successfully Updated');
        }catch(Exception $e){
            echo "Error updating";
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deposit $deposit)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Http\Request;

class MidtransController extends Controller
{
    public function index() {
        return view ('pay');
    }

    public function pay(Request $request) {
        $clientKey = env('clientKey');
        return view('pay', compact('clientKey'));
    }

    public function snap(Request $request) {
        //Set Your server key
        Config::$serverKey = env('serverKey');
        Config::$isSanitized = true;
        Config::$is3ds = true;
        
        $transaction_details = array(
            'order_id' => rand(),
            'gross_amount' => $request->quantity * 100, // no decimal allowed for creditcard
        );
    
        // Fill transaction details
        $transaction = array(
            'transaction_details' => $transaction_details,
        );
        $snapToken = Snap::getSnapToken($transaction);
        
        return response($snapToken);
    }
}

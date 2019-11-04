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

    public function snap(Request $request) {
        //Set Your server key
        Config::$serverKey = env('serverKey');
        Config::$isSanitized = true;
        Config::$is3ds = true;
        $clientKey = env('clientKey');
        
        $transaction_details = array(
            'order_id' => rand(),
            'gross_amount' => 94000, // no decimal allowed for creditcard
        );
        // Optional
        $item1_details = array(
            'id' => 'a1',
            'price' => 18000,
            'quantity' => 3,
            'name' => "Apple"
        );
        // Optional
        $item2_details = array(
            'id' => 'a2',
            'price' => 20000,
            'quantity' => 2,
            'name' => "Orange"
        );
        // Optional
        $item_details = array ($item1_details, $item2_details);
        // Optional
        $billing_address = array(
            'first_name'    => "Andri",
            'last_name'     => "Litani",
            'address'       => "Mangga 20",
            'city'          => "Jakarta",
            'postal_code'   => "16602",
            'phone'         => "081122334455",
            'country_code'  => 'IDN'
        );
        // Optional
        $shipping_address = array(
            'first_name'    => "Obet",
            'last_name'     => "Supriadi",
            'address'       => "Manggis 90",
            'city'          => "Jakarta",
            'postal_code'   => "16601",
            'phone'         => "08113366345",
            'country_code'  => 'IDN'
        );
        // Optional
        $customer_details = array(
            'first_name'    => "Andri",
            'last_name'     => "Litani",
            'email'         => "andri@litani.com",
            'phone'         => "081122334455",
            'billing_address'  => $billing_address,
            'shipping_address' => $shipping_address
        );
        // Optional, remove this to display all available payment methods
        $enable_payments = array('credit_card','cimb_clicks','mandiri_clickpay','echannel');
        // Fill transaction details
        $transaction = array(
            'enabled_payments' => $enable_payments,
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'item_details' => $item_details,
        );
        $snapToken = Snap::getSnapToken($transaction);
        
        return view('pay', compact('snapToken', 'clientKey'));
    }
}

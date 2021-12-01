<?php

namespace App\Http\Controllers\api;

use App\Http\Resources\OrderResource;
use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\StripeInitiatePayment;
use Stripe\Customer;
use Stripe\EphemeralKey;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Auth;

class OrderController extends Controller
{
    public function stripe_payment($amount)
    {
        Stripe::setApiKey(env('STRIPE_API_KEY'));
        $customer = Customer::create();
        $ephemeralKey = EphemeralKey::create(
            ['customer' => $customer->id],
            ['stripe_version' => '2020-08-27']
        );
        $paymentIntent = PaymentIntent::create([
            'amount' => $amount,
            'currency' => 'usd',
            'customer' => $customer->id,
            'payment_method_types' => ['card'],
        ]);
        $stripe_payment = new StripeInitiatePayment();
        $stripe_payment->paymentIntent = $paymentIntent->client_secret;
        $stripe_payment->ephemeralKey = $ephemeralKey->secret;
        $stripe_payment->customer = $customer->id;
        $stripe_payment->user_id = Auth::user()->id;
        $stripe_payment->save();
        return response([
            'paymentIntent' => $paymentIntent->client_secret,
            'ephemeralKey' => $ephemeralKey->secret,
            'customer' => $customer->id,
        ]);
    }

    public function order(Request $request){
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'contact' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'payment_id' => 'required',
            'product_id' => 'required',
            'price' => 'required',
            'quantity' => 'required',
        ]);

        $order =new Order();
        $order->name = $request->name;
        $order->address = $request->address;
        $order->contact = $request->contact;
        $order->city = $request->city;
        $order->state = $request->state;
        $order->country = $request->country;
        $order->payment_id = $request->payment_id;
        $order->product_id = $request->product_id;
        $order->price = $request->price;
        $order->order_status_id = 1;
        $order->quantity = $request->quantity;
        $order->user_id = Auth::user()->id;
        $order->save();

        return response()->json(['msg' => 'Order place', 'data' => new OrderResource($order), 'success' => true], 200);

    }

}

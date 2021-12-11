<?php

namespace App\Http\Controllers\api;

use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use App\Order;
use App\OrderStatus;
use App\Product;
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

    public function placeOrder(Request $request){
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'contact' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'product_id' => 'required',
            'price' => 'required',
            'quantity' => 'required',
        ]);
        $product = Product::where('id',$request->product_id)->where('quantity','>',$request->quantity )->where('is_owner_product',0)->where('is_active',1)->get()->first();
        if(!$product){
            return response()->json(['msg' => 'Product not found', 'data' => '', 'success' => true], 404);

        }
        $product->quantity = $product->quantity -  $request->quantity;
        $product->save();
        $order =new Order();
        $order->name = $request->name;
        $order->address = $request->address;
        $order->contact = $request->contact;
        $order->city = $request->city;
        $order->state = $request->state;
        $order->country = $request->country;
        $order->payment_id = $request->payment_id??0;
        $order->product_id = $request->product_id;
        $order->unit_price   = $request->price;
        $order->total_price = $request->price *  $request->quantity;
        $order->order_status_id = 1;
        $order->quantity = $request->quantity;
        $order->user_id = Auth::user()->id;
        $order->order_status = 1;
        $order->salon_id = $product->salon_id ?? 0;
        $order->is_admin_order = 0;
        $order->save();

        return response()->json(['msg' => 'Order place', 'data' => new OrderResource($order), 'success' => true], 200);

    }

    public function ordersList(){
        $orders = new Order();
        if(isset($_GET['status']) && !empty($_GET['status'])){
            $status = $_GET['status'];
            $orders = $orders->where('order_status_id', $status);
        }
        $orders = $orders
            ->where('order_status',1)
            ->where("is_admin_order",0)
            ->where('user_id', Auth::user()->id)
            ->orderBy('orders.id','desc')
            ->get();
        $order_status = OrderStatus::all();

        return response()->json(['msg' => 'Order list', 'data' => OrderResource::collection($orders),'order_status' => $order_status, 'success' => true], 200);

    }
}

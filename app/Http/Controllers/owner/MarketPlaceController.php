<?php

namespace App\Http\Controllers\owner;

use App\Http\Controllers\Controller;
use App\Order;
use App\Product;
use Auth;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class MarketPlaceController extends Controller
{
    public function index(){
        $products = Product::where('is_owner_product',true)->where('quantity', '>' , 0)->paginate(1000);
        return view('owner.market_place.index', compact('products'));
    }



    public function checkout(Request $request){
        $carts = session()->get('cart', []);
        $orders = [];
        if(session()->get('cart')) {
            $name = $request->name;
            $contact = $request->contact;
            $city = $request->city;
            $state = $request->state;
            $country = $request->country;
            $address = $request->address;
            \Stripe\Stripe::setApiKey('sk_test_51K2yYvAwQFVC9X9FIJ6jlHmLoCDc4OGLIeUvGJTjeuZ42iOa4sTDgrDpzzg933A1ITUi09pwXsgdzpPpcyDrC1a100yIJLjLgp');
            $items = array();
            foreach ($carts as $cart){
                $product = Product::find($cart['id']);
                $order = new Order();
                $order->name = $name;
                $order->address = $address;
                $order->contact = $contact;
                $order->city = $city;
                $order->state = $state;
                $order->country = $country;
                $order->payment_id = "";
                $order->tracking_no = "";
                $order->product_id = $cart['id'];
                $order->unit_price = $cart['price'];
                $order->total_price = $cart['price'] * $cart['quantity'];
                $order->quantity = $cart['quantity'];
                $order->user_id = Auth::user()->id;
                $order->is_admin_order = 1;
                $order->salon_id = $product->salon->salon_id ?? 0;
                $order->order_status = 0;
                $order->save();

                $orders[] = $order->id;

                $item = array();
                $item['name'] = $cart['name'];
                $item['quantity'] = $cart['quantity'];
                $item['amount'] = $cart['price'] * 100;
                $item['currency'] = 'USD';
                $items[] = $item;
            }
            $orders = serialize($orders);
            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $items,
                'mode' => 'payment',
                'success_url' => route('cart-success-url').'?ids='.$orders,
                'cancel_url' => route('cart-cancel-url').'?ids='.$orders,
            ]);
            return redirect( $session->url);
        }
        else{
            return redirect()->back();
        }
    }

    public function addToCart($id){

        $product = Product::find($id);

        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "id" => $id,
                "name" => $product->title,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->first_image
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success_message', 'Product added to cart successfully!');
    }

    public function show_cart(){
        return view('owner.market_place.cart');
    }

    public function remove($id)
    {
        if($id) {
            $cart = session()->get('cart');
            if(isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
            }
            return redirect()->back()->with('success_message', 'Product removed successfully!');
        }
    }


    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success_message', 'Cart updated successfully');
        }
    }


    public function successRedirect(Request $request){
        $orders = $request->ids;
        $orders = unserialize($orders);
        foreach ($orders as $id){
            $order = Order::find($id);
            if($order){
                $order->order_status = 1;
                $order->save();
            }
        }
        session()->put('cart',[]);
        return redirect()->route('market_place')->with('success_message', 'Order place successfully ');
    }

    public function cancelRedirect(Request $request){
        $orders = $request->ids;
        $orders = unserialize($orders);
        foreach ($orders as $id){
            $order = Order::find($id);
            if($order){
                $order->delete();
            }
        }
        return redirect()->route('owner_show_cart')->with('error_message', 'Wrong card info, please try with correct info');
    }

}

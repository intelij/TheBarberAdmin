<?php

namespace App\Http\Controllers\owner;

use App\Http\Controllers\Controller;
use App\Product;
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
        \Stripe\Stripe::setApiKey('sk_test_51K2yYvAwQFVC9X9FIJ6jlHmLoCDc4OGLIeUvGJTjeuZ42iOa4sTDgrDpzzg933A1ITUi09pwXsgdzpPpcyDrC1a100yIJLjLgp');
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'name' => "BBBB",
                    'currency' => "USD",
                    'amount' =>  10 * 100,
                    'quantity' => 1,
                ],  [
                    'name' => "AAAA",
                    'currency' => "USD",
                    'amount' =>  20 * 100,
                    'quantity' => 2,
                ],  [
                    'name' => "CCCCC",
                    'currency' => "USD",
                    'amount' =>  30 * 100,
                    'quantity' => 3,
                ]],
            'mode' => 'payment',
            'success_url' => 'https://example.com/success?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => 'https://example.com/cancel',
        ]);

        return redirect( $session->url);
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
            session()->flash('success', 'Cart updated successfully');
        }
    }

}

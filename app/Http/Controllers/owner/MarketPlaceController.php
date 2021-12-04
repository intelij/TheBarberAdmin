<?php

namespace App\Http\Controllers\owner;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Stripe\Charge;
use Stripe\Stripe;

class MarketPlaceController extends Controller
{
    public function index(){
        $products = Product::where('is_owner_product',true)->where('quantity', '>' , 0)->paginate(25);
        return view('owner.market_place.index', compact('products'));
    }

    public function checkout(Request $request, $id){
        Stripe::setApiKey('sk_test_51K2yYvAwQFVC9X9FIJ6jlHmLoCDc4OGLIeUvGJTjeuZ42iOa4sTDgrDpzzg933A1ITUi09pwXsgdzpPpcyDrC1a100yIJLjLgp');
        Charge::create ([
            "amount" => 100 * 150,
            "currency" => "inr",
            "source" => $request->stripeToken,
            "description" => "Making test payment."
        ]);


        return back();
        $product = Product::find($id);
        return view('owner.market_place.checkout', compact('product'));

    }
}

<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Offer;

class OfferController extends Controller
{
    public function index()
    {
        $offers = Offer::orderBy('id', 'DESC')->paginate(5);
        return view('admin.pages.offer', compact('offers'));
    }

    public function create()
    {
        return view('admin.offer.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'bail|required',
            'image' => 'bail|required',
            'discount' => 'bail|required|numeric',
        ]);

        $offer = new Offer();
        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $name = 'offer_'.time().'.'. $image->getClientOriginalExtension();
            $destinationPath = public_path('/storage/images/offer');
            $image->move($destinationPath, $name);
            $offer->image = $name;
        }
        $offer->title = $request->title;
        $offer->discount = $request->discount;
        $offer->save();
        return response()->json(['success' => true,'data' => $offer, 'msg' => 'Offer create'], 200);
    }

    public function show($id)
    {
        $data['offer'] = Offer::find($id);
        return response()->json(['success' => true,'data' => $data, 'msg' => 'Offer show'], 200);
    }

    public function edit($id)
    {
        $offer = Offer::find($id);
        return response()->json(['success' => true,'data' => $offer], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'bail|required',
            'discount' => 'bail|required|numeric',
        ]);
        
        $offer = Offer::find($id);
        if($request->hasFile('image'))
        {
            if(\File::exists(public_path('/storage/images/offer/'. $offer->image))){
                \File::delete(public_path('/storage/images/offer/'. $offer->image));
            }
        
            $image = $request->file('image');
            $name = 'offer_'.time().'.'. $image->getClientOriginalExtension();
            $destinationPath = public_path('/storage/images/offer');
            $image->move($destinationPath, $name);
            $offer->image = $name;
        }
        $offer->title = $request->title;
        $offer->discount = $request->discount;

        $offer->save();
        return response()->json(['success' => true,'data' => $offer, 'msg' => 'Offer edit'], 200);
    }

    public function destroy($id)
    {
        $offer = Offer::find($id);
        \File::delete(public_path('/storage/images/offer/'. $offer->image));
        $offer->delete();
        return redirect('/admin/offer');
    }
    
    public function hideOffer(Request $request)
    {
        $offer = Offer::find($request->offerId);
        if ($offer->status == 0) 
        {   
            $offer->status = 1;
            $offer->save();
        }
        else if($offer->status == 1)
        {
            $offer->status = 0;
            $offer->save();
        }
    }
}

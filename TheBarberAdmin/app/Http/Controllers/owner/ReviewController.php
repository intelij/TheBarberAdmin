<?php

namespace App\Http\Controllers\owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Review;
use App\Salon;

class ReviewController extends Controller
{
    public function index()
    {   
        $salon = Salon::where('owner_id', Auth()->user()->id)->first();
        $reviews = Review::where('salon_id', $salon->salon_id)
        ->orderBy('review_id', 'DESC')
        ->paginate(5);
        return view('owner.pages.review', compact('reviews'));
    }

    public function show($id)
    {
        $data['review'] = Review::with('user','salon')->find($id);
        return response()->json(['success' => true,'data' => $data, 'msg' => 'Review show'], 200);
    }

    public function reportReview(Request $request)
    {
        $review = Review::find($request->reviewId);
        if ($review->report == 0) 
        {   
            $review->report = 1;
            $review->save();
        }
        else if($review->report == 1)
        {
            $review->report = 0;
            $review->save();
        }
    }
}

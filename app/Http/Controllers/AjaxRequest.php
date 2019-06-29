<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Validator;
use Auth;
class AjaxRequest extends Controller
{
    public function product_review(Request $request)
    {
        $request->user_id = Auth::user()->id;
        $request->product_id = $request->id;

        $validation = Validator::make($request->all(),
            [
                'rating' => ['required','integer'],
            ]);
        if($validation->fails())
            return redirect(route('products.show', ['id' => $request->product_id]))->withErrors($validation)->withInput();

        $review = new \App\Models\ProductReview();
        $review->user_id = $request->user_id;
        $review->product_id = $request->product_id;
        $review->description = $request->description;
        $review->rating = $request->rating;


        $data['review'] = \App\Models\ProductReviews::where('product_id', $request->product_id)->orderBy('id','DESC')->get();
        
        if($review->save())
            // return "success";
            return view('product/show', $data);    
        else
            return "Gagal";
    }
}

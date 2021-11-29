<?php

namespace App\Http\Controllers\owner;

use App\Category;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductImage;
use App\Salon;
use Faker\Provider\Image;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function index(){
        $products = Product::orderBy('created_at')->paginate(10);
        return view('owner.pages.product', compact('products'));
    }

    public function create(){
        $salons = Salon::all();
        $categories = Category::all();
        return view('owner.product.create', compact('salons','categories'));
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'bail|required',
            'description' => 'bail|required',
            'category_id' => 'bail|required',
            'salon_id' => 'bail|required',
            'price' => 'bail|required',
            'quantity' => 'bail|required',
            'image' => 'bail|required',
        ]);

        $image_name = '';
        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $name = 'emp_'.time().'.'. $image->getClientOriginalExtension();
            $destinationPath = public_path('/storage/images/product');
            $image->move($destinationPath, $name);
            $image_name = $name;
        }

        $product = new Product();
        $product->title = $request->title;
        $product->description = $request->description;
        $product->salon_id = $request->salon_id;
        $product->category_id = $request->category_id;
        $product->is_active = $request->is_active;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->save();

        $product_image = new ProductImage();
        $product_image->image_url = $image_name;
        $product_image->product_id = $product->id;
        $product_image->image_position = 1;
        $product_image->save();

        return redirect('/owner/product');

    }

    public function hideProduct(Request $request){
        $productId = Product::find($request->productId);
        if ($productId->is_active == 0)
        {
            $productId->is_active = 1;
            $productId->save();
        }
        else if($productId->is_active == 1)
        {
            $productId->is_active = 0;
            $productId->save();
        }
    }

    public function destroy($id){
        $product = Product::find($id);
        $images = ProductImage::where('product_id',$id)->delete();
        $product->delete();
    }
}

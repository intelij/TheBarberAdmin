<?php

namespace App\Http\Controllers\owner;

use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductImage;
use App\Salon;
use Illuminate\Http\Request;
use Auth;

class ProductController extends Controller
{
    public function index(){
        $salon = Salon::where('owner_id', Auth()->user()->id)->first();
        $products = new Product();
        if(isset($_GET['status']) && !empty($_GET['status'])){
            $status = $_GET['status'] == 'active' ? 1 : 0;
            $products = $products->where('is_active', $status);
        }
        $products = $products->where('salon_id', $salon->salon_id)->orderBy('id','desc')->paginate(25);
        return view('owner.pages.product', compact('products'));
    }

    public function create(){
        $categories = Category::all();
        return view('owner.product.create', compact('categories'));
    }

    public function store(Request $request){
        $salon = Salon::where('owner_id', Auth()->user()->id)->first();
        $request->validate([
            'title' => 'bail|required',
            'description' => 'bail|required',
            'category_id' => 'bail|required',
            'price' => 'bail|required',
            'quantity' => 'bail|required',
            'image' => 'bail|required|array|max:5',
            'image.*' => 'bail|mimes:jpeg,jpg,png,gif|max:5000'

        ]);

        $product = new Product();
        $product->title = $request->title;
        $product->description = $request->description;
        $product->salon_id = $salon->salon_id;
        $product->category_id = $request->category_id;
        $product->is_active = $request->is_active;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->save();

        foreach($request->file('image') as $image){
            $name =  rand(00001,999999). time().'.'. $image->getClientOriginalExtension();
            $destinationPath = public_path('/storage/images/product');
            $image->move($destinationPath, $name);

            $product_image = new ProductImage();
            $product_image->image_url = $name;
            $product_image->product_id = $product->id;
            $product_image->image_position = 1;
            $product_image->save();
        }

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

    public function edit($id){
        $categories = Category::all();
        $product = Product::find($id);
        return view('owner.product.edit', compact('categories', 'product'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'title' => 'bail|required',
            'description' => 'bail|required',
            'category_id' => 'bail|required',
            'price' => 'bail|required',
            'quantity' => 'bail|required',
            'image' => 'array|max:5',
            'image.*' => 'bail|mimes:jpeg,jpg,png,gif|max:5000'
        ]);
        $product = Product::find($id);

        if($request->hasFile('image'))
        {
            ProductImage::where('product_id', $product->id)->delete();
            foreach($request->file('image') as $image){
                $name =  rand(00001,999999). time().'.'. $image->getClientOriginalExtension();
                $destinationPath = public_path('/storage/images/product');
                $image->move($destinationPath, $name);
                $product_image = new ProductImage();
                $product_image->image_url = $name;
                $product_image->product_id = $product->id;
                $product_image->image_position = 1;
                $product_image->save();
            }

        }

        $product->title = $request->title;
        $product->description = $request->description;
        $product->category_id = $request->category_id;
        $product->is_active = $request->is_active;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->save();

        return redirect('/owner/product');
    }

    public function show($id){
        $product = Product::find($id);
        $image = $product->images[0];

        return view('owner.product.show', compact('image', 'product'));
    }
}

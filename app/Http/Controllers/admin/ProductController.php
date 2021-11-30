<?php

namespace App\Http\Controllers\admin;

use App\Category;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Product;
use App\ProductImage;
use App\Salon;
use Faker\Provider\Image;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function index(){
        $products = Product::orderBy('id','desc')->paginate(10);
        return view('admin.pages.product', compact('products'));
    }


    public function create(){
        $salons = Salon::all();
        $categories = Category::all();
        return view('admin.product.create', compact('salons','categories'));
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

        return redirect('/admin/product');

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
        $salons = Salon::all();
        $categories = Category::all();
        $product = Product::find($id);
        $image = $product->images[0];

        return view('admin.product.edit', compact('salons','categories', 'image', 'product'));
    }


    public function update(Request $request, $id){
        $request->validate([
            'title' => 'bail|required',
            'description' => 'bail|required',
            'category_id' => 'bail|required',
            'salon_id' => 'bail|required',
            'price' => 'bail|required',
            'quantity' => 'bail|required',
        ]);
        $product = Product::find($id);

        if($request->hasFile('image'))
        {
            $images = ProductImage::where('product_id',$id)->delete();
            $image = $request->file('image');
            $name = 'emp_'.time().'.'. $image->getClientOriginalExtension();
            $destinationPath = public_path('/storage/images/product');
            $image->move($destinationPath, $name);
            $product_image = new ProductImage();
            $product_image->image_url = $name;
            $product_image->product_id = $product->id;
            $product_image->image_position = 1;
            $product_image->save();
        }

        $product->title = $request->title;
        $product->description = $request->description;
        $product->salon_id = $request->salon_id;
        $product->category_id = $request->category_id;
        $product->is_active = $request->is_active;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->save();

        return redirect('/admin/product');
    }

    public function show($id){
        $product = Product::find($id);
        $image = $product->images[0];

        return view('admin.product.show', compact('image', 'product'));
    }

    public function apiProductList($salon_id){
        $products = Product::where('salon_id',$salon_id)->get();
        $data = ProductResource::collection($products);
        return response()->json(['msg' => 'Product list', 'data' => $data, 'success' => true], 200);
    }

    public function apiProductDetails($id){
        $product = Product::find($id);
        if($product) {
            return response()->json(['msg' => 'Product details', 'data' => new ProductResource($product), 'success' => true], 200);
        }
        else{
            return response()->json(['success' => false, 'message' => 'No product found']);
        }
    }

}

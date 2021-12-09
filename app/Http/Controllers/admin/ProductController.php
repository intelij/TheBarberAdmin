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
use Auth;

class ProductController extends Controller
{
    public function index(){
        $products = new Product();
        if(isset($_GET['salon']) && !empty($_GET['salon'])){
            $products = $products->where('salon_id', $_GET['salon']);
        }
        if(isset($_GET['status']) && !empty($_GET['status'])){
            $status = $_GET['status'] == 'active' ? 1 : 0;
            $products = $products->where('is_active', $status);
        }
        $products = $products->orderBy('id','desc')->paginate(25);
        $salons = Salon::all();
        return view('admin.pages.product', compact('products', 'salons'));
    }


    public function create(){
        $salons = Salon::all();
        $categories = Category::all();
        $user_id = Auth::user()->id;
        return view('admin.product.create', compact('salons','categories', 'user_id'));
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'bail|required',
            'description' => 'bail|required',
            'category_id' => 'bail|required',
            'salon_id' => 'bail|required',
            'price' => 'bail|required',
            'quantity' => 'bail|required',
            'image' => 'bail|required|array|max:5',
            'image.*' => 'bail|mimes:jpeg,jpg,png,gif|max:5000'

        ]);

        $product = new Product();
        $product->title = $request->title;
        $product->description = $request->description;
        $product->salon_id = $request->salon_id;
        $product->category_id = $request->category_id;
        $product->is_active = $request->is_active;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->is_owner_product = $request->salon_id == Auth::user()->id ? true : false;
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
        $user_id = Auth::user()->id;
        return view('admin.product.edit', compact('salons','categories', 'product', 'user_id'));
    }


    public function update(Request $request, $id){
        $request->validate([
            'title' => 'bail|required',
            'description' => 'bail|required',
            'category_id' => 'bail|required',
            'salon_id' => 'bail|required',
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
        $product->salon_id = $request->salon_id;
        $product->category_id = $request->category_id;
        $product->is_active = $request->is_active;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->is_owner_product = $request->salon_id == Auth::user()->id ? true : false;
        $product->save();

        return redirect('/admin/product');
    }

    public function show($id){
        $product = Product::find($id);

        return view('admin.product.show', compact( 'product'));
    }

    public function apiProductList($salon_id){
        $products = Product::where('salon_id',$salon_id)->where('quantity','>',0)->where('is_active',1)->get();
        $data = ProductResource::collection($products);
        return response()->json(['msg' => 'Product list', 'data' => $data, 'success' => true], 200);
    }

    public function apiProductDetails($id){
        $product = Product::where('id', $id)->where('is_active',1)->get()->first();
        if($product) {
            return response()->json(['msg' => 'Product details', 'data' => new ProductResource($product), 'success' => true], 200);
        }
        else{
            return response()->json(['success' => false, 'message' => 'No product found']);
        }
    }

}

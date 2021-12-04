<?php

namespace App\Http\Controllers\admin;

use App\Category;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Order;
use App\OrderStatus;
use App\Product;
use App\ProductImage;
use App\Salon;
use Faker\Provider\Image;
use Illuminate\Http\Request;
use Auth;

class OrderController extends Controller
{
    public function index(){
        $orders = new Order();
        if(isset($_GET['status']) && !empty($_GET['status'])){
            $status = $_GET['status'];
            $orders = $orders->where('order_status_id', $status);
        }
        $orders = $orders->orderBy('id','desc')->paginate(25);
        $order_status = OrderStatus::all();
        return view('admin.order.index', compact('orders', 'order_status'));
    }

    public function show($id){
        $order = Order::find($id);
    }

    public function updateOrderStatus($id, $status){
        $order = Order::find($id);
        $order->order_status_id = $status;
        $order->save();
        return redirect()->back();
    }
}

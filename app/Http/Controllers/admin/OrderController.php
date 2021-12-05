<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Order;
use App\OrderStatus;
use App\Salon;
use Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        $orders = new Order();
        if(isset($_GET['status']) && !empty($_GET['status'])){
            $status = $_GET['status'];
            $orders = $orders->where('order_status_id', $status);
        }

        if(isset($_GET['salon']) && !empty($_GET['salon'])){
            if($_GET['salon'] == 'own'){
                $orders = $orders->where('is_admin_order', 1);
            }
            else{
                $orders =  $orders->where('is_admin_order', 0);
                $orders = $orders->join('products', 'orders.product_id', '=', 'products.id');
                $orders = $orders->where('products.salon_id', $_GET['salon']);
            }
        }

        $orders = $orders->orderBy('orders.id','desc')->paginate(25);
        $order_status = OrderStatus::all();
        $salons = Salon::all();
        return view('admin.order.index', compact('orders', 'order_status', 'salons'));
    }

    public function show($id){
        $order = Order::find($id);
        $order_status = OrderStatus::all();
        return view('admin.order.show', compact('order', 'order_status'));
    }

    public function updateOrderStatus(Request $request, $id){
        $order = Order::find($id);
        $order->order_status_id = $request->order_status_id;
        $order->tracking_no = $request->tracking_no;
        $order->save();
        return redirect()->back();
    }
}

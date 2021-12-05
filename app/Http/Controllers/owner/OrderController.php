<?php

namespace App\Http\Controllers\owner;

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
        $orders = $orders
            ->where('salon_id', Auth::user()->salon_id)
            ->orderBy('orders.id','desc')
            ->paginate(25);
        $order_status = OrderStatus::all();
        return view('owner.order.index', compact('orders', 'order_status'));
    }

    public function show($id){
        $order = Order::find($id);
        $order_status = OrderStatus::all();
        return view('owner.order.show', compact('order', 'order_status'));
    }

    public function updateOrderStatus(Request $request, $id){
        $order = Order::find($id);
        $order->order_status_id = $request->order_status_id;
        $order->tracking_no = $request->tracking_no;
        $order->save();
        return redirect()->back();
    }
}

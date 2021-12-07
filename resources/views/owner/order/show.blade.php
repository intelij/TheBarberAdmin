@extends('layouts.app')
@section('content')

    @include('layouts.top-header', [
        'title' => __('View') ,
        'headerData' => __('Product') ,
        'url' => 'owner/product' ,
        'class' => 'col-lg-7'
    ])


    <div class="container-fluid mt--6 mb-5">
        <div class="row">
            @foreach($order->product->images as $image)
                <div class="col-4">
                    <div class="card">
                        <img style="width: 100%; height: 150px;" class="card-img-top"
                             src="{{asset('storage/images/product/'.$image->image_url)}}"
                             alt="{{$order->product->title}}">
                    </div>
                </div>
            @endforeach

        </div>
        <div class="row mt-3">

            <div class="col-xl-8  mb-5 mb-xl-0">
                <div class="card card-profile shadow">
                    <div class="card-body pt-0 pt-md-4">
                        <h3 class="mb-2 text-center">Order info</h3>
                        <div class="">
                            <h3>{{$order->product->title}}</h3>
                            <p>{{$order->product->description}}</p>
                            <div class="row">
                                <div class="col-6">
                                    <p>Category: {{$order->product->category->name}}</p>
                                </div>
                                <div class="col-6">
                                    <p>Salon: {{$order->product->salon->name ?? "Owner product"}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <p>Quantity: {{$order->quantity}}</p>
                                </div>
                                <div class="col-6">
                                    <p>Price: {{$order->total_price}}</p>
                                </div>
                                <div class="col-12 text-center">
                                    <p>Order Status: {{$order->status->value ?? ""}}</p>
                                </div>
                            </div>
                            <hr class="my-4"/>
                            <h3 class="mb-2 text-center">Address Details</h3>
                            <div class="row">
                                <div class="col-6">
                                    <p>Name: {{$order->name}}</p>
                                </div>
                                <div class="col-6">
                                    <p>Phone: {{$order->contact}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <p>City: {{$order->city}}</p>
                                </div>
                                <div class="col-4">
                                    <p>State: {{$order->state}}</p>
                                </div>
                                <div class="col-4">
                                    <p>Country: {{$order->country}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <p>Tracking no: {{$order->tracking_no}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6"></div>
                                <div class="col-6"></div>
                            </div>
                            <hr class="my-4"/>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4  mb-5 mb-xl-0">
                <div class="card card-profile shadow ">
                    <div class="card-body pt-0 pt-md-4">
                        <h3 class="text-center mb-5">Update order info</h3>
                        <div class="">
                            <form method="post" action="{{route('owner_update_order_status', $order->id)}}">
                                @csrf
                                <div class="form-group">
                                    <label>Select status</label>
                                    <select class="form-control" name="order_status_id" id="order_status_id" onchange="upDateTrackingNo(this)">
                                        @foreach($order_status as $order_sta)
                                            <option value="{{$order_sta->id}}">{{$order_sta->value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group" id="tracking_no">
                                    <label>Tracking no</label>
                                    <input class="form-control" placeholder="Insert tracking no" type="text" value="{{$order->tracking_no}}" name="tracking_no"/>
                                </div>
                                <div class="text-center">
                                    <button class="btn btn-primary rtl-float-none" type="submit">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <script>
        $(document).ready(function () {
            $("#order_status_id").val("{{$order->order_status_id}}");
            @if($order->order_status_id == 2)
                $("#tracking_no").show();
            @else
                $("#tracking_no").hide();
            @endif
        })

        function upDateTrackingNo(e){
            if($("#order_status_id").val() == 2){
                $("#tracking_no").show();
            }
            else {
                $("#tracking_no").hide();
            }
        }
    </script>
@endsection

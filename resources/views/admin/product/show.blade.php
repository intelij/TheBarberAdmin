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
        <div class="col-xl-8 order-xl-2 mb-5 mb-xl-0 offset-2">
            <div class="card card-profile shadow">
                <div class="row justify-content-center">
                    <div class="col-lg-3 order-lg-2">
                        <div class="card-profile-image">
                            <img src="{{asset('storage/images/product/'.$image->image_url)}}" class="rounded-circle salon_round">
                        </div>
                    </div>
                </div>
                <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                    <div class="d-flex justify-content-between">
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="card-profile-stats d-flex justify-content-center mt-md-5">

                        </div>
                    </div>
                </div>
                <div class="card-body pt-0 pt-md-4">
                    <div class="text-center">
                        <h3>
                            {{$product->title}}
                        </h3>
                        <p>{{$product->description}}</p>
                        <p>Category: {{$product->category->name}}</p>
                        <p>Salon: {{$product->salon->name}}</p>
                        <p>Price: {{$product->price}}</p>
                        <p>Quantity: {{$product->quantity}}</p>
                        <p>Status: {{$product->status}}</p>
                        <hr class="my-4" />
                        <a class="btn btn-primary text-white  rtl-float-none" href="{{url('admin/product/edit/'.$product->id)}}"> {{__('Edit Product')}} </a>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


@endsection

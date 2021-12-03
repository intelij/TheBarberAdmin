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
            @foreach($product->images as $image)
                <div class="col-4">
                    <div class="card">
                        <img  style="width: 100%; height: 150px;" class="card-img-top" src="{{asset('storage/images/product/'.$image->image_url)}}" alt="{{$product->title}}">
                    </div>
                </div>
            @endforeach

        </div>
        <div class="row mt-3">

            <div class="col-xl-8 order-xl-2 mb-5 mb-xl-0 offset-2">
                <div class="card card-profile shadow">
                    <div class="card-body pt-0 pt-md-4">
                        <div class="text-center">
                            <h3>
                                {{$product->title}}
                            </h3>
                            <p>{{$product->description}}</p>
                            <p>Category: {{$product->category->name}}</p>
                            <p>Salon: {{$product->salon->name ?? "Owner product"}}</p>
                            <p>Price: {{$product->price}}</p>
                            <p>Quantity: {{$product->quantity}}</p>
                            <p>Status: {{$product->status}}</p>
                            <hr class="my-4"/>
                            <a class="btn btn-primary text-white  rtl-float-none"
                               href="{{url('admin/product/edit/'.$product->id)}}"> {{__('Edit Product')}} </a>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection

@extends('layouts.app')
@section('content')

    @include('layouts.top-header', [
            'title' => __('Market place'),
            'class' => 'col-lg-7'
        ])

    <div class="container-fluid mt--6 mb-5">
        @if (count($products) != 0)
            <div class="row">
                @foreach ($products as $key => $product)
                    <div class="col-4 mb-5">
                        <div class="card" >
                            <img class="card-img-top"
                                 src="{{$product->first_image}}"
                                 alt="Card image cap" style="width: 100%; height: 220px">
                            <div class="card-body">
                                <h5 class="card-title">
                                    {{$product->title}}
                                </h5>
                                <div class="row">
                                    <div class="col-9">
                                        <p>Category title: {{$product->category->name??""}}</p>
                                    </div>
                                    <div class="col-3">
                                        <p>${{$product->price}}</p>
                                    </div>
                                </div>
                                <p class="card-text">
                                    {{$product->description}}
                                </p>
                                <div class="text-center">
                                    <a href="{{route('checkout',$product->id)}}" class="btn btn-primary">Purchase</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>{{__('No products')}}</p>
        @endif
        <div class="float-right mr-4 mb-1">
            {{ $products->links() }}
        </div>
    </div>
@endsection

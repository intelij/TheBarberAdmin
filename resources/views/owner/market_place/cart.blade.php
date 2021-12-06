@extends('layouts.app')
@section('content')
    <style>
        .thumbnail {
            position: relative;
            padding: 0px;
            margin-bottom: 20px;
        }

        .thumbnail img {
            width: 80%;
        }

        .thumbnail .caption {
            margin: 7px;
        }

        .main-section {
            background-color: #F8F8F8;
        }

        .dropdown {
            float: right;
            padding-right: 30px;
        }

        .btn {
            border: 0px;
            margin: 10px 0px;
            box-shadow: none !important;
        }

        .dropdown .dropdown-menu {
            padding: 20px;
            top: 30px !important;
            width: 350px !important;
            left: -110px !important;
            box-shadow: 0px 5px 30px black;
        }

        .total-header-section {
            border-bottom: 1px solid #d2d2d2;
        }

        .total-section p {
            margin-bottom: 20px;
        }

        .cart-detail {
            padding: 15px 0px;
        }

        .cart-detail-img img {
            width: 100%;
            height: 100%;
            padding-left: 15px;
        }

        .cart-detail-product p {
            margin: 0px;
            color: #000;
            font-weight: 500;
        }

        .cart-detail .price {
            font-size: 12px;
            margin-right: 10px;
            font-weight: 500;
        }

        .cart-detail .count {
            color: #C2C2DC;
        }

        .checkout {
            border-top: 1px solid #d2d2d2;
            padding-top: 15px;
        }

        .checkout .btn-primary {
            border-radius: 50px;
            height: 50px;
        }

        .dropdown-menu:before {
            content: " ";
            position: absolute;
            top: -20px;
            right: 50px;
            border: 10px solid transparent;
            border-bottom-color: #fff;
        }
    </style>
    @include('layouts.top-header', [
            'title' => __('Cart list'),
            'class' => 'col-lg-7'
        ])
    <div class="container-fluid mt--6 mb-5">
        @if(session('success_message'))
            <div class="alert alert-success">
                {{ session('success_message') }}
            </div>
        @endif
        <div class="row">
            <div class="col">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header border-0">
                        <span class="h3">{{__('Cart')}}</span>
                    </div>
                    <div class="card-header border-0 text-center">
                    </div>
                    <!-- table -->
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col" class="sort">{{__('Product')}}</th>
                                <th scope="col" class="sort">{{__('Price')}}</th>
                                <th scope="col" class="sort">{{__('Quantity')}}</th>
                                <th scope="col" class="sort">{{__('Subtotal')}}</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody class="list">
                            @php $total = 0 @endphp
                            @if(session('cart'))
                                @foreach (session('cart') as $id => $product)
                                    @php $total += $product['price'] * $product['quantity'] @endphp
                                    <tr>
                                        <td><img src="{{$product['image']}}" width="100" height="100"
                                                 class="img-responsive"/> {{$product['name']}}</td>
                                        <td>{{$product['price']}}</td>
                                        <td><input onchange="updateCart({{ $product['id']}})" id="{{$product['id']}}_quantity" type="number" value="{{ $product['quantity'] }}"
                                                   class="form-control quantity update-cart"/></td>
                                        <td>${{ $product['price'] * $product['quantity'] }}</td>
                                        <td>
                                            <a href="{{route('remove.from.cart',$product['id'])}}"
                                               onclick="return confirm('Are you sure you want to delete this item')"
                                               class="btn btn-danger btn-sm remove-from-cart"><i
                                                    class="fa fa-trash-o"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tr>
                                    @else
                                        <tr>
                                            <th colspan="10" class="text-center">{{__('No item in cart')}}</th>
                                        </tr>
                                    @endif
                            </tbody>
                            @if(session('cart'))
                                <tfoot>
                                <tr>
                                    <td colspan="5" class="text-right"><h3><strong>Total ${{ $total }}</strong></h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right">
                                        <a href="{{ url('/owner/market-place') }}" class="btn btn-warning">
                                            <i class="fa fa-angle-left"></i>Continue Shopping
                                        </a>
                                        <a href="{{route('checkout')}}" class="btn btn-success">Checkout</a>
                                    </td>
                                </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateCart(id){
            $.ajax({
                url: '{{ route('update.cart') }}',
                method: "patch",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    quantity: $("#"+id+"_quantity").val()
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        }
    </script>
@endsection

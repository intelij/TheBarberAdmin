@extends('layouts.app')
@section('content')

    @include('layouts.top-header', [
            'title' => __('Orders'),
            'class' => 'col-lg-7'
        ])

    <div class="container-fluid mt--6 mb-5">
        <div class="row">
            <div class="col">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header border-0">
                        <span class="h3">{{__('Orders')}}</span>
                    </div>
                    <div class="card-header border-0 text-center">
                        <div class="row">
                            <div class="col-4">
                                <form method="get" action="{{route('owner_order')}}">
                                    <input type="hidden" value="{{isset($_GET['show_product']) ? $_GET['show_product'] : ""}}" />
                                    <div class="form-group">
                                        <select class="form-control" name="status" id="status" onchange="this.form.submit()">
                                            <option value="">Select product status</option>
                                            @foreach($order_status as $order_sta)
                                                <option value="{{$order_sta->id}}">{{$order_sta->value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </form>
                            </div>

                            <div class="col-4">
                                <form method="get" action="{{route('owner_order')}}">
                                    <input type="hidden" value="{{isset($_GET['status']) ? $_GET['status'] : ""}}" />
                                    <div class="form-group">
                                        <select class="form-control" name="show_product" id="show_product" onchange="this.form.submit()">
                                            <option value="">All products</option>
                                            <option value="own">My purchase order</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- table -->
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col" class="sort">{{__('#')}}</th>
                                <th scope="col" class="sort">{{__('Image')}}</th>
                                <th scope="col" class="sort">{{__('Title')}}</th>
                                <th scope="col" class="sort">{{__('Category')}}</th>
                                <th scope="col" class="sort">{{__('Amount')}}</th>
                                <th scope="col" class="sort">{{__('Quantity')}}</th>
                                <th scope="col" class="sort">{{__('Status')}}</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody class="list">
                            @if (count($orders) != 0)
                                @foreach ($orders as $key => $order)
                                    <tr>
                                        <th>{{$key + 1}}</th>
                                        <th><img src="{{$order->product->first_image??""}}"
                                                 style="width: 50px; height: 50px; "/></th>
                                        <td>{{$order->product->title??""}}</td>
                                        <td>{{$order->product->category->name??""}}</td>
                                        <td>${{$order->total_price}}</td>
                                        <td>{{$order->product->quantity}}</td>
                                        <td>
                                            {{$order->status->value??""}}
                                        </td>

                                        <td class="table-actions">
                                            <a href="{{url('owner/order/'.$order->id)}}"
                                               class="table-action text-warning" data-toggle="tooltip"
                                               data-original-title="{{__('View Order')}}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tr>
                                    @else
                                        <tr>
                                            <th colspan="10" class="text-center">{{__('No orders')}}</th>
                                        </tr>
                                    @endif
                            </tbody>
                        </table>
                        <div class="float-right mr-4 mb-1">
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            @if(isset($_GET['status']))
                $("#status").val("{{$_GET['status']}}");
            @endif
        })
    </script>
@endsection

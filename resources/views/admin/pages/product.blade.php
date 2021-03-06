@extends('layouts.app')
@section('content')

@include('layouts.top-header', [
        'title' => __('Products'),
        'class' => 'col-lg-7'
    ])

<div class="container-fluid mt--6 mb-5">
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header border-0">
                    <span class="h3">{{__('Product table')}}</span>
                    <button class="btn btn-primary addbtn float-right p-2"><a class="color-white" href="{{url('admin/product/create')}}"><i class="fas fa-plus mr-1"></i>{{__('Add New')}}</a></button>
                </div>
                    <div class="card-header border-0 text-center">
                    <div class="row">
                        <div class="col-4">
                            <form method="get" action="{{route('admin.product')}}">
                                <input type="hidden" value="{{$_GET['status'] ?? ""}}" name="status" />
                                <div class="form-group">
                                <select class="form-control" name="salon" id="salon" onchange="this.form.submit()">
                                    <option value="">Select salon</option>
                                    <option value="own">Own product</option>
                                    @foreach($salons as $salon)
                                        <option value="{{$salon->salon_id}}">{{$salon->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            </form>
                        </div>
                        <div class="col-4">
                            <form method="get"  action="{{route('admin.product')}}">
                                <input type="hidden" value="{{$_GET['salon'] ?? ""}}" name="salon" />
                                <div class="form-group">
                                    <select class="form-control" name="status" id="status" onchange="this.form.submit()">
                                        <option value="">Select product status</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">In-active</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="col-4">

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
                            <th scope="col" class="sort">{{__('Saloon')}}</th>
                            <th scope="col" class="sort">{{__('Price')}}</th>
                            <th scope="col" class="sort">{{__('Quantity')}}</th>
                            <th scope="col" class="sort">{{__('Status')}}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="list">
                        @if (count($products) != 0)
                            @foreach ($products as $key => $product)
                                <tr>
                                    <th>{{$products->firstItem() + $key}}</th>
                                    <th><img src="{{$product->first_image}}" style="width: 50px; height: 50px; " /></th>
                                    <td>{{$product->title}}</td>
                                    <td>{{$product->category->name??""}}</td>
                                    <td>{{$product->salon->name??"Owner product"}}</td>
                                    <td>${{$product->price}}</td>
                                    <td>{{$product->quantity}}</td>
                                    <td>
                                        <label class="custom-toggle">
                                            <input type="checkbox"  onchange="hideProduct({{$product->id}})" {{$product->is_active == 1?'checked': ''}}>
                                            <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                        </label>
                                    </td>

                                    <td class="table-actions">
                                        @php
                                            $base_url = url('/');
                                        @endphp
                                        <a href="{{url('admin/product/'.$product->id)}}" class="table-action text-warning" data-toggle="tooltip" data-original-title="{{__('View Product')}}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{url('admin/product/edit/'.$product->id)}}" class="table-action text-info" data-toggle="tooltip" data-original-title="{{__('Edit Product')}}">
                                            <i class="fas fa-user-edit"></i>
                                        </a>
                                        <button class="btn-white btn shadow-none p-0 m-0 table-action text-danger bg-white" onclick="deleteData('admin/product',{{$product->id}},'{{$base_url}}')" data-toggle="tooltip" data-original-title="{{__('Delete Product')}}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tr>
                        @else
                            <tr>
                                <th colspan="10" class="text-center">{{__('No products')}}</th>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="float-right mr-4 mb-1">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
      </div>
    </div>
</div>
<script>
    $(document).ready(function (){
        @if(isset($_GET['status']))
            $("#status").val("{{$_GET['status']}}");
        @endif

        @if(isset($_GET['salon']))
            $("#salon").val("{{$_GET['salon']}}");
        @endif
    })
</script>
@endsection

@extends('layouts.app')
@section('content')

@include('layouts.top-header', [
    'title' => __('Create') ,
    'headerData' => __('Product') ,
    'url' => 'owner/product' ,
    'class' => 'col-lg-7'
])

<div class="container-fluid mt--5">
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header border-0 text-center">
                    <span class="h3">{{__('Add Product')}}</span>
                </div>
                <div class="mx-4 ">
                    <div class="nav-wrapper">
                        <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                            <li class="nav-item">
                                <a style="cursor: default;"  class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab" href="javascript:void(0)" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true"><i class="fa fa-shopping-bag mr-2"></i>{{__('Product')}}</a>
                            </li>
                        </ul>
                    </div>
                    <form class="form-horizontal form" action="{{url('/owner/product/store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="card shadow">
                            <div class="my-0 mx-auto w-75">
                                <div class="card-body">
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                                            <div class="p-20">


                                                {{-- title --}}
                                                <div class="form-group">
                                                    <label class="form-control-label" for="title">{{__('Title')}}</label>
                                                    <input type="text" value="{{old('title')}}" name="title" id="title" class="form-control" placeholder="{{__('Product Title')}}"  autofocus>
                                                    @error('title')
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                {{-- description --}}
                                                <div class="form-group">
                                                    <label for="description" class="form-control-label">{{__('description')}} </label>
                                                    <textarea class="form-control" name="description" id="description" placeholder="{{__('Description')}}">{{old('description')}}</textarea>
                                                    @error('description')
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                {{-- Category --}}
                                                <div class="form-group">
                                                    <label class="form-control-label">{{__('Category')}}</label>
                                                    <select class="form-control select2" name="category_id" id="category_id" data-placeholder='{{ __("-- Select Category --")}}' placeholder='{{ __("-- Select Category --")}}' >
                                                        @foreach ($categories as $category)
                                                            <option  value="{{$category->cat_id}}" {{ old('cat_id') == $category->cat_id? 'selected':'' }}>{{$category->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('category_id')
                                                    <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                {{-- Product Status --}}
                                                <div class="form-group">
                                                        <label class="form-control-label">{{__('Is Active')}}</label><br>
                                                        <div class="custom-control custom-radio mb-2">
                                                            <input type="radio" id="yes" name="is_active" value="1" class="custom-control-input" checked>
                                                            <label class="custom-control-label" for="yes">{{__('Yes')}}</label>
                                                        </div>
                                                        <div class="custom-control custom-radio mb-2">
                                                            <input type="radio" id="no" name="is_active" value="0" class="custom-control-input">
                                                            <label class="custom-control-label" for="no">{{__('No')}}</label>
                                                        </div>
                                                    </div>

                                                {{-- Price --}}
                                                <div class="form-group">
                                                    <label for="price" class="form-control-label">{{__('Price')}}</label>
                                                    <input type="number" min="0" value="{{old('price')}}" class="form-control" name="price" id="price" placeholder="{{__('Price')}}" >
                                                    @error('price')
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                {{-- Quantity --}}
                                                <div class="form-group">
                                                    <label for="quantity" class="form-control-label">{{__('Quantity')}}</label>
                                                    <input type="number" min="0" value="{{old('quantity')}}" class="form-control" name="quantity" id="quantity" placeholder="{{__('Quantity')}}" >
                                                    @error('quantity')
                                                    <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                {{-- Image --}}
                                                <div class="form-group">
                                                    <label class="form-control-label">{{__('Image')}}</label><br>
                                                    <input type="file" id="image" name="image[]" accept="image/*" multiple ><br>
                                                    <img id="output" class="h-25 w-25 mt-3"/>
                                                    @error('image')
                                                    <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                            </div>
                                        </div>
                                        <div class="border-top">
                                            <div class="card-body text-center rtl-float-none">
                                                <input type="submit" class="btn btn-primary rtl-float-none" value="{{__('Submit')}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

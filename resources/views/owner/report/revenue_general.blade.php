@extends('layouts.app')
@section('content')

    @include('layouts.top-header', [
            'title' => __('General Report'),
            'class' => 'col-lg-7'
        ])

    <div class="container-fluid mt--6 mb-5">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header border-0">
                        <span class="h3">{{__('General details')}}</span>
                    </div>
                    <div class="card-header border-0 text-left">
                        <div class="row">
                            <div class="col-4 text-center mb-3">
                                <span class="h3">Total cash received: </span> {{$total_no_amount}}
                            </div>
                            <div class="col-4">
                                <span class="h3">Total no products: </span> {{$total_no_of_product}}
                            </div>
                            <div class="col-4">
                                <span class="h3">Total no order: </span> {{$total_no_of_order}}
                            </div>
                            <div class="col-6">
                                <span
                                    class="h3">Total amount from completed order: </span> {{$total_no_amount_completed}}
                            </div>
                            <div class="col-6">
                                <span
                                    class="h3">Total amount from in-progress order : </span> {{$total_no_amount_in_progress}}
                            </div>
                            <div class="col-6">
                                <span class="h3">Total amount from open order: </span> {{$total_no_amount_open}}
                            </div>
                            <div class="col-6">
                                <span class="h3">Total amount from cancel order : </span> {{$total_no_amount_cancel}}
                            </div>
                            <div class="col-6">
                                <span class="h3">Total no of open order : </span> {{$total_no_order_open}}
                            </div>
                            <div class="col-6">
                                <span class="h3">Total no of in-progress order : </span> {{$total_no_order_in_progress}}
                            </div>
                            <div class="col-6">
                                <span class="h3">Total no of completed order : </span> {{$total_no_order_completed}}
                            </div>
                            <div class="col-6">
                                <span class="h3">Total no of cancel order : </span> {{$total_no_order_cancel}}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
@endsection

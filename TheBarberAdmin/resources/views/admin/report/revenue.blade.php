@extends('layouts.app')
@section('content')

@include('layouts.top-header', [
        'title' => __('Revenue Report'),
        'class' => 'col-lg-7'
    ])

<div class="container-fluid mt--6 mb-5">
    <div class="row">
        <div class="col">
            <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
                <span class="h3">{{__('Revenue Report')}}</span>
            </div>
            <form action="{{url('/admin/report/revenue/filter')}}" method="post" class="ml-4" id="filter_revene_form">
                @csrf
                <div class="row rtl-date-filter-row">
                    <div class="form-group col-3">
                        <input type="text" id="filter_date" value="{{$pass}}" name="filter_date" class="form-control" placeholder="{{__('-- Select Date --')}}">
                        
                        @if($errors->any())
                            <h4 class="text-center text-red mt-2">{{$errors->first()}}</h4>
                        @endif
                    </div>
                    <div class="form-group col-3">
                        <button type="submit" id="filter_btn" class="btn btn-primary rtl-date-filter-btn">{{ __('Apply') }}</button>
                    </div>
                </div>
            </form>
            <!-- table -->
            <div class="table-responsive">
                <table class="table align-items-center table-flush" id="dataTable" class="dataTable">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th scope="col" class="sort">{{__('Booking id')}}</th>
                            <th scope="col" class="sort">{{__('User Name')}}</th>
                            <th scope="col" class="sort">{{__('Salon Name')}}</th>
                            <th scope="col" class="sort">{{__('Date / Time')}}</th>
                            <th scope="col" class="sort">{{__('Type')}}</th>
                            <th scope="col" class="sort">{{__('Payment')}}</th>
                            <th scope="col" class="sort">{{__('Commission')}}</th>
                            <th scope="col" class="sort">{{__('Salon Income')}}</th>
                        </tr>
                    </thead>
                    <tbody class="list">
                        <?php 
                            $commission = 0;
                            $payment_tot = 0;
                            $salon_income = 0;
                        ?>
                        @foreach ($bookings as $booking)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$booking->booking_id}}</td>
                                <td>{{$booking->user->name}}</td>
                                <td>{{$booking->salon->name}}</td>
                                <td>{{$booking->date}} {{$booking->start_time}}</td>
                                <td>
                                    @if ($booking->payment_type == "LOCAL" || $booking->payment_type == "Local")
                                        <span class="badge badge-pill badge-success">{{__('Cash')}}</span>
                                    @else
                                        <span class="badge badge-pill badge-success">Stripe</span>
                                    @endif
                                </td>
                                <td>{{$setting->currency_symbol}}{{$booking->payment}}</td>
                                <td>{{$setting->currency_symbol}}{{$booking->commission}}</td>
                                <td>{{$setting->currency_symbol}}{{$booking->salon_income}}</td>
                                
                                @php
                                    $payment_tot = $payment_tot + $booking->payment;
                                    $commission = $commission + $booking->commission;
                                    $salon_income = $salon_income + $booking->salon_income;
                                @endphp
                            </tr>
                        @endforeach
                        
                    </tbody>
                    <tfoot>
                        <tr class="total">
                            <td colspan="5"></td>
                            <td>{{__('Grand Total :')}} </td>
                            <td>{{$setting->currency_symbol}}{{$payment_tot}}</td>
                            <td>{{$setting->currency_symbol}}{{$commission}}</td>
                            <td>{{$setting->currency_symbol}}{{$salon_income}}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
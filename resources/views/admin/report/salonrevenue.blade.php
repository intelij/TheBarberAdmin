@extends('layouts.app')
@section('content')

@include('layouts.top-header', [
        'title' => __('Salon Revenue Report'),
        'class' => 'col-lg-7'
    ])



<div class="container-fluid mt--6 mb-5">
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header border-0">
                    <span class="h3">{{__('Salon Revenue Report')}}</span>
                </div>
                
                <form action="{{url('/admin/report/salon/revenue/filter')}}" method="post" class="ml-4" id="filter_revene_form">
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
                                <th>#</th>
                                <th scope="col" class="sort">{{__('Image')}}</th>
                                <th scope="col" class="sort">{{__('Name')}}</th>
                                <th scope="col" class="sort">{{__('Owner Name')}}</th>
                                <th scope="col" class="sort">{{__('Income')}}</th>
                                <th scope="col" class="sort">{{__('Commission')}}</th>
                                <th scope="col" class="sort">{{__('Registered date')}}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="list">
                        @php
                            $tot_income = 0;
                            $tot_commission = 0;
                        @endphp
                            @foreach ($salons as $salon)
                            @php
                                $income = 0;
                                $commission = 0;
                            @endphp
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>
                                        <img class="tableimage rounded" src="{{asset('storage/images/salon logos/'.$salon->image)}}">
                                    </td>
                                    <td>{{$salon->name}}</td>
                                    <td>{{$salon->ownerName}}</td>
                                    @foreach ($booking as $book)
                                        @if ($book->salon_id == $salon->salon_id)
                                            @php
                                                $income = $income + $book->salon_income;
                                                $commission = $commission + $book->commission;
                                            @endphp
                                        @endif
                                    @endforeach
                                    @php
                                        
                                        $tot_income = $tot_income + $income;
                                        $tot_commission = $tot_commission + $commission;
                                    @endphp
                                    <td>{{$setting->currency_symbol}}{{$income}}</td>
                                    <td>{{$setting->currency_symbol}}{{$commission}}</td>
                                    <td>{{\Carbon\Carbon::parse($salon->created_at)->format('Y-m-d')}}</td>
                                    <td class="table-actions">
                                        <a href="{{url('admin/salons/'.$salon->salon_id)}}" class="table-action text-warning" data-toggle="tooltip" data-original-title="{{__('View Salon')}}">
                                              <i class="fas fa-eye"></i>
                                        </a>
                                  </td>
                                </tr>
                            @endforeach
                        </tbody>
                        
                        <tr class="total">
                            <td colspan="3"></td>
                            <td>{{__('Grand Total :')}} </td>
                            <td>{{$setting->currency_symbol}}{{$tot_income}}</td>
                            <td>{{$setting->currency_symbol}}{{$tot_commission}}</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
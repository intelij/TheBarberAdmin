@extends('layouts.app')
@section('content')

@include('layouts.top-header', [
    'title' => __('View') ,
    'headerData' => __('Employee') ,
    'url' => 'owner/employee' ,
    'class' => 'col-lg-7'
])


<div class="container-fluid mt--6 mb-5">
    <div class="row">
        <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
            <div class="card card-profile shadow">
                <div class="row justify-content-center">
                    <div class="col-lg-3 order-lg-2">
                        <div class="card-profile-image">
                            <img src="{{asset('storage/images/employee/'.$emp->image)}}" class="rounded-circle salon_round">
                        </div>
                    </div>
                </div>
                <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                    <div class="d-flex justify-content-between">
                    </div>
                </div>
                <div class="card-body pt-0 pt-md-4">
                    <div class="row">
                        <div class="col">
                            <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                                <div>
                                    <span class="heading">{{count($emp->services)}}</span>
                                    <span class="description">{{__('Services')}}</span>
                                </div>
                                <div>
                                    <span class="heading">{{count($appointment)}}</span>
                                    <span class="description">{{__('Appointments')}}</span>
                                </div>
                                <div>
                                    <span class="heading">{{count($client)}}</span>
                                    <span class="description">{{__('Clients')}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <h3>
                            {{ $emp->name }}<span class="font-weight-light"></span>   
                        </h3>
                        <div>
                           {{__('Phone :')}} {{$emp->phone}}
                            <br>{{__('Email :')}} {{$emp->email}}
                            @if ($give_service == "Both")
                                <br>{{__('Give Services At :')}}
                                @if ($emp->give_service == "Both")
                                    Salon & Home
                                @else
                                    {{ $emp->give_service }}
                                @endif
                            @endif
                        </div>
                        <hr class="my-4" />
                        <a class="btn btn-primary text-white  rtl-float-none" href="{{url('owner/employee/edit/'.$emp->emp_id)}}"> {{__('Edit Employee')}} </a>

                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-8 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header border-0">
                    <h3>{{__('View Employee')}}</h3>
                </div>
                <div class="card-body rtl-icon">
                    <div class="nav-wrapper">
                        <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="false"><i class="ni ni-scissors mr-2"></i>{{__('Services')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false"><i class="ni ni-time-alarm mr-2"></i>{{__('Timing')}}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card shadow mx-auto my-0">
                        <div class="my-0 mx-auto w-90">
                            <div class="card-body">
                                <div class="tab-content" id="myTabContent">
                                    
                                    <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                                        <div class="card border-0">
                                            <div class="row">
                                                <div class="card-title h3 col-7">{{__('Services of')}} {{$emp->name}}</div>
                                                <div class="float-left col">
                                                    <div class="form-group">
                                                        <input type="text" name="search_service" onkeyup="service_search()" id="search_service" class="form-control" placeholder="Search Service" autofocus>
                                                        <i></i>
                                                    </div>
                                                </div>
                                            </div>
                                                <!-- Card body -->
                                            @if (count($emp->services) != 0)
                                                <div id="main_div">
                                                    @foreach ($emp->services as $ser)
                                                        <div class="card single_div">
                                                            <!-- Card body -->
                                                            <div class="card-body">
                                                                <div class="row align-items-center">
                                                                    <div class="col-auto">
                                                                        <!-- Avatar -->
                                                                        <div class="avatar avatar-xl rounded-circle">
                                                                            <img alt="Service Image" class="small_round" src="{{asset('storage/images/services/'.$ser->image)}}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col ml--2">
                                                                        <h4 class="mb-0"> {{$ser->name}} </h4>
                                                                        <span class="text-sm font-weight-500">{{__('Category :')}} </span><span class="text-sm text-muted">{{$ser->category->name}}</span><br>
                                                                        @if ($ser->status == 1)
                                                                            <span class="text-success">●</span>
                                                                            <small>Active</small>
                                                                        @else
                                                                            <span class="text-danger">●</span>
                                                                            <small>Inactive</small>
                                                                        @endif
                                                                        
                                                                    </div>
                                                                    <div class="col-auto">
                                                                        <span class="text-sm font-weight-500">{{__('Price :')}} </span><span class="text-sm text-muted">{{$symbol}}{{$ser->price}}</span><br>
                                                                        <span class="text-sm font-weight-500">{{__('Time :')}} </span><span class="text-sm text-muted">{{$ser->time}} {{__('Min')}}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="text-center">{{__('No Services Available')}}</div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                                        <div class="card border-0">
                                            <div class="card-title h3">{{__('Timing of')}} {{$emp->name}}</div>
                                            <!-- Card body -->
                                            <?php 
                                                $start_time1 = new Carbon\Carbon($emp->sunday['open']);
                                                $close_time1 = new Carbon\Carbon($emp->sunday['close']);
                                                
                                                $start_time2 = new Carbon\Carbon($emp->monday['open']);
                                                $close_time2 = new Carbon\Carbon($emp->monday['close']);
                                                
                                                $start_time3 = new Carbon\Carbon($emp->tuesday['open']);
                                                $close_time3 = new Carbon\Carbon($emp->tuesday['close']);
                                                
                                                $start_time4 = new Carbon\Carbon($emp->wednesday['open']);
                                                $close_time4 = new Carbon\Carbon($emp->wednesday['close']);
                                                
                                                $start_time5 = new Carbon\Carbon($emp->thursday['open']);
                                                $close_time5 = new Carbon\Carbon($emp->thursday['close']);
                                                
                                                $start_time6 = new Carbon\Carbon($emp->friday['open']);
                                                $close_time6 = new Carbon\Carbon($emp->friday['close']);
                                                
                                                $start_time7 = new Carbon\Carbon($emp->saturday['open']);
                                                $close_time7 = new Carbon\Carbon($emp->saturday['close']);
                                            ?>
                                               
                                            <div class="row align-items-center mt-4">
                                                <span class="font-weight-bold col-3 text-left"> {{__('Sunday :')}}</span>
                                                <span class="text-muted col">
                                                    @if ($emp->sunday['open'] == null && $emp->sunday['close'] == null)
                                                        {{__('OFF DAY')}}
                                                    @else
                                                        {{$start_time1->format('g:i A')}} To {{$close_time1->format('g:i A')}}
                                                    @endif
                                                </span><br>
                                            </div>
                                            <div class="row align-items-center">
                                                <span class="font-weight-bold col-3 text-left"> {{__('Monday :')}}</span>
                                                <span class="text-muted col">
                                                    @if ($emp->monday['open'] == null && $emp->monday['close'] == null)
                                                        {{__('OFF DAY')}}
                                                    @else
                                                        {{$start_time2->format('g:i A')}} To {{$close_time2->format('g:i A')}}
                                                    @endif
                                                </span><br>
                                            </div>
                                            <div class="row align-items-center">
                                                <span class="font-weight-bold col-3 text-left"> {{__('Tuesday :')}}</span>
                                                <span class="text-muted col">
                                                    @if ($emp->tuesday['open'] == null && $emp->tuesday['close'] == null)
                                                        {{__('OFF DAY')}}
                                                    @else
                                                        {{$start_time3->format('g:i A')}} To {{$close_time3->format('g:i A')}}
                                                    @endif
                                                </span><br>
                                            </div>
                                            <div class="row align-items-center">        
                                                <span class="font-weight-bold col-3 text-left">{{__('Wednesday :')}}</span>
                                                <span class="text-muted col">
                                                    @if ($emp->wednesday['open'] == null && $emp->wednesday['close'] == null)
                                                        {{__('OFF DAY')}}
                                                    @else
                                                        {{$start_time4->format('g:i A')}} To {{$close_time4->format('g:i A')}}
                                                    @endif
                                                </span><br>
                                            </div>
                                            <div class="row align-items-center">     
                                                <span class="font-weight-bold col-3 text-left"> {{__('Thursday :')}}</span>
                                                <span class="text-muted col">
                                                    @if ($emp->thursday['open'] == null && $emp->thursday['close'] == null)
                                                        {{__('OFF DAY')}}
                                                    @else
                                                        {{$start_time5->format('g:i A')}} To {{$close_time5->format('g:i A')}}
                                                    @endif
                                                </span><br>
                                            </div>
                                            <div class="row align-items-center">    
                                                <span class="font-weight-bold col-3 text-left"> {{__('Friday :')}}</span>
                                                <span class="text-muted col">
                                                    @if ($emp->friday['open'] == null && $emp->friday['close'] == null)
                                                        {{__('OFF DAY')}}
                                                    @else
                                                        {{$start_time6->format('g:i A')}} To {{$close_time6->format('g:i A')}}
                                                    @endif
                                                </span><br>
                                            </div>
                                            <div class="row align-items-center mb-4">   
                                                <span class="font-weight-bold col-3 text-left"> {{__('Saturday :')}}</span>
                                                <span class="text-muted col">
                                                    @if ($emp->saturday['open'] == null && $emp->saturday['close'] == null)
                                                        {{__('OFF DAY')}}
                                                    @else
                                                        {{$start_time7->format('g:i A')}} To {{$close_time7->format('g:i A')}}
                                                    @endif
                                                </span><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
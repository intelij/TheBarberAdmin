@extends('layouts.app')
@section('content')

@include('layouts.top-header', [
    'title' => __('Edit') ,
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
                    <div class="text-center mb-3">
                        <h3>
                            {{ $emp->name }}<span class="font-weight-light"></span>   
                        </h3>
                        <div>
                            {{__('Phone :')}} {{$emp->phone}}
                            <br>{{__('Email :')}} {{$emp->email}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-8 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header border-0">
                    <h3>{{__('Edit Employee')}}</h3>
                </div>
                <div class="card-body">
                    <div class="nav-wrapper rtl-icon">
                        <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true"><i class="ni ni-single-02 mr-2"></i>{{__('Employee')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false"><i class="ni ni-time-alarm mr-2"></i>{{__('Timing')}}</a>
                            </li>
                        </ul>
                    </div>
                    <form class="form-horizontal form" action="{{url('/owner/employee/update/'.$emp->emp_id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card shadow">
                            <div class="my-0 mx-auto w-75">
                                <div class="card-body">
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                                            <div class="p-20">

                                                {{-- Image --}}
                                                <div class="form-group">
                                                    <label class="form-control-label">{{__('Image')}}</label><br>
                                                    <input type="file" id="image" name="image" accept="image/*" onchange="loadFile(event)"><br>
                                                    <img id="output" class="uploadprofileimg mt-3" src="{{asset('storage/images/employee/'.$emp->image)}}"/>
                                                </div>
                        
                                                {{-- name --}}
                                                <div class="form-group">
                                                    <label class="form-control-label" for="name">{{__('Name')}}</label>
                                                    <input type="text" value="{{old('name', $emp->name)}}" name="name" id="name" class="form-control" placeholder="{{__('Salon Name')}}"  autofocus>
                                                    @error('name')                                    
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>
                        
                                                {{-- email --}}
                                                <div class="form-group">
                                                    <label for="email" class="form-control-label">{{__('Email')}} </label>
                                                    <input type="text" class="form-control" value="{{old('email', $emp->email)}}" name="email" id="email" placeholder="{{__('Employee Email')}}">
                                                    @error('email')                                    
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>
                        
                                                {{-- Services --}}
                                                <div class="form-group">
                                                    <label class="form-control-label">{{__('Services')}}</label>
                                                    <select class="form-control select2" multiple="multiple" name="services[]" id="services"  dir="{{ session()->has('direction')&& session('direction') == 'rtl'? 'rtl':''}}" >
                                                        @foreach ($services as $service)
                                                            <option value="{{$service->service_id}}" {{ (collect(old('services'))->contains($service->section_id)) ? 'selected':'' }} <?php if (in_array($service->service_id,json_decode($emp->service_id))) { echo "selected"; } ?> >{{$service->name}}</option>
                                                        @endforeach
                                                    </select> 
                                                    @error('services')                                    
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror  
                                                </div>
                                                    
                                                {{-- Give Services --}}
                                                @if ($salon->give_service == "Both")
                                                    <div class="form-group">
                                                        <label class="form-control-label">{{__('Give Services At')}}</label><br>
                                                        <div class="custom-control custom-radio mb-2">
                                                            <input type="radio" id="salon" name="give_service" value="Salon" class="custom-control-input" {{ $emp->give_service == "Salon" ? 'checked':'' }}>
                                                            <label class="custom-control-label" for="salon">{{__('Salon')}}</label>
                                                        </div>
                                                        <div class="custom-control custom-radio mb-2">
                                                            <input type="radio" id="home" name="give_service" value="Home" class="custom-control-input" {{ $emp->give_service == "Home" ? 'checked':'' }}>
                                                            <label class="custom-control-label" for="home">{{__('Home')}}</label>
                                                        </div>
                                                        <div class="custom-control custom-radio mb-2">
                                                            <input type="radio" id="both" name="give_service" value="Both" class="custom-control-input" {{ $emp->give_service == "Both" ? 'checked':'' }}>
                                                            <label class="custom-control-label" for="both">{{__('Both')}}</label>
                                                        </div>
                                                    </div>
                                                @endif
                        
                                                {{-- Phone no --}}
                                                <div class="form-group">
                                                    <label for="phone" class="form-control-label">{{__('Phone no')}}</label>
                                                    <input type="text" class="form-control" value="{{old('phone', $emp->phone)}}" name="phone" id="phone" placeholder="{{__('Phone no')}}" >
                                                    @error('phone')                                    
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>
                        
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                                            <div class="p-20">
                                                {{-- Sunday --}}
                                                <label for="phone" class="form-control-label">{{__('Sunday')}}</label>
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <input type="text" value="{{$salon->sunday['open'] == NULL ? 'Day Off':old('sunopen',Carbon\Carbon::parse($emp->sunday['open'])->format('h:i A'))}}"
                                                                    onclick="salonTimeSunOpen('sun','{{ Carbon\Carbon::parse($salon->sunday['open'])->format('h:i A')}}','{{ Carbon\Carbon::parse($salon->sunday['close'])->format('h:i A')}}')" 
                                                                    class="form-control w-75 day-section-sunopen-emp" name="sunopen" id="open" placeholder="{{__('Opening Time')}}"
                                                                    {{$salon->sunday['open'] == NULL && $salon->sunday['close'] == NULL ? 'disabled':''}}
                                                                    {{$salon->sunday['open'] != NULL && $salon->sunday['close'] != NULL ? 'required':''}}
                                                                ?>
                                                            </div>
                                                            @error('sunopen')                                    
                                                                <div class="invalid-div">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <input type="text" value="{{$salon->sunday['open'] == NULL ? 'Day Off':old('sunclose',Carbon\Carbon::parse($emp->sunday['close'])->format('h:i A'))}}" 
                                                                    onclick="salonTimeSunClose('sun','{{ Carbon\Carbon::parse($salon->sunday['open'])->format('h:i A')}}','{{ Carbon\Carbon::parse($salon->sunday['close'])->format('h:i A')}}')" 
                                                                    class="form-control w-75 day-section-sunclose-emp" name="sunclose" id="close" placeholder="{{__('Closing Time')}}" 
                                                                    {{$salon->sunday['open'] == NULL && $salon->sunday['close'] == NULL ? 'disabled':''}} 
                                                                    {{$salon->sunday['open'] != NULL && $salon->sunday['close'] != NULL ? 'required':''}}
                                                                />
                                                            </div>
                                                            @error('sunclose')                                    
                                                                <div class="invalid-div">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                    
                                                {{-- Monday --}}
                                                <label for="phone" class="form-control-label">{{__('Monday')}}</label>
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <input type="text" value="{{$salon->monday['open'] == NULL ? 'Day Off':old('monopen',Carbon\Carbon::parse($emp->monday['open'])->format('h:i A'))}}" 
                                                                    onclick="salonTimeMonOpen('mon','{{ Carbon\Carbon::parse($salon->monday['open'])->format('h:i A')}}','{{ Carbon\Carbon::parse($salon->monday['close'])->format('h:i A')}}')" 
                                                                    class="form-control w-75 day-section-monopen-emp" name="monopen" id="open" 
                                                                    placeholder="{{__('Opening Time')}}" {{$salon->monday['open'] == NULL && $salon->monday['close'] == NULL ? 'disabled':''}} 
                                                                    {{$salon->monday['open'] != NULL && $salon->monday['close'] != NULL ? 'required':''}}
                                                                />
                                                            </div>
                                                            @error('monopen')                                    
                                                                <div class="invalid-div">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <input type="text" value="{{$salon->monday['close'] == NULL ? 'Day Off':old('monclose',Carbon\Carbon::parse($emp->monday['close'])->format('h:i A'))}}" 
                                                                    onclick="salonTimeMonClose('mon','{{ Carbon\Carbon::parse($salon->monday['open'])->format('h:i A')}}','{{ Carbon\Carbon::parse($salon->monday['close'])->format('h:i A')}}')"
                                                                    class="form-control w-75 day-section-monclose-emp" name="monclose" id="close"
                                                                    placeholder="{{__('Closing Time')}}" {{$salon->monday['close'] == NULL && $salon->monday['close'] == NULL ? 'disabled':''}}
                                                                    {{$salon->monday['open'] != NULL && $salon->monday['close'] != NULL ? 'required':''}}
                                                                />
                                                            </div>
                                                            @error('monclose')                                    
                                                                <div class="invalid-div">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            

                                                {{-- Tuesday --}}
                                                <label for="phone" class="form-control-label">{{__('Tuesday')}}</label>
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <input type="text" value="{{$salon->tuesday['open'] == NULL ? 'Day Off':old('tueopen',Carbon\Carbon::parse($emp->tuesday['open'])->format('h:i A'))}}"
                                                                    onclick="salonTimeTueOpen('tue','{{ Carbon\Carbon::parse($salon->tuesday['open'])->format('h:i A')}}','{{ Carbon\Carbon::parse($salon->tuesday['close'])->format('h:i A')}}')" 
                                                                    class="form-control w-75  day-section-tueopen-emp" name="tueopen" id="open" 
                                                                    placeholder="{{__('Opening Time')}}" {{$salon->tuesday['open'] == NULL && $salon->tuesday['close'] == NULL ? 'disabled':''}} 
                                                                    {{$salon->tuesday['open'] != NULL && $salon->tuesday['close'] != NULL ? 'required':''}}
                                                                />
                                                            </div>
                                                            @error('tueopen')                                    
                                                                <div class="invalid-div">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <input type="text" value="{{$salon->tuesday['close'] == NULL ? 'Day Off':old('tueclose',Carbon\Carbon::parse($emp->tuesday['close']))->format('h:i A')}}"
                                                                    onclick="salonTimeTueClose('tue','{{ Carbon\Carbon::parse($salon->tuesday['open'])->format('h:i A')}}','{{ Carbon\Carbon::parse($salon->tuesday['close'])->format('h:i A')}}')" 
                                                                    class="form-control w-75 day-section-tueclose-emp" name="tueclose" id="close" 
                                                                    placeholder="{{__('Closing Time')}}" {{$salon->tuesday['open'] == NULL && $salon->tuesday['close'] == NULL ? 'disabled':''}} 
                                                                    {{$salon->tuesday['open'] != NULL && $salon->tuesday['close'] != NULL ? 'required':''}}
                                                                />
                                                            </div>
                                                            @error('tueclose')                                    
                                                                <div class="invalid-div">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Wednesday --}}
                                                <label for="phone" class="form-control-label">{{__('Wednesday')}}</label>
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <input type="text" value="{{$salon->wednesday['open'] == NULL ? 'Day Off':old('wedopen',Carbon\Carbon::parse($emp->wednesday['open'])->format('h:i A'))}}"
                                                                    onclick="salonTimeWedOpen('wed','{{ Carbon\Carbon::parse($salon->wednesday['open'])->format('h:i A')}}','{{ Carbon\Carbon::parse($salon->wednesday['close'])->format('h:i A')}}')" 
                                                                    class="form-control w-75 day-section-wedopen-emp" name="wedopen" id="open" placeholder="{{__('Opening Time')}}" 
                                                                    {{$salon->wednesday['open'] == NULL && $salon->wednesday['close'] == NULL ? 'disabled':''}} 
                                                                    {{$salon->wednesday['open'] != NULL && $salon->wednesday['close'] != NULL ? 'required':''}}
                                                                />
                                                            </div>
                                                            @error('wedopen')                                    
                                                                <div class="invalid-div">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <input type="text" value="{{$salon->wednesday['close'] == NULL ? 'Day Off':old('wedclose',Carbon\Carbon::parse($emp->wednesday['close'])->format('h:i A'))}}" 
                                                                    onclick="salonTimeWedClose('wed','{{ Carbon\Carbon::parse($salon->wednesday['open'])->format('h:i A')}}','{{ Carbon\Carbon::parse($salon->wednesday['close'])->format('h:i A')}}')" 
                                                                    class="form-control w-75 day-section-wedclose-emp" name="wedclose" id="close" placeholder="{{__('Closing Time')}}" 
                                                                    {{$salon->wednesday['open'] == NULL && $salon->wednesday['close'] == NULL ? 'disabled':''}} 
                                                                    {{$salon->wednesday['open'] != NULL && $salon->wednesday['close'] != NULL ? 'required':''}}
                                                                />
                                                            </div>
                                                            @error('wedclose')                                    
                                                                <div class="invalid-div">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                    
                                                {{-- Thursday --}}
                                                <label for="phone" class="form-control-label">{{__('Thursday')}}</label>
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <input type="text" value="{{$salon->thursday['open'] == NULL ? 'Day Off':old('thuopen',Carbon\Carbon::parse($emp->thursday['open'])->format('h:i A'))}}" 
                                                                    onclick="salonTimeThuOpen('thu','{{ Carbon\Carbon::parse($salon->thursday['open'])->format('h:i A')}}','{{ Carbon\Carbon::parse($salon->thursday['close'])->format('h:i A')}}')" 
                                                                    class="form-control w-75 day-section-thuopen-emp" name="thuopen" id="open" placeholder="{{__('Opening Time')}}" 
                                                                    {{$salon->thursday['open'] == NULL && $salon->thursday['close'] == NULL ? 'disabled':''}} 
                                                                    {{$salon->thursday['open'] != NULL && $salon->thursday['close'] != NULL ? 'required':''}}
                                                                />
                                                            </div>
                                                            @error('thuopen')                                    
                                                                <div class="invalid-div">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <input type="text" value="{{$salon->thursday['close'] == NULL ? 'Day Off':old('thuclose',Carbon\Carbon::parse($emp->thursday['close'])->format('h:i A'))}}" 
                                                                    onclick="salonTimeThuClose('thu','{{ Carbon\Carbon::parse($salon->thursday['open'])->format('h:i A')}}','{{ Carbon\Carbon::parse($salon->thursday['close'])->format('h:i A')}}')" 
                                                                    class="form-control w-75 day-section-thuclose-emp" name="thuclose" id="close" placeholder="{{__('Closing Time')}}" 
                                                                    {{$salon->thursday['open'] == NULL && $salon->thursday['close'] == NULL ? 'disabled':''}} 
                                                                    {{$salon->thursday['open'] != NULL && $salon->thursday['close'] != NULL ? 'required':''}}
                                                                />
                                                            </div>
                                                            @error('thuclose')                                    
                                                                <div class="invalid-div">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                    
                                                
                                                {{-- Friday --}}
                                                <label for="phone" class="form-control-label">{{__('Friday')}}</label>
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <input type="text" value="{{$salon->friday['open'] == NULL ? 'Day Off':old('friopen',Carbon\Carbon::parse($emp->friday['open'])->format('h:i A'))}}" 
                                                                    onclick="salonTimeFriOpen('fri','{{ Carbon\Carbon::parse($salon->friday['open'])->format('h:i A')}}','{{ Carbon\Carbon::parse($salon->friday['close'])->format('h:i A')}}')" 
                                                                    class="form-control w-75 day-section-friopen-emp" name="friopen" id="open" placeholder="{{__('Opening Time')}}" 
                                                                    {{$salon->friday['open'] == NULL && $salon->friday['close'] == NULL ? 'disabled':''}} 
                                                                    {{$salon->friday['open'] != NULL && $salon->friday['close'] != NULL ? 'required':''}}
                                                                />
                                                            </div>
                                                            @error('friopen')                                    
                                                                <div class="invalid-div">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <input type="text" value="{{$salon->friday['close'] == NULL ? 'Day Off':old('friclose',Carbon\Carbon::parse($emp->friday['close'])->format('h:i A'))}}"
                                                                    onclick="salonTimeFriClose('fri','{{ Carbon\Carbon::parse($salon->friday['open'])->format('h:i A')}}','{{ Carbon\Carbon::parse($salon->friday['close'])->format('h:i A')}}')" 
                                                                    class="form-control w-75 day-section-friclose-emp" name="friclose" id="close" placeholder="{{__('Closing Time')}}" 
                                                                    {{$salon->friday['open'] == NULL && $salon->friday['close'] == NULL ? 'disabled':''}} 
                                                                    {{$salon->friday['open'] != NULL && $salon->friday['close'] != NULL ? 'required':''}}
                                                                />
                                                            </div>
                                                            @error('friclose')                                    
                                                                <div class="invalid-div">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                    
                                                
                                                {{-- Saturday --}}
                                                <label for="phone" class="form-control-label">{{__('Saturday')}}</label>
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <input type="text" value="{{$salon->saturday['open'] == NULL ? 'Day Off':old('satopen',Carbon\Carbon::parse($emp->saturday['open'])->format('h:i A'))}}" 
                                                                    onclick="salonTimeSatOpen('sat','{{ Carbon\Carbon::parse($salon->saturday['open'])->format('h:i A')}}','{{ Carbon\Carbon::parse($salon->saturday['close'])->format('h:i A')}}')" 
                                                                    class="form-control w-75 day-section-satopen-emp" name="satopen" id="open" placeholder="{{__('Opening Time')}}"  
                                                                    {{$salon->saturday['open'] == NULL && $salon->saturday['close'] == NULL ? 'disabled':''}} 
                                                                    {{$salon->saturday['open'] != NULL && $salon->saturday['close'] != NULL ? 'required':''}}
                                                                />
                                                            </div>
                                                            @error('satopen')                                    
                                                                <div class="invalid-div">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <input type="text" value="{{$salon->saturday['close'] == NULL ? 'Day Off':old('satclose',Carbon\Carbon::parse($emp->saturday['close'])->format('h:i A'))}}" 
                                                                    onclick="salonTimeSatClose('sat','{{ Carbon\Carbon::parse($salon->saturday['open'])->format('h:i A')}}','{{ Carbon\Carbon::parse($salon->saturday['close'])->format('h:i A')}}')" 
                                                                    class="form-control w-75 day-section-satclose-emp" name="satclose" id="close" placeholder="{{__('Closing Time')}}" 
                                                                    {{$salon->saturday['open'] == NULL && $salon->saturday['close'] == NULL ? 'disabled':''}} 
                                                                    {{$salon->saturday['open'] != NULL && $salon->saturday['close'] != NULL ? 'required':''}}
                                                                />
                                                            </div>
                                                            @error('satclose')                                    
                                                                <div class="invalid-div">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="border-top">
                                            <div class="card-body text-center  rtl-float-none">
                                                <input type="submit" class="btn btn-primary  rtl-float-none" value="{{__('Save Changes')}}">
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
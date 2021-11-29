@extends('layouts.app')
@section('content')

@include('layouts.top-header', [
    'title' => __('Create') ,
    'headerData' => __('Employee') ,
    'url' => 'owner/employee' ,
    'class' => 'col-lg-7'
])

<div class="container-fluid mt--5">
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header border-0 text-center">
                    <span class="h3">{{__('Add Employee')}}</span>
                </div>
                <div class="mx-4 ">
                    <div class="nav-wrapper">
                        <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true"><i class="ni ni-single-02 mr-2"></i>{{__('Employee')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false"><i class="ni ni-time-alarm mr-2"></i>{{__('Timing')}}</a>
                            </li>
                        </ul>
                    </div>
                    <form class="form-horizontal form" action="{{url('/owner/employee')}}" method="post" enctype="multipart/form-data">
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
                                                    <input type="file" id="image" name="image" accept="image/*" onchange="loadFile(event)" ><br>
                                                    <img id="output" class="h-25 w-25 mt-3"/>
                                                    @error('image')                                    
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>
                        
                                                {{-- name --}}
                                                <div class="form-group">
                                                    <label class="form-control-label" for="name">{{__('Name')}}</label>
                                                    <input type="text" value="{{old('name')}}" name="name" id="name" class="form-control" placeholder="{{__('Employee Name')}}"  autofocus>
                                                    @error('name')                                    
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>
                        
                                                {{-- email --}}
                                                <div class="form-group">
                                                    <label for="email" class="form-control-label">{{__('Email')}} </label>
                                                    <input type="text" value="{{old('email')}}" class="form-control" name="email" id="email" placeholder="{{__('Employee Email')}}" autocomplete="email">
                                                    @error('email')                                    
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                {{-- Password --}}
                                                <div class="form-group">
                                                    <label for="password" class="form-control-label">{{__('Password')}} </label>
                                                    <input type="password"  class="form-control" name="password" id="password" placeholder="{{__('Employee Password')}}" autocomplete="current-password">
                                                    @error('password')                                    
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>
                        
                                                {{-- Services --}}
                                                <div class="form-group">
                                                    <label class="form-control-label">{{__('Services')}}</label>
                                                    <select class="form-control select2"  dir="{{ session()->has('direction')&& session('direction') == 'rtl'? 'rtl':''}}" multiple="multiple" name="services[]" id="services" data-placeholder='{{ __("-- Select Service --")}}' placeholder='{{ __("-- Select Service --")}}' >
                                                        @foreach ($services as $service)
                                                            <option  value="{{$service->service_id}}" {{ (collect(old('services'))->contains($service->service_id)) ? 'selected':'' }}>{{$service->name}}</option>
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
                                                            <input type="radio" id="salon" name="give_service" value="Salon" class="custom-control-input">
                                                            <label class="custom-control-label" for="salon">{{__('Salon')}}</label>
                                                        </div>
                                                        <div class="custom-control custom-radio mb-2">
                                                            <input type="radio" id="home" name="give_service" value="Home" class="custom-control-input">
                                                            <label class="custom-control-label" for="home">{{__('Home')}}</label>
                                                        </div>
                                                        <div class="custom-control custom-radio mb-2">
                                                            <input type="radio" id="both" name="give_service" value="Both" class="custom-control-input" checked>
                                                            <label class="custom-control-label" for="both">{{__('Both')}}</label>
                                                        </div>
                                                    </div>
                                                @endif
                        
                                                {{-- Phone no --}}
                                                <div class="form-group">
                                                    <label for="phone" class="form-control-label">{{__('Phone no')}}</label>
                                                    <input type="text" value="{{old('phone')}}" class="form-control" name="phone" id="phone" placeholder="{{__('Phone no')}}" >
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
                                                                <input type="text" value="{{$salon->sunday['open'] == NULL ? 'Day Off':old('sunopen',Carbon\Carbon::parse($salon->sunday['open'])->format('h:i A'))}}"
                                                                    onclick="salonTimeSunOpen('sun','{{ Carbon\Carbon::parse($salon->sunday['open'])->format('h:i A')}}','{{ Carbon\Carbon::parse($salon->sunday['close'])->format('h:i A')}}')" 
                                                                    class="form-control w-75 day-section-sunopen-emp" name="sunopen"
                                                                    {{$salon->sunday['open'] == NULL && $salon->sunday['close'] == NULL ? 'disabled':''}} 
                                                                    {{$salon->sunday['open'] != NULL && $salon->sunday['close'] != NULL ? 'required':''}}
                                                                 />
                                                            </div>
                                                            @error('sunopen')                                    
                                                                <div class="invalid-div">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <input type="text" value="{{$salon->sunday['close'] == NULL ? 'Day Off':old('sunclose',Carbon\Carbon::parse($salon->sunday['close'])->format('h:i A'))}}" 
                                                                onclick="salonTimeSunClose('sun','{{ Carbon\Carbon::parse($salon->sunday['open'])->format('h:i A')}}','{{ Carbon\Carbon::parse($salon->sunday['close'])->format('h:i A')}}')" 
                                                                    class="form-control w-75 day-section-sunclose-emp" name="sunclose"
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
                                                                <input type="text" value="{{$salon->monday['open'] == NULL ? 'Day Off':old('monopen',Carbon\Carbon::parse($salon->monday['open'])->format('h:i A'))}}" 
                                                                    onclick="salonTimeMonOpen('mon','{{ Carbon\Carbon::parse($salon->monday['open'])->format('h:i A')}}','{{ Carbon\Carbon::parse($salon->monday['close'])->format('h:i A')}}')" 
                                                                    class="form-control w-75 day-section-monopen-emp" name="monopen" placeholder="{{__('Opening Time')}}" 
                                                                    {{$salon->monday['open'] == NULL && $salon->monday['close'] == NULL ? 'disabled':''}} 
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
                                                                <input type="text" value="{{$salon->monday['close'] == NULL ? 'Day Off':old('monclose',Carbon\Carbon::parse($salon->monday['close'])->format('h:i A'))}}" 
                                                                onclick="salonTimeMonClose('mon','{{ Carbon\Carbon::parse($salon->monday['open'])->format('h:i A')}}','{{ Carbon\Carbon::parse($salon->monday['close'])->format('h:i A')}}')" 
                                                                    class="form-control w-75 day-section-monclose-emp" name="monclose" placeholder="{{__('Closing Time')}}" 
                                                                    {{$salon->monday['open'] == NULL && $salon->monday['close'] == NULL ? 'disabled':''}} 
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
                                                                <input type="text" value="{{$salon->tuesday['open'] == NULL ? 'Day Off':old('tueopen',Carbon\Carbon::parse($salon->tuesday['open'])->format('h:i A'))}}" 
                                                                onclick="salonTimeTueOpen('tue','{{ Carbon\Carbon::parse($salon->tuesday['open'])->format('h:i A')}}','{{ Carbon\Carbon::parse($salon->tuesday['close'])->format('h:i A')}}')" 
                                                                    class="form-control w-75 day-section-tueopen-emp" name="tueopen" placeholder="{{__('Opening Time')}}" 
                                                                    {{$salon->tuesday['open'] == NULL && $salon->tuesday['close'] == NULL ? 'disabled':''}} 
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
                                                                <input type="text" value="{{$salon->tuesday['close'] == NULL ? 'Day Off':old('tueclose',Carbon\Carbon::parse($salon->tuesday['close'])->format('h:i A'))}}" 
                                                                onclick="salonTimeTueClose('tue','{{ Carbon\Carbon::parse($salon->tuesday['open'])->format('h:i A')}}','{{ Carbon\Carbon::parse($salon->tuesday['close'])->format('h:i A')}}')" 
                                                                    class="form-control w-75 day-section-tueclose-emp" name="tueclose" placeholder="{{__('Closing Time')}}" 
                                                                    {{$salon->tuesday['open'] == NULL && $salon->tuesday['close'] == NULL ? 'disabled':''}} 
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
                                                                <input type="text" value="{{$salon->wednesday['open'] == NULL ? 'Day Off':old('wedopen',Carbon\Carbon::parse($salon->wednesday['open'])->format('h:i A'))}}" 
                                                                    onclick="salonTimeWedOpen('wed','{{ Carbon\Carbon::parse($salon->wednesday['open'])->format('h:i A')}}','{{ Carbon\Carbon::parse($salon->wednesday['close'])->format('h:i A')}}')" 
                                                                    class="form-control w-75 day-section-wedopen-emp" name="wedopen" placeholder="{{__('Opening Time')}}" 
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
                                                                <input type="text" value="{{$salon->wednesday['close'] == NULL ? 'Day Off':old('wedclose',Carbon\Carbon::parse($salon->wednesday['close'])->format('h:i A'))}}"
                                                                onclick="salonTimeWedClose('wed','{{ Carbon\Carbon::parse($salon->wednesday['open'])->format('h:i A')}}','{{ Carbon\Carbon::parse($salon->wednesday['close'])->format('h:i A')}}')" 
                                                                    class="form-control w-75 day-section-wedclose-emp" name="wedclose" placeholder="{{__('Closing Time')}}" 
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
                                                                <input type="text" value="{{$salon->thursday['open'] == NULL ? 'Day Off':old('thuopen',Carbon\Carbon::parse($salon->thursday['open'])->format('h:i A'))}}" 
                                                                onclick="salonTimeThuOpen('thu','{{ Carbon\Carbon::parse($salon->thursday['open'])->format('h:i A')}}','{{ Carbon\Carbon::parse($salon->thursday['close'])->format('h:i A')}}')" 
                                                                    class="form-control w-75 day-section-thuopen-emp" name="thuopen"  placeholder="{{__('Opening Time')}}" 
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
                                                                <input type="text" value="{{$salon->thursday['close'] == NULL ? 'Day Off':old('thuclose',Carbon\Carbon::parse($salon->thursday['close'])->format('h:i A'))}}" 
                                                                onclick="salonTimeThuClose('thu','{{ Carbon\Carbon::parse($salon->thursday['open'])->format('h:i A')}}','{{ Carbon\Carbon::parse($salon->thursday['close'])->format('h:i A')}}')" 
                                                                    class="form-control w-75 day-section-thuclose-emp" name="thuclose" placeholder="{{__('Closing Time')}}" 
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
                                                                <input type="text" value="{{$salon->friday['open'] == NULL ? 'Day Off':old('friopen',Carbon\Carbon::parse($salon->friday['open'])->format('h:i A'))}}" 
                                                                    onclick="salonTimeFriOpen('fri','{{ Carbon\Carbon::parse($salon->friday['open'])->format('h:i A')}}','{{ Carbon\Carbon::parse($salon->friday['close'])->format('h:i A')}}')" 
                                                                    class="form-control w-75 day-section-friopen-emp" name="friopen" placeholder="{{__('Opening Time')}}" 
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
                                                                <input type="text" value="{{$salon->friday['close'] == NULL ? 'Day Off':old('friclose',Carbon\Carbon::parse($salon->friday['close'])->format('h:i A'))}}" 
                                                                onclick="salonTimeFriClose('fri','{{ Carbon\Carbon::parse($salon->friday['open'])->format('h:i A')}}','{{ Carbon\Carbon::parse($salon->friday['close'])->format('h:i A')}}')" 
                                                                    class="form-control w-75 day-section-friclose-emp" name="friclose" placeholder="{{__('Closing Time')}}" 
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
                                                                <input type="text" value="{{$salon->saturday['open'] == NULL ? 'Day Off':old('satopen',Carbon\Carbon::parse($salon->saturday['open'])->format('h:i A'))}}" 
                                                                    onclick="salonTimeSatOpen('sat','{{ Carbon\Carbon::parse($salon->saturday['open'])->format('h:i A')}}','{{ Carbon\Carbon::parse($salon->saturday['close'])->format('h:i A')}}')" 
                                                                    class="form-control w-75 day-section-satopen-emp" name="satopen" placeholder="{{__('Opening Time')}}" 
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
                                                                <input type="text" value="{{$salon->saturday['close'] == NULL ? 'Day Off':old('satclose',Carbon\Carbon::parse($salon->saturday['close'])->format('h:i A'))}}" 
                                                                    onclick="salonTimeSatClose('sat','{{ Carbon\Carbon::parse($salon->saturday['open'])->format('h:i A')}}','{{ Carbon\Carbon::parse($salon->saturday['close'])->format('h:i A')}}')" 
                                                                    class="form-control w-75 day-section-satclose-emp" name="satclose" placeholder="{{__('Closing Time')}}" 
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
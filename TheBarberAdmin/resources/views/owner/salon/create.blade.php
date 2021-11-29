<!DOCTYPE html>
<html lang="en">

<head>
    <!-- title -->
    <?php $app_name = \App\AdminSetting::find(1)->app_name; ?>
    <title> {{$app_name}} </title>
    
    <!-- Favicon -->
    <?php $favicon = \App\AdminSetting::find(1)->favicon; ?>
    <link href="{{asset('storage/images/app/'.$favicon)}}" rel="icon" type="image/png">

    <?php $color = \App\AdminSetting::find(1)->color; ?>
    <style>
        :root{
            --primary_color : <?php echo $color ?>;
            --primary_color_hover : <?php echo $color.'cc' ?>;
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="{{ asset('includes/css/bootstrap-wysihtml5.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.21/b-1.6.2/b-flash-1.6.2/b-html5-1.6.2/b-print-1.6.2/datatables.min.css" />
    <link href="{{ asset('includes/css/nucleo.css')}}" rel="stylesheet">

    <link href="{{ asset('includes/css/jquery.timepicker.css')}}" rel="stylesheet">
    <link href="{{ asset('includes/css/argon.css')}}" rel="stylesheet">
    <link href="{{ asset('includes/css/mystyle.css')}}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

</head>

<body class="login">

    <section class="main-area">
        <div class="container-fluid">
            <div class="row h100">
                <?php $bg_img = \App\AdminSetting::find(1)->bg_img; ?>
                <div class="col-md-6 p-0 m-none" style="background: url({{asset('storage/images/app/'.$bg_img)}}) center center;background-size: cover;background-repeat: no-repeat;">
                    <span class="mask bg-gradient-dark opacity-6"></span>
                </div>

                <div class="col-md-6 p-0">
                    <div class="card bg-secondary border-0 mb-0">
                        <div class="card-header bg-transparent pb-5">
                            <h1 class="text-center">{{__('Add Your Salon')}}</h1>
                            <div class="mx-4">
                                <div class="nav-wrapper">
                                    <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true"><i class="ni ni-scissors mr-2"></i>{{__('Salon')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false"><i class="ni ni-time-alarm mr-2"></i>{{__('Timing')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-3-tab" data-toggle="tab" href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false"><i class="ni ni-square-pin mr-2"></i>{{__('Location')}}</a>
                                        </li>
                                    </ul>
                                </div>
                                <form class="form-horizontal form" action="{{url('/owner/salons/store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                    <div class="card shadow mx-auto">
                                        <div class="card-body">
                                            <div class="tab-content" id="myTabContent">
                                                <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                                                    <div class="p-20">

                                                        {{-- Image --}}
                                                        <div class="form-group">
                                                            <label class="form-control-label" for="image">{{__('Image')}}</label><br>
                                                            <input type="file"  value="{{old('image')}}" id="image" name="image" accept="image/*" onchange="loadFile(event)" ><br>
                                                            <img id="output" class="uploadsalonimg mt-3"/>
                                                            @error('image')                                    
                                                                <div class="invalid-div">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        
                                                        {{-- Logo --}}
                                                        <div class="form-group">
                                                            <label class="form-control-label">{{__('Logo')}} </label><br>
                                                            <input type="file" name="logo" id="logo" accept="image/*" onchange="loadFile1(event)"><br>
                                                            <img  id="black_logo_output" class="mt-2 logo_size_salon">
                                                            @error('logo')                                    
                                                                <div class="invalid-div">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                
                                                        {{-- name --}}
                                                        <div class="form-group">
                                                            <label class="form-control-label" for="name">{{__('Name')}}</label>
                                                            <input type="text" value="{{old('name')}}" name="name" id="name" class="form-control" placeholder="{{__('Salon Name')}}"  autofocus>
                                                            @error('name')                                    
                                                                <div class="invalid-div">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                
                                                        {{-- desc --}}
                                                        <div class="form-group">
                                                            <label for="desc" class="form-control-label">{{__('Description')}}</label>
                                                            <textarea class="form-control" rows="6" id="desc" name="desc" placeholder="{{__('Description of salon')}}" >{{old('desc')}}</textarea>
                                                            @error('desc')                                    
                                                                <div class="invalid-div">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                            
                                                        <div class="row">
                                                            {{-- Gender --}}
                                                            <div class="form-group col-6">
                                                                <label class="form-control-label">{{__('Salon for')}}</label><br>
                                                                <div class="custom-control custom-radio mb-2">
                                                                    <input type="radio" id="male" name="gender" value="Male" class="custom-control-input">
                                                                    <label class="custom-control-label" for="male">{{__('Male')}}</label>
                                                                </div>
                                                                <div class="custom-control custom-radio mb-2">
                                                                    <input type="radio" id="female" name="gender" value="Female" class="custom-control-input">
                                                                    <label class="custom-control-label" for="female">{{__('Female')}}</label>
                                                                </div>
                                                                <div class="custom-control custom-radio mb-2">
                                                                    <input type="radio" id="both" name="gender" value="Both" class="custom-control-input" checked>
                                                                    <label class="custom-control-label" for="both">{{__('Both')}}</label>
                                                                </div>
                                                            </div>
                                                                
                                                            {{-- Give Services --}}
                                                            <div class="form-group col-6 give_service_class">
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
                                                                    <input type="radio" id="both_service" name="give_service" value="Both" class="custom-control-input" checked>
                                                                    <label class="custom-control-label" for="both_service">{{__('Both')}}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        {{-- Extra charges --}}
                                                        <div class="form-group" id="home_charges_div">
                                                            <label for="home_charges" class="form-control-label">{{__('Extra charge for home services')}}</label>
                                                            <input type="number" value="{{old('home_charges',0)}}" min="0"  class="form-control" name="home_charges" id="home_charges" placeholder="{{__('Extra charge for home services')}}">
                                                            @error('home_charges')                                    
                                                                <div class="invalid-div">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        {{-- Website --}}
                                                        <div class="form-group">
                                                            <label for="website" class="form-control-label">{{__('Website Name')}}</label>
                                                            <input type="text" value="{{old('website')}}"  class="form-control" name="website" id="website" placeholder="{{__('Website name')}}">
                                                            @error('website')                                    
                                                                <div class="invalid-div">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        {{-- Phone no --}}
                                                        <div class="form-group">
                                                            <label for="phone" class="form-control-label">{{__('Phone no')}}</label>
                                                            <input type="text" value="{{old('phone')}}"  class="form-control" name="phone" id="phone" placeholder="{{__('Phone Number')}}" >
                                                            @error('phone')                                    
                                                                <div class="invalid-div">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                                                    <div class="p-20">
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col">
                                                                <div>{{__('Opening Time')}}</div>
                                                            </div>
                                                            <div class="col">
                                                                <div>{{__('Closing Time')}}</div>
                                                            </div>
                                                            <div class="col-1">
                                                                <div>{{__('Day Off')}}</div>
                                                            </div>
                                                        </div>
                                                        @php
                                                            $base_url = url('/');
                                                        @endphp

                                                        {{-- Sunday --}}

                                                        <label for="phone" class="form-control-label">{{__('Sunday')}}</label>
                                                        <div class="row align-items-center">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" value="{{old('sunopen', '08:00')}}" class="form-control day-section-sunopen" name="sunopen" id="open">
                                                                    </div>
                                                                    @error('sunopen')                                    
                                                                        <div class="invalid-div">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" value="{{old('sunclose', '20:00')}}" class="form-control day-section-sunclose" name="sunclose" id="close">
                                                                    </div>
                                                                    @error('sunclose')                                    
                                                                        <div class="invalid-div">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-1">
                                                                <div class="form-group">
                                                                    <div class="custom-control custom-checkbox input-group check_center">
                                                                        <input type="checkbox" class="custom-control-input salonCheck" name="sun" value="sun" id="sun_check">
                                                                        <label class="custom-control-label" for="sun_check"></label>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        {{-- Monday --}}
                                                        <label for="phone" class="form-control-label">{{__('Monday')}}</label>
                                                        <div class="row align-items-center">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" value="{{old('monopen','08:00')}}" class="form-control day-section-monopen" name="monopen" id="open">
                                                                    </div>
                                                                    @error('monopen')                                    
                                                                        <div class="invalid-div">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" value="{{old('monclose','20:00')}}" class="form-control day-section-monclose" name="monclose" id="close">
                                                                    </div>
                                                                    @error('monclose')                                    
                                                                        <div class="invalid-div">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-1">
                                                                <div class="form-group">
                                                                    <div class="custom-control custom-checkbox input-group check_center">
                                                                        <input type="checkbox" class="custom-control-input salonCheck" name="mon" value="mon" id="mon_check">
                                                                        <label class="custom-control-label" for="mon_check"></label>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        {{-- Tuesday --}}
                                                        <label for="phone" class="form-control-label">{{__('Tuesday')}}</label>
                                                        <div class="row align-items-center">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" value="{{old('tueopen', '08:00')}}" class="form-control day-section-tueopen" name="tueopen" id="open">
                                                                    </div>
                                                                    @error('tueopen')                                    
                                                                        <div class="invalid-div">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" value="{{old('tueclose', '20:00')}}" class="form-control day-section-tueclose" name="tueclose" id="close">
                                                                    </div>
                                                                    @error('tueclose')                                    
                                                                        <div class="invalid-div">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-1">
                                                                <div class="form-group">
                                                                    <div class="custom-control custom-checkbox input-group check_center">
                                                                        <input type="checkbox" class="custom-control-input salonCheck" name="tue" value="tue" id="tue_check">
                                                                        <label class="custom-control-label" for="tue_check"></label>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        {{-- Wednesday --}}
                                                        <label for="phone" class="form-control-label">{{__('Wednesday')}}</label>
                                                        <div class="row align-items-center">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" value="{{old('wedopen', '08:00')}}" class="form-control day-section-wedopen" name="wedopen" id="open">
                                                                    </div>
                                                                    @error('wedopen')                                    
                                                                        <div class="invalid-div">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" value="{{old('wedclose', '20:00')}}" class="form-control day-section-wedclose" name="wedclose" id="close">
                                                                    </div>
                                                                    @error('wedclose')                                    
                                                                        <div class="invalid-div">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-1">
                                                                <div class="form-group">
                                                                    <div class="custom-control custom-checkbox input-group check_center">
                                                                        <input type="checkbox" class="custom-control-input salonCheck" name="wed" value="wed" id="wed_check">
                                                                        <label class="custom-control-label" for="wed_check"></label>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        {{-- Thursday --}}
                                                        <label for="phone" class="form-control-label">{{__('Thursday')}}</label>
                                                        <div class="row align-items-center">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" value="{{old('thuopen', '08:00')}}" class="form-control day-section-thuopen" name="thuopen" id="open">
                                                                    </div>
                                                                    @error('thuopen')                                    
                                                                        <div class="invalid-div">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" value="{{old('thuclose', '20:00')}}" class="form-control day-section-thuclose" name="thuclose" id="close">
                                                                    </div>
                                                                    @error('thuclose')                                    
                                                                        <div class="invalid-div">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-1">
                                                                <div class="form-group">
                                                                    <div class="custom-control custom-checkbox input-group check_center">
                                                                        <input type="checkbox" class="custom-control-input salonCheck" name="thu" value="thu" id="thu_check">
                                                                        <label class="custom-control-label" for="thu_check"></label>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        {{-- Friday --}}
                                                        <label for="phone" class="form-control-label">{{__('Friday')}}</label>
                                                        <div class="row align-items-center">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" value="{{old('friopen', '08:00')}}" class="form-control day-section-friopen" name="friopen" id="open">
                                                                    </div>
                                                                    @error('friopen')                                    
                                                                        <div class="invalid-div">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" value="{{old('friclose','20:00')}}" class="form-control day-section-friclose" name="friclose" id="close">
                                                                    </div>
                                                                    @error('friclose')                                    
                                                                        <div class="invalid-div">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-1">
                                                                <div class="form-group">
                                                                    <div class="custom-control custom-checkbox input-group check_center">
                                                                        <input type="checkbox" class="custom-control-input salonCheck" name="fri" value="fri" id="fri_check">
                                                                        <label class="custom-control-label" for="fri_check"></label>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        {{-- Saturday --}}
                                                        <label for="phone" class="form-control-label">{{__('Saturday')}}</label>
                                                        <div class="row align-items-center">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" value="{{old('satopen', '08:00')}}" class="form-control day-section-satopen" name="satopen" id="open">
                                                                    </div>
                                                                    @error('satopen')                                    
                                                                        <div class="invalid-div">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" value="{{old('satclose', '20:00')}}" class="form-control day-section-satclose" name="satclose" id="close">
                                                                    </div>
                                                                    @error('satclose')                                    
                                                                        <div class="invalid-div">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-1">
                                                                <div class="form-group">
                                                                    <div class="custom-control custom-checkbox input-group check_center">
                                                                        <input type="checkbox" class="custom-control-input salonCheck" name="sat" value="sat" id="sat_check">
                                                                        <label class="custom-control-label" for="sat_check"></label>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="tab-pane fade" id="tabs-icons-text-3" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                                                    <div class="p-20">

                                                        {{-- Address --}}
                                                        <div class="form-group">
                                                            <label for="address" class="form-control-label">{{__('Address')}}</label>
                                                            <textarea class="form-control" rows="6" id="address" name="address" placeholder="{{__('Address of salon')}}">{{old('address')}}</textarea>
                                                            @error('address')                                    
                                                                <div class="invalid-div">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        
                                                        {{-- Zipcode --}}
                                                        <div class="form-group">
                                                            <label for="zipcode" class="form-control-label">{{__('Zipcode')}}</label>
                                                            <input type="number" value="{{old('zipcode')}}"  class="form-control" name="zipcode" id="zipcode" placeholder="{{__('Zipcode')}}" >
                                                            @error('zipcode')                                    
                                                                <div class="invalid-div">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                
                                                        {{-- City --}}
                                                        <div class="form-group">
                                                            <label for="city" class="form-control-label">{{__('City')}}</label>
                                                            <input type="text" value="{{old('city')}}"  class="form-control" name="city" id="city" placeholder="{{__('City')}}" >
                                                            @error('city')                                    
                                                                <div class="invalid-div">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                
                                                        {{-- State --}}
                                                        <div class="form-group">
                                                            <label for="state" class="form-control-label">{{__('State')}}</label>
                                                            <input type="text" value="{{old('state')}}"  class="form-control" name="state" id="state" placeholder="{{__('State')}}" >
                                                            @error('state')                                    
                                                                <div class="invalid-div">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                
                                                        {{-- Country --}}
                                                        <div class="form-group">
                                                            <label for="country" class="form-control-label">{{__('Country')}}</label>
                                                            <input type="text" value="{{old('country')}}"  class="form-control" name="country" id="country" placeholder="{{__('Country')}}" >
                                                            @error('country')                                    
                                                                <div class="invalid-div">{{ $message }}</div>
                                                            @enderror
                                                        </div>  
                                
                                                        {{-- Map --}}
                                                        <div class="form-group">
                                                            <div class="mapsize my-0 mx-auto mb-4" id="location_map"></div>
                                                        </div>
                                
                                                        {{-- Letitude --}}
                                                        <div class="form-group">
                                                            <label class="form-control-label">{{__('Latitude')}}</label>
                                                            <?php $lat = \App\AdminSetting::find(1)->lat; ?>
                                                            <input type="text" class="form-control" value="{{$lat}}" name="lat" id="lat"  readonly>
                                                        </div>
                                                        
                                                        {{-- Longitude --}}
                                                        <div class="form-group">
                                                            <label class="form-control-label">{{__('Longitude')}}</label>
                                                            <?php $lang = \App\AdminSetting::find(1)->lang; ?>
                                                            <input type="text" class="form-control" value="{{$lang}}" name="long" id="long"  readonly>
                                                        </div>
                                                        

                                                        <div class="border-top">
                                                            <div class="card-body text-center">
                                                                <input type="submit" class="btn btn-primary" value="{{__('Submit')}}">
                                                            </div>
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
        </div>
    </section>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="{{ asset('includes/js/wysihtml5-0.3.0.js') }}"></script>
        <script src="{{ asset('includes/js/bootstrap-wysihtml5.js') }}"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.21/b-1.6.2/b-flash-1.6.2/b-html5-1.6.2/b-print-1.6.2/datatables.min.js"> </script>

    <script src="{{ asset('includes/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('includes/js/argon.js') }}"></script>
    <script src="{{ asset('includes/js/jquery.timepicker.js') }}"></script>
    
    <?php $mapkey = \App\AdminSetting::find(1)->mapkey; ?>
    <script src="https://maps.googleapis.com/maps/api/js?key={{$mapkey}}" async defer></script>
    <script src="{{asset('includes/js/map.js')}}"></script> 
    
    <script src="{{ asset('includes/js/myjavascript.js')}}"></script>
</body>

</html>
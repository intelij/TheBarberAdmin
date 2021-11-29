<div class="container-fluid sidebar_open @if($errors->any()) show_sidebar_create @endif" id="add_appointment_sidebar">
    <div class="row">
        <div class="col">
            <div class="card py-3 border-0">
                <!-- Card header -->
                <div class="border_bottom_pink pb-3 pt-2 mb-4">
                    <span class="h3">{{__('Add Appointment')}}</span>
                    <button type="button" class="add_appointment close">&times;</button>
                </div>
                <form class="form-horizontal" id="create_appointment_form" method="post" enctype="multipart/form-data" action="{{url('/owner/booking/create')}}">
                    @csrf
                    <div class="my-0">

                        <?php
                            $id = rand(10000,99999);
                        ?>
                        
                        <div class="form-group">
                            <label class="form-control-label" for="booking_id">{{__('Booking id')}}</label>
                            <input type="text" name="booking_id" value="#{{$id}}" id="booking_id" class="form-control" placeholder="Booking id" readonly>
                        </div>
                        
                        
                        @if ($give_service == "Both")
                            {{-- Service At --}}
                            <div class="form-group">
                                <label class="form-control-label">{{__('Service At')}}</label>
                                <select class="form-control" name="booking_at" id="booking_at">
                                    <option value="Salon"> {{__('Salon')}} </option>
                                    <option value="Home" selected> {{__('Home')}} </option>
                                </select>
                                <div class="invalid-div"><span class="booking_at"></span></div>
                            </div>
                        @else
                            <input type="hidden" name="booking_at" value="{{$give_service}}" id="booking_at">
                        @endif

                        {{-- User --}}
                        <div class="form-group">
                            <label class="form-control-label">{{__('Client')}}</label>
                            <select class="form-control select2 users_class" name="user_id" id="services"  dir="{{ session()->has('direction')&& session('direction') == 'rtl'? 'rtl':''}}">
                                <option disabled selected value> {{__('-- Select Client --')}} </option>
                                @foreach ($users as $user)
                                    <option value={{$user->id}}>{{$user->name}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-div"><span class="user_id"></span></div>
                        </div>
                        
                        @if ($give_service == "Both" || $give_service == "Home")
                            {{-- Addresses --}}
                            <div class="form-group {{$give_service == "Salon" ? 'display-none' : ''}}" id="address_div">
                                <label class="form-control-label">{{__('Select Address')}}</label>
                                <div class="row">
                                    <div class="col-11">
                                        <select class="form-control select2 address_id" name="address_id" id="addresses"  dir="{{ session()->has('direction')&& session('direction') == 'rtl'? 'rtl':''}}">
                                            <option disabled selected value> {{__('-- Select Address --')}} </option>
                                        </select>
                                    </div>
                                    <div class="col-1 p-0">
                                        {{-- 1234 --}}
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addressModal"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Services --}}
                        <div class="form-group">
                            <label class="form-control-label">{{__('Services')}}</label>
                            <select class="form-control select2 service_class" multiple="multiple" name="service_id[]" id="select2" data-placeholder='{{ __("-- Select Service --")}}' placeholder='{{ __("-- Select Service --")}}'  dir="{{ session()->has('direction')&& session('direction') == 'rtl'? 'rtl':''}}">
                                @foreach ($services as $service)
                                    <option value={{$service->service_id}}>{{$service->name}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-div"><span class="service_id"></span></div>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label" for="date">{{__('Date')}}</label>
                            <input type="text" name="date"  id="date" class="form-control select_date" placeholder="{{__('-- Select Date --')}}">
                            <div class="invalid-div"><span class="date"></span></div>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label" for="start_time">{{__('Time')}}</label>
                            <select class="form-control select2 start_time" name="start_time" id="start_time"  dir="{{ session()->has('direction')&& session('direction') == 'rtl'? 'rtl':''}}">
                                <option disabled selected> {{__('-- Select Time --')}} </option>
                            </select>
                            <div class="invalid-div"><span class="start_time"></span></div>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label" for="payment">{{__('Payment')}}</label>
                            <input type="text" name="payment" id="payment" class="form-control" placeholder="{{__('Payment')}}">
                            <div class="invalid-div"><span class="payment"></span></div>
                        </div>

                        {{-- Employees --}}
                        <div class="form-group">
                            <label class="form-control-label">{{__('Employee')}}</label>
                            <select class="form-control select2 emp_id" name="emp_id" id="emp_id"  dir="{{ session()->has('direction')&& session('direction') == 'rtl'? 'rtl':''}}">
                                <option disabled selected> {{__('-- Select Employee --')}} </option>
                            </select>   
                            <div class="invalid-div"><span class="emp_id"></span></div>
                        </div>

                        <div class="text-center">
                            <button type="button" onclick="all_create('create_appointment_form','booking')" id="create_btn" class="btn btn-primary rtl-float-none mt-4 mb-5">{{ __('Book Appointment') }}</button>
                        </div>
                    </div>
                </form>
                
                <!-- Address Modal -->
                <div class="modal fade" id="addressModal" tabindex="-1" role="dialog" aria-labelledby="addressModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addressModalLabel"> {{__('Add Address')}} </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{url('/owner/users/address_add')}}" method="post" class="form">
                                @csrf
                                    {{-- User --}}
                                    <div class="form-group">
                                        <label class="form-control-label">{{__('Client')}}</label>
                                        <select class="form-control select2" name="user_name"  dir="{{ session()->has('direction')&& session('direction') == 'rtl'? 'rtl':''}}">
                                            <option disabled selected value> {{__('-- Select Client --')}} </option>
                                            @foreach ($users as $user)
                                                <option value={{$user->id}}>{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('user_name')
                                            <div class="invalid-div">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Street --}}
                                    <div class="form-group">
                                        <label class="form-control-label" for="street">{{__('Street')}}</label>
                                        <input type="text" name="street" id="street" class="form-control" placeholder="{{__('Street')}}">
                                        @error('street')                                    
                                            <div class="invalid-div">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    {{-- City --}}
                                    <div class="form-group">
                                        <label for="city" class="form-control-label">{{__('City')}}</label>
                                        <input type="text" class="form-control" value="{{old('city')}}" name="city" id="city" placeholder="{{__('City')}}" >
                                        @error('city')                                    
                                            <div class="invalid-div">{{ $message }}</div>
                                        @enderror
                                    </div>
                
                                    {{-- State --}}
                                    <div class="form-group">
                                        <label for="state" class="form-control-label">{{__('State')}}</label>
                                        <input type="text" class="form-control" value="{{old('state')}}" name="state" id="state" placeholder="{{__('State')}}" >
                                        @error('state')                                    
                                            <div class="invalid-div">{{ $message }}</div>
                                        @enderror
                                    </div>
                
                                    {{-- Country --}}
                                    <div class="form-group">
                                        <label for="country" class="form-control-label">{{__('Country')}}</label>
                                        <input type="text" class="form-control" value="{{old('country')}}" name="country" id="country" placeholder="{{__('Country')}}">
                                        @error('country')                                    
                                            <div class="invalid-div">{{ $message }}</div>
                                        @enderror
                                    </div>  
                
                                    {{-- Map --}}
                                    <div class="form-group">
                                        <div class="mapsize_address my-0 mx-auto mb-4" id="location_map"></div>
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
                                                        
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                                        <button type="submit" class="btn btn-primary">{{__('Add')}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
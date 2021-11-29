@extends('layouts.app')
@section('content_setting')


@include('layouts.top-header', [
        'title' => __('Settings'),
        'class' => 'col-lg-7'
    ])

<div class="container-fluid mt--6 mb-5">
    <div class="row">
        <div class="col">
            <div class="card pb-6">
                <!-- Card header -->
                <div class="card-header border-0">
                    <span class="h3">{{__('Admin Settings')}}</span>
                    <?php $license_status = \App\AdminSetting::find(1)->license_status; ?>
                </div>
                    <div class="row mt-3">
                        <div class="col-3">
                            <div class="nav-wrapper settings">
                                <ul class="nav navbar-nav nav-pills setting nav-fill" id="tabs-icons-text" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link text-left {{ $license_status == 1 ? 'active': '' }}" id="tabs-icons-text-1-tab" data-toggle="tab" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true"><i class="fa fa-user mr-2"></i> {{__('OTP Verification')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-left" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false"><i class="fas fa-map-marker-alt mr-2"></i> {{__('Map')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-left" id="tabs-icons-text-3-tab" data-toggle="tab" href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false"><i class="fas fa-money-bill-alt mr-2"></i>{{__('Currency')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-left" id="tabs-icons-text-16-tab" data-toggle="tab" href="#tabs-icons-text-16" role="tab" aria-controls="tabs-icons-text-16" aria-selected="false"><i class="fas fa-language mr-2"></i>{{__('Language')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-left" id="tabs-icons-text-4-tab" data-toggle="tab" href="#tabs-icons-text-4" role="tab" aria-controls="tabs-icons-text-4" aria-selected="false"><i class="fa fa-bell mr-2"></i>{{__('Push Notification')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-left" id="tabs-icons-text-11-tab" data-toggle="tab" href="#tabs-icons-text-11" role="tab" aria-controls="tabs-icons-text-11" aria-selected="false"><i class="far fa-envelope mr-2"></i>{{__('Email Settings')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-left" id="tabs-icons-text-12-tab" data-toggle="tab" href="#tabs-icons-text-12" role="tab" aria-controls="tabs-icons-text-12" aria-selected="false"><i class="fas fa-sms mr-2"></i>{{__('SMS Gateway')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-left" id="tabs-icons-text-5-tab" data-toggle="tab" href="#tabs-icons-text-5" role="tab" aria-controls="tabs-icons-text-5" aria-selected="false"><i class="far fa-credit-card mr-2"></i>{{__('Payment Gateway')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-left" id="tabs-icons-text-6-tab" data-toggle="tab" href="#tabs-icons-text-6" role="tab" aria-controls="tabs-icons-text-6" aria-selected="false"><i class="fa fa-gavel mr-2"></i>{{__('Terms & Condition')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-left" id="tabs-icons-text-7-tab" data-toggle="tab" href="#tabs-icons-text-7" role="tab" aria-controls="tabs-icons-text-7" aria-selected="false"><i class="fa fa-lock mr-2"></i>{{__('Privacy Policy')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-left" id="tabs-icons-text-8-tab" data-toggle="tab" href="#tabs-icons-text-8" role="tab" aria-controls="tabs-icons-text-8" aria-selected="false"><i class="fa fa-percent mr-2"></i>{{__('Commission')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-left" id="tabs-icons-text-9-tab" data-toggle="tab" href="#tabs-icons-text-9" role="tab" aria-controls="tabs-icons-text-9" aria-selected="false"><i class="fa fa-cube mr-2"></i>{{__('App Settings')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-left" id="tabs-icons-text-15-tab" data-toggle="tab" href="#tabs-icons-text-15" role="tab" aria-controls="tabs-icons-text-15" aria-selected="false"><i class="fa fa-wrench mr-2"></i>{{__('Website Settings')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-left" id="tabs-icons-text-14-tab" data-toggle="tab" href="#tabs-icons-text-14" role="tab" aria-controls="tabs-icons-text-14" aria-selected="false"><i class="fa fa-share-alt mr-2"></i>{{__('App Sharing Settings')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-left" id="tabs-icons-text-10-tab" data-toggle="tab" href="#tabs-icons-text-10" role="tab" aria-controls="tabs-icons-text-10" aria-selected="false"><i class="fas fa-users-cog mr-2"></i>{{__('Admin Settings')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-left {{ $license_status == 0 ? 'active': '' }}" id="tabs-icons-text-13-tab" data-toggle="tab" href="#tabs-icons-text-13" role="tab" aria-controls="tabs-icons-text-13" aria-selected="true"><i class="fa fa-id-card mr-2"></i> {{__('License')}} </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-8">
                        @if($errors->any())
                            <div class="alert alert-danger" role="alert">
                                <strong>Error!</strong> {{$errors->first()}}
                            </div>
                        @endif
                        <form class="form-horizontal form" id="settingform" action="{{url('/admin/settings/update/'.$setting->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card shadow">
                                <div class="card-body">
                                    <div class="tab-content" id="myTabContent">
                                
                                        {{-- Tab 1 OTP Verification --}}
                                        <div class="tab-pane fade {{ $license_status == 1 ? 'active show': '' }}" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                                            <h4 class="card-title">{{__('OTP Verification')}}</h4>
                                            
                                            <div class="form-group row">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="user_verify">{{__('OTP Verification')}} </label>
                                                <div class="col-sm-9 mt-2">
                                                    
                                                    <label class="custom-toggle">
                                                        <input type="checkbox" id="user_verify" value="1" name="user_verify" <?php if($setting->user_verify == 1){ echo "checked"; } ?>>
                                                        <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                                    </label>
                                                    
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="user_verify_sms">{{__('SMS')}} </label>
                                                <div class="col-sm-9 mt-2">
                                                    
                                                    <label class="custom-toggle">
                                                        <input type="checkbox"id="user_verify_sms" value="1" name="user_verify_sms" <?php if($setting->sms == 0){ echo "disabled"; } ?> <?php if($setting->user_verify_sms == 1){ echo "checked"; } ?>>
                                                        <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                                    </label>
                                                    
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="user_verify_email">{{__('Email')}} </label>
                                                <div class="col-sm-9 mt-2">
                                                    
                                                    <label class="custom-toggle">
                                                        <input type="checkbox"id="user_verify_email" value="1" name="user_verify_email" <?php if($setting->mail == 0){ echo "disabled"; } ?> <?php if($setting->user_verify_email == 1){ echo "checked"; } ?>>
                                                        <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                                    </label>
                                                    
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Tab 2 Map --}}
                                        <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                                            <h4 class="card-title">{{__('Map')}}</h4>
                                            <div class="form-group row">
                                                <label class="col-sm-3 text-right control-label col-form-label">{{__('Map Key')}}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control w-75" value="{{old('mapkey', $setting->mapkey)}}" name="mapkey" id="mapkey" placeholder="{{__('Mapkey')}}">
                                                    @error('mapkey')                                    
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="radius">{{__('Radius')}}</label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control w-75" value="{{old('radius', $setting->radius)}}" name="radius" id="radius" placeholder="{{__('Radius')}}" >
                                                    @error('radius')                                    
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="form-group row">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="latitude">{{__('Latitude')}}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control w-75" value="{{old('latitude', $setting->lat)}}" name="latitude" id="latitude" placeholder="{{__('Latitude')}}" >
                                                    @error('latitude')                                    
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="form-group row">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="longitude">{{__('Longitude')}}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control w-75" value="{{old('longitude', $setting->lang)}}" name="longitude" id="longitude" placeholder="{{__('Longitude')}}" >
                                                    @error('longitude')                                    
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                        </div>

                                        {{-- Tab 3 Currency --}}
                                        <div class="tab-pane fade" id="tabs-icons-text-3" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                                            <h4 class="card-title">{{__('Currency')}}</h4>
                                            <div class="form-group row">
                                                <label class="col-sm-3 text-right control-label col-form-label">{{__('Select Currency')}}</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control select2" name="currency" id="currency" dir="{{ session()->has('direction')&& session('direction') == 'rtl'? 'rtl':''}}">
                                                        @foreach ($currency as $cur)
                                                            <option value="{{$cur->code}}" {{ (collect(old('currency'))->contains($cur->code)) ? 'selected':'' }} <?php if( $cur->code == $setting->currency){ echo "selected"; } ?>> {{$cur->country}} - {{$cur->currency}} ({{$cur->symbol}} - {{$cur->code}})</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        
                                        {{-- Tab 3 Language --}}
                                        <div class="tab-pane fade" id="tabs-icons-text-16" role="tabpanel" aria-labelledby="tabs-icons-text-16-tab">
                                            <h4 class="card-title">{{__('Language')}}</h4>
                                            <div class="form-group row">
                                                <label class="col-sm-3 text-right control-label col-form-label">{{__('Select Language')}}</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control select2" name="language" id="language" dir="{{ session()->has('direction')&& session('direction') == 'rtl'? 'rtl':''}}">
                                                        @foreach ($language as $lang)
                                                            <option value="{{$lang->name}}" {{ (collect(old('language'))->contains($lang->name)) ? 'selected':'' }} <?php if( $lang->name == $setting->language){ echo "selected"; } ?>> {{$lang->name}} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Tab 4 Notification --}}
                                        <div class="tab-pane fade" id="tabs-icons-text-4" role="tabpanel" aria-labelledby="tabs-icons-text-4-tab">
                                            <h4 class="card-title">{{__('Push Notification')}}</h4>
                                            <div class="form-group row my-3">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="notification">{{__('Notification')}}</label>
                                                <div class="col-sm-9 mt-2">
                                                    <label class="custom-toggle">
                                                        <input type="checkbox" id="notification" value="1" name="notification" <?php if($setting->notification == 1){ echo "checked"; } ?>>
                                                        <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                                    </label>
                                                </div>
                                            </div>

                                            <h6 class="heading-small text-muted text-center mb-4"> {{__('For User App')}} </h6>
                                            <div class="form-group row">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="app_id">{{__('App ID')}}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control w-75" value="{{old('app_id', $setting->app_id)}}" name="app_id" id="app_id" placeholder="{{__('App ID')}}">
                                                    @error('app_id')                                    
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="api_key">{{__('Api Key')}}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control w-75" value="{{old('api_key', $setting->api_key)}}" name="api_key" id="api_key" placeholder="{{__('Api Key')}}">
                                                    @error('api_key')                                    
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="auth_key">{{__('Auth Key')}}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control w-75" value="{{old('auth_key', $setting->auth_key)}}" name="auth_key" id="auth_key" placeholder="{{__('Auth Key')}}">
                                                    @error('auth_key')                                    
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="project_no">{{__('Project Number')}}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control w-75" value="{{old('project_no', $setting->project_no)}}" name="project_no" id="project_no" placeholder="{{__('Project Number')}}">
                                                    @error('project_no')                                    
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <h6 class="heading-small text-muted text-center mb-4"> {{__('For Owner App')}} </h6>
                                            <div class="form-group row">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="owner_app_id">{{__('App ID')}}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control w-75" value="{{old('owner_app_id', $setting->owner_app_id)}}" name="owner_app_id" id="owner_app_id" placeholder="{{__('App ID')}}">
                                                    @error('owner_app_id')                                    
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="owner_api_key">{{__('Api Key')}}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control w-75" value="{{old('owner_api_key', $setting->owner_api_key)}}" name="owner_api_key" id="owner_api_key" placeholder="{{__('Api Key')}}">
                                                    @error('owner_api_key')
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="owner_auth_key">{{__('Auth Key')}}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control w-75" value="{{old('owner_auth_key', $setting->owner_auth_key)}}" name="owner_auth_key" id="owner_auth_key" placeholder="{{__('Auth Key')}}">
                                                    @error('owner_auth_key')
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="owner_project_no">{{__('Project Number')}}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control w-75" value="{{old('owner_project_no', $setting->owner_project_no)}}" name="owner_project_no" id="owner_project_no" placeholder="{{__('Project Number')}}">
                                                    @error('owner_project_no')
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            
                                            
                                            <h6 class="heading-small text-muted text-center mb-4"> {{__('For Employee App')}} </h6>
                                            <div class="form-group row">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="employee_app_id">{{__('App ID')}}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control w-75" value="{{old('employee_app_id', $setting->employee_app_id)}}" name="employee_app_id" id="employee_app_id" placeholder="{{__('App ID')}}">
                                                    @error('employee_app_id')                                    
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="employee_api_key">{{__('Api Key')}}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control w-75" value="{{old('employee_api_key', $setting->employee_api_key)}}" name="employee_api_key" id="employee_api_key" placeholder="{{__('Api Key')}}">
                                                    @error('employee_api_key')                                    
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="employee_auth_key">{{__('Auth Key')}}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control w-75" value="{{old('employee_auth_key', $setting->employee_auth_key)}}" name="employee_auth_key" id="employee_auth_key" placeholder="{{__('Auth Key')}}">
                                                    @error('employee_auth_key')                                    
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="employee_project_no">{{__('Project Number')}}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control w-75" value="{{old('employee_project_no', $setting->employee_project_no)}}" name="employee_project_no" id="employee_project_no" placeholder="{{__('Project Number')}}">
                                                    @error('employee_project_no')                                    
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>
                                    
                                        {{-- Tab 11 Mail --}}
                                        <div class="tab-pane fade" id="tabs-icons-text-11" role="tabpanel" aria-labelledby="tabs-icons-text-11-tab">
                                            <h4 class="card-title">{{__('Email Settings')}}</h4>

                                            <div class="form-group row my-3">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="mail">{{__('Email')}}</label>
                                                <div class="col-sm-9 mt-2">
                                                    <label class="custom-toggle">
                                                        <input type="checkbox" id="mail" value="1" name="mail" <?php if($setting->mail == 1){ echo "checked"; } ?>>
                                                        <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                </div>
                                                <div class="col-sm-9">
                                                    <div class="form-group my-3">
                                                        <div class="custom-control custom-radio mb-3">
                                                            <input type="radio" id="smtp" value="smtp" name="mail_by" class="custom-control-input" <?php if($setting->mail_by == "smtp"){ echo "checked"; } ?>>
                                                            <label class="custom-control-label " for="smtp"> {{__('Mail using SMTP')}} </label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="mailgun" value="mailgun" name="mail_by" class="custom-control-input"  <?php if($setting->mail_by == "mailgun"){ echo "checked"; } ?>>
                                                            <label class="custom-control-label" for="mailgun"> {{__('Mail using Mailgun')}} </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <h6 class="heading-small text-muted text-center mb-4"> {{__('For SMPT')}} </h6>
                                            <div class="form-group row">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="mail_host">{{__('Mail Host')}} </label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control w-75" value="{{old('mail_host', $setting->mail_host)}}" name="mail_host" id="mail_host" placeholder="{{__('Mail Host')}}">
                                                    @error('mail_host')                                    
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="mail_port">{{__('Mail Port')}} </label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control w-75" value="{{old('mail_port', $setting->mail_port)}}" name="mail_port" id="mail_port" placeholder="{{__('Mail Port')}}">
                                                    @error('mail_port')                                    
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="form-group row">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="mail_username">{{__('Mail UserName')}} </label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control w-75" value="{{old('mail_username', $setting->mail_username)}}" name="mail_username" id="mail_username" placeholder="{{__('Mail UserName')}}">
                                                    @error('mail_username')                                    
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="form-group row">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="mail_password">{{__('Mail Password')}} </label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control w-75" value="{{old('mail_password', $setting->mail_password)}}" name="mail_password" id="mail_password" placeholder="{{__('Mail Password')}}">
                                                    @error('mail_password')                                    
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="form-group row">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="mail_encryption">{{__('Mail Encryption')}} </label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control w-75" value="{{old('mail_encryption', $setting->mail_encryption)}}" name="mail_encryption" id="mail_encryption" placeholder="{{__('Mail Encryption')}}">
                                                    @error('mail_encryption')                                    
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="form-group row">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="sender_email">{{__('Sender Email ID')}}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control w-75" value="{{old('sender_email', $setting->sender_email)}}" name="sender_email" id="sender_email" placeholder="{{__('Sender Email ID')}}">
                                                    @error('sender_email')                                    
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                             

                                            <h6 class="heading-small text-muted text-center mb-4"> {{__('For Mailgun')}} </h6>
                                            <div class="form-group row">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="mailgun_key">{{__('Mailgun Key')}}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control w-75" value="{{old('mailgun_key', $setting->mailgun_key)}}" name="mailgun_key" id="mailgun_key" placeholder="{{__('Mailgun Key')}}">
                                                    @error('mailgun_key')                                    
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                             
                                            <div class="form-group row">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="mailgun_domain">{{__('Mailgun Domain')}}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control w-75" value="{{old('mailgun_domain', $setting->mailgun_domain)}}" name="mailgun_domain" id="mailgun_domain" placeholder="{{__('Mailgun Domain')}}">
                                                    @error('mailgun_domain')                                    
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Tab 12 SMS --}}
                                        <div class="tab-pane fade" id="tabs-icons-text-12" role="tabpanel" aria-labelledby="tabs-icons-text-12-tab">
                                            <h4 class="card-title">{{__('SMS Gateway')}}</h4>

                                            <div class="form-group row my-3">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="sms">{{__('Enable SMS Notification')}}</label>
                                                <div class="col-sm-9 mt-2">
                                                    <label class="custom-toggle">
                                                        <input type="checkbox" id="sms" value="1" name="sms" <?php if($setting->sms == 1){ echo "checked"; } ?>>
                                                        <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="twilio_acc_id">{{__('Twilio Account ID')}} </label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control w-75" value="{{old('twilio_acc_id', $setting->twilio_acc_id)}}" name="twilio_acc_id" id="twilio_acc_id" placeholder="{{__('Twilio Account ID')}}">
                                                    @error('twilio_acc_id')                                    
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                           
                                            <div class="form-group row">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="twilio_auth_token">{{__('Twilio Auth Token')}} </label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control w-75" value="{{old('twilio_auth_token', $setting->twilio_auth_token)}}" name="twilio_auth_token" id="twilio_auth_token" placeholder="{{__('Twilio Auth Token')}}">
                                                    @error('twilio_auth_token')                                    
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                           
                                            <div class="form-group row">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="twilio_phone_no">{{__('Twilio Phone Number')}} </label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control w-75" value="{{old('twilio_phone_no', $setting->twilio_phone_no)}}" name="twilio_phone_no" id="twilio_phone_no" placeholder="{{__('Twilio Phone Number')}}">
                                                    @error('twilio_phone_no')                                    
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                           
                                        </div>


                                        {{-- Tab 5 Payment --}}
                                        <div class="tab-pane fade" id="tabs-icons-text-5" role="tabpanel" aria-labelledby="tabs-icons-text-5-tab">
                                            <h4 class="card-title">{{__('Payment Gateway')}}</h4>
                                            <div class="form-group row my-3">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="cod">COD {{__('(Cash On Delivery)')}}</label>
                                                <div class="col-sm-9 mt-2">
                                                    <label class="custom-toggle">
                                                        <input type="checkbox" id="cod" value="1" name="cod" <?php if($payment->cod == 1){ echo "checked"; } ?>>
                                                        <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            {{-- <div class="form-group row my-3">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="paypal">{{__('PayPal')}}</label>
                                                <div class="col-sm-9 mt-2">
                                                    <label class="custom-toggle">
                                                        <input type="checkbox" id="paypal" value="1" name="paypal" <?php if($payment->paypal == 1){ echo "checked"; } ?>>
                                                        <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                                    </label>
                                                </div>
                                            </div> --}}
                                           
                                            <div class="form-group row my-3">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="stripe">{{__('Stripe')}}</label>
                                                <div class="col-sm-9 mt-2">
                                                    <label class="custom-toggle">
                                                        <input type="checkbox" id="stripe" value="1" name="stripe" <?php if($payment->stripe == 1){ echo "checked"; } ?>>
                                                        <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            {{-- <div class="form-group row">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="paypal_sandbox_key">{{__('Paypal Sandbox Key')}}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control w-75" value="{{old('paypal_sandbox_key', $payment->paypal_sandbox_key)}}" name="paypal_sandbox_key" id="paypal_sandbox_key" placeholder="{{__('Paypal Sandbox Key')}}">
                                                    @error('paypal_sandbox_key')                                    
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="paypal_production_key">{{__('Paypal Production Key')}}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control w-75" value="{{old('paypal_production_key', $payment->paypal_production_key)}}" name="paypal_production_key" id="paypal_production_key" placeholder="{{__('Paypal Production Key')}}">
                                                    @error('paypal_production_key')                                    
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div> --}}
                                            
                                            <div class="form-group row">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="stripe_public_key">{{__('Stripe Public key')}}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control w-75" value="{{old('stripe_public_key', $payment->stripe_public_key)}}" name="stripe_public_key" id="stripe_public_key" placeholder="{{__('Stripe Public key')}}">
                                                    @error('stripe_public_key')                                    
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="stripe_secret_key">{{__('Stripe Secret key')}}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control w-75" value="{{old('stripe_secret_key', $payment->stripe_secret_key)}}" name="stripe_secret_key" id="stripe_secret_key" placeholder="{{__('Stripe Secret key')}}">
                                                    @error('stripe_secret_key')                                    
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                       
                                        {{-- Tab 6 Terms & Condition --}}
                                        <div class="tab-pane fade" id="tabs-icons-text-6" role="tabpanel" aria-labelledby="tabs-icons-text-6-tab">
                                            <h4 class="card-title">{{__('Terms & Condition')}}</h4>
                                            <textarea class="terms_conditions form-control" name="terms_conditions">{{$setting->terms_conditions}}</textarea>
                                        </div>

                                        {{-- Tab 7 Privacy Policy --}}
                                        <div class="tab-pane fade" id="tabs-icons-text-7" role="tabpanel" aria-labelledby="tabs-icons-text-7-tab">
                                            <h4 class="card-title">{{__('Privacy Policy')}}</h4>
                                            <textarea class="privacy_policy form-control" name="privacy_policy">{{$setting->privacy_policy}}</textarea>
                                        </div>

                                        {{-- Tab 8 Commission --}}
                                        <div class="tab-pane fade" id="tabs-icons-text-8" role="tabpanel" aria-labelledby="tabs-icons-text-8-tab">
                                            <h4 class="card-title">{{__('Commission')}}</h4>
                                            <div class="form-group row">
                                                <label class="col-sm-3 text-right control-label col-form-label">{{__('Type')}}</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control w-75" id="commission_type" name="commission_type">
                                                        <option value="Amount" <?php if( "Amount" == $setting->commission_type){ echo "selected"; } ?>>{{__('Amount')}}</option>
                                                        <option value="Percentage" <?php if( "Percentage" == $setting->commission_type){ echo "selected"; } ?>>{{__('Percentage')}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 text-right control-label col-form-label" for="commission_amount">{{__('Amount / Percentage')}}</label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control w-75" value="{{old('commission_amount', $setting->commission_amount)}}" name="commission_amount" id="commission_amount" placeholder="{{__('Amount / Percentage')}}" >
                                                    @error('commission_amount')                                    
                                                        <div class="invalid-div">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Tab 9 App --}}
                                        <div class="tab-pane fade" id="tabs-icons-text-9" role="tabpanel" aria-labelledby="tabs-icons-text-9-tab">
                                            <h4 class="card-title">{{__('App Settings')}}</h4>
                                            <div class="form-group">
                                                <label class="form-control-label" for="app_name">{{__('App Name')}}</label>
                                                <input type="text" name="app_name" value="{{old('app_name', $setting->app_name)}}" id="app_name" class="form-control" placeholder="{{__('Application Name')}}"  autofocus>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label" for="app_version">{{__('Version')}}</label>
                                                <input type="text" name="app_version" value="{{old('app_version', $setting->app_version)}}" id="app_version" class="form-control" placeholder="{{__('Application Version')}}" >
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label" for="footer1">{{__('Footer 1')}}</label>
                                                <input type="text" name="footer1" value="{{old('footer1', $setting->footer1)}}" id="footer1" class="form-control" placeholder="{{__('Year')}}" >
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label" for="footer2">{{__('Footer 2')}}</label>
                                                <input type="text" name="footer2" value="{{old('footer2', $setting->footer2)}}" id="footer2" class="form-control" placeholder="{{__('All rights reserved')}}" >
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label"> {{__('Favicon Icon')}} </label><br>
                                                <input type="file" name="favicon_icon" id="favicon_icon" accept="image/*" onchange="loadFile(event)"><br>
                                                <img src="{{asset('storage/images/app/'.$setting->favicon)}}" id="output" class="mt-2 favicon_size">

                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label"> {{__('Black Logo')}} </label><br>
                                                <input type="file" name="black_logo" id="black_logo" accept="image/*" onchange="loadFile1(event)"><br>
                                                <img src="{{asset('storage/images/app/'.$setting->black_logo)}}"  id="black_logo_output" class="mt-2 logo_size">

                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label"> {{__('White Logo')}} </label><br>
                                                <input type="file" name="white_logo" id="white_logo" accept="image/*" onchange="loadFile2(event)"><br>
                                                <img src="{{asset('storage/images/app/'.$setting->white_logo)}}" id="white_logo_output" class="mt-2 logo_size">

                                            </div>
                                        </div>

                                         
                                        {{-- Tab 15 Website --}}
                                        <div class="tab-pane fade" id="tabs-icons-text-15" role="tabpanel" aria-labelledby="tabs-icons-text-15-tab">
                                            <h4 class="card-title">{{__('Website Settings')}}</h4>

                                            <div class="form-group">
                                                <label class="form-control-label" for="play_store_link">{{__('Playstore Link')}}</label>
                                                <input type="text" name="play_store_link" value="{{old('play_store_link', $setting->play_store_link)}}" id="play_store_link" class="form-control" placeholder="{{__('Playstore Link')}}"  autofocus>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label" for="app_store_link">{{__('Appstore Link')}}</label>
                                                <input type="text" name="app_store_link" value="{{old('app_store_link', $setting->app_store_link)}}" id="app_store_link" class="form-control" placeholder="{{__('Appstore Link')}}" >
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="form-control-label" for="email">{{__('Email')}}</label>
                                                <input type="email" name="email" value="{{old('email', $setting->email)}}" id="email" class="form-control" placeholder="{{__('Email')}}" >
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="form-control-label" for="phone">{{__('Phone Number')}}</label>
                                                <input type="text" name="phone" value="{{old('phone', $setting->phone)}}" id="phone" class="form-control" placeholder="{{__('Phone Number')}}" >
                                            </div>
                                             
                                            <div class="form-group">
                                                <label class="form-control-label" for="address">{{__('Address')}}</label>
                                                <input type="text" name="address" value="{{old('address', $setting->address)}}" id="address" class="form-control" placeholder="{{__('Address')}}" >
                                            </div>
                                        </div>
                                        
                                        {{-- Tab 13 App sharing settings --}}
                                        <div class="tab-pane fade" id="tabs-icons-text-14" role="tabpanel" aria-labelledby="tabs-icons-text-14-tab">
                                            <h4 class="card-title">{{__('App Sharing Settings')}}</h4>

                                            <div class="form-group">
                                                <label class="form-control-label" for="shared_name">{{__('Shared Name')}}</label>
                                                <input type="text" name="shared_name" value="{{old('app_name', $setting->shared_name)}}" id="shared_name" class="form-control" placeholder="{{__('Shared Name')}}"  autofocus>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label" for="shared_url">{{__('Shared URL')}}</label>
                                                <input type="text" name="shared_url" value="{{old('shared_url', $setting->shared_url)}}" id="shared_url" class="form-control" placeholder="{{__('Shared URL')}}" >
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label"> {{__('Shared Image')}} </label><br>
                                                <input type="file" name="shared_image" id="shared_image" accept="image/*" onchange="loadFile4(event)"><br>
                                                <img src="{{asset('storage/images/app/'.$setting->shared_image)}}" id="shared_image_output" class="mt-2 bg_img">
                                            </div>
                                        </div>


                                        {{-- Tab 10 Admin --}}
                                        <div class="tab-pane fade" id="tabs-icons-text-10" role="tabpanel" aria-labelledby="tabs-icons-text-10-tab">
                                            <h4 class="card-title">{{__('Admin Settings')}}</h4>
                                            <div class="form-group">
                                                <label class="form-control-label"> {{__('Header Image')}} </label><br>
                                                <input type="file" name="bg_img" id="bg_img" accept="image/*" onchange="loadFile3(event)"><br>
                                                <img src="{{asset('storage/images/app/'.$setting->bg_img)}}" class="mt-5 bg_img" id="bg_img_output">
                                            </div>
                                            <div class="form-group">
                                                <label for="example-color-input" class="form-control-label">{{__('Color')}}</label>
                                                <input class="form-control"  value="{{old('color', $setting->color)}}" type="color" id="color" name="color" id="example-color-input">
                                            </div>
                                        </div>
                                    </form>

                                        {{-- Tab 13 License --}}
                                        <div class="tab-pane fade {{ $license_status == 0 ? 'show active': '' }}" id="tabs-icons-text-13" role="tabpanel" aria-labelledby="tabs-icons-text-13-tab">
                                            <h4 class="card-title">{{__('License')}}</h4>
                                            <form class="form-horizontal form" id="settingform" action="{{url('/admin/license/update/'.$setting->id)}}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group row">
                                                    <label class="col-sm-3 text-right control-label col-form-label" for="license_code">{{__('License Code')}}</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control w-75" value="{{old('license_code', $setting->license_code)}}" name="license_code" id="license_code" placeholder="{{__('License Code')}}" {{$license_status == 1 ? 'disabled':''}}>
                                                        @error('license_code')                                    
                                                            <div class="invalid-div">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-3 text-right control-label col-form-label" for="license_client_name">{{__('Client Name')}}</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control w-75" value="{{old('license_client_name', $setting->license_client_name)}}" name="license_client_name" id="license_client_name" placeholder="{{__('Client Name')}}" {{$license_status == 1 ? 'disabled':''}}>
                                                        @error('license_client_name')                                    
                                                            <div class="invalid-div">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                
                                                @if(session('status'))
                                                    <h4 class="text-center text-red">{{ session('status') }}</h4>
                                                @endif

                                                @if ($license_status == 0)
                                                    <div class="border-top">
                                                        <div class="card-body text-center">
                                                            <input type="submit" class="btn btn-primary rtl-float-none" value="{{__('Submit')}}">
                                                        </div>
                                                    </div>
                                                @endif
                                            </form>
                                        </div>
                                        @if ($license_status == 1)
                                            <div class="border-top">
                                                <div class="card-body text-center">
                                                    <input type="submit" class="btn btn-primary rtl-float-none" value="{{__('Submit')}}">
                                                </div>
                                            </div>
                                        @endif
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
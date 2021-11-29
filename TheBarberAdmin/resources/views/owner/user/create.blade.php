<div class="container-fluid sidebar_open @if($errors->any()) show_sidebar_create @endif" id="add_user_sidebar">
    <div class="row">
        <div class="col">
            <div class="card py-3 border-0">
                <!-- Card header -->
                <div class="border_bottom_pink pb-3 pt-2 mb-4">
                    <span class="h3">{{__('Create Client')}}</span>
                    <button type="button" class="add_user close">&times;</button>
                </div>
                <form class="form-horizontal"  id="create_user_form" method="post" enctype="multipart/form-data" action="{{url('/owner/users')}}">
                    @csrf
                    <div class="my-0">
                    <?php $is_point_package = config('point.active'); ?>

                        @if ($is_point_package == 1)
                            <?php
                                $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                                $code = substr(str_shuffle($permitted_chars), 0, 6);
                            ?>
                            <div class="form-group">
                                <label class="form-control-label" for="referral_code">{{__('Your reference code')}}</label>
                                <input type="text" name="referral_code" value="{{ $code }}" id="referral_code" class="form-control" readonly>
                                <div class="invalid-div "><span class="referral_code"></span></div>
                            </div>
                          
                            <div class="form-group">
                                <label class="form-control-label" for="friend_code">{{__('Referral code')}}</label>
                                <input type="text" name="friend_code" value="{{ old('friend_code') }}" id="friend_code" class="form-control" placeholder="{{__('Referral code')}}" autofocus>
                                <div class="invalid-div "><span class="friend_code"></span></div>
                            </div>
                        @endif

                        <div class="form-group">
                            <label class="form-control-label" for="name">{{__('Name')}}</label>
                            <input type="text" name="name" value="{{ old('name') }}" id="name" class="form-control" placeholder="{{__('User name')}}" autofocus>
                            <div class="invalid-div "><span class="name"></span></div>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label" for="email">{{__('Email')}}</label><br>
                            <input type="text" name="email" value="{{ old('email') }}"  id="email" class="form-control" placeholder="{{__('Email Address')}}" autocomplete="email">
                            <div class="invalid-div "><span class="email"></span></div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-control-label" for="password">{{__('Password')}}</label>
                            <input type="password" name="password"  id="password" class="form-control" placeholder="{{__('Password')}}" autocomplete="current-password">
                            <div class="invalid-div "><span class="password"></span></div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-control-label" for="code">{{__('Country Code')}}</label><br>
                            <input type="number" min="1" name="code" value="{{ old('code') }}"  id="code" class="form-control" placeholder="{{__('Country Code')}}">
                            <div class="invalid-div "><span class="code"></span></div>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label" for="phone">{{__('Phone no.')}}</label><br>
                            <input type="text" name="phone" value="{{ old('phone') }}"  id="phone" class="form-control" placeholder="{{__('Phone number')}}">
                            <div class="invalid-div "><span class="phone"></span></div>
                        </div>

                        <div class="text-center">
                            <button type="button" id="create_btn" onclick="all_create('create_user_form','users')" class="btn btn-primary mt-4 mb-5 rtl-float-none">{{ __('Create') }}</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
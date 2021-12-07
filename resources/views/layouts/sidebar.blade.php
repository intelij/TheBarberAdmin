<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <?php $black_logo = \App\AdminSetting::find(1)->black_logo; ?>
        <!-- Brand -->
        @if (Auth()->user()->role == 1)
            <a class="navbar-brand p-0" href="{{url('admin/dashboard')}}">
                <img src="{{asset('storage/images/app/'.$black_logo)}}" class="navbar-brand-img sidebar-logo" alt="...">
            </a>
        @elseif (Auth()->user()->role == 2)
            <a class="navbar-brand p-0" href="{{url('owner/dashboard')}}">
                <img src="{{asset('storage/images/app/'.$black_logo)}}" class="navbar-brand-img sidebar-logo" alt="...">
            </a>
        @endif

        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                        <img alt="Image placeholder" src="{{asset('storage/images/users/'.Auth()->user()->image)}}">
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    @if (Auth()->user()->role == 2)
                        <a href="{{url('/owner/profile/'.Auth::user()->id)}}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{__('My profile')}}</span>
                        </a>
                    @elseif(Auth()->user()->role == 1)
                        <a href="{{url('/admin/profile/'.Auth::user()->id)}}" class="dropdown-item">
                            <i class="ni ni-single-02"></i>
                            <span>{{__('My profile')}}</span>
                        </a>
                    @endif
                    <div class="dropdown-divider"></div>
                    @if (Auth()->user()->role == 2)
                        <a href="{{url('/owner/logout/')}}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{ __('Logout') }}</span>
                        </a>
                    @elseif(Auth()->user()->role == 1)
                        <a href="{{url('/admin/logout/')}}" class="dropdown-item">
                            <i class="ni ni-single-02"></i>
                            <span>{{ __('Logout') }}</span>
                        </a>
                    @endif
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        @if (Auth()->user()->role == 1)
                            <a class="navbar-brand pt-0" href="{{url('admin/dashboard')}}">
                                <img src="{{asset('storage/images/app/'.$black_logo)}}" class="navbar-brand-img" alt="...">
                            </a>
                        @elseif (Auth()->user()->role == 2)
                            <a class="navbar-brand pt-0" href="{{url('owner/dashboard')}}">
                                <img src="{{asset('storage/images/app/'.$black_logo)}}" class="navbar-brand-img" alt="...">
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            {{-- Main Admin --}}
            @if (Auth()->user()->role == 1)
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/dashboard')  ? 'active' : ''}}" href="{{url('admin/dashboard')}}">
                            <i class="ni ni-tv-2 text-teal"></i>
                            <span class="nav-link-text">{{ __('Dashboard') }}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/salonowners*')  ? 'active' : ''}}" href="{{url('admin/salonowners')}}">
                            <i class="fa fa-user-circle text-red"></i>
                            <span class="nav-link-text">{{__('Salon Owner')}}</span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link {{ request()->is('admin/salons*')  ? 'active' : ''}}" href="{{url('admin/salons')}}">
                            <i class="ni ni-scissors text-blue"></i>
                            <span class="nav-link-text">{{__('Salon')}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/users*')  ? 'active' : ''}}" href="{{url('admin/users')}}">
                        <i class="fa fa-user text-cyan"></i>
                        <span class="nav-link-text">{{__('Users')}}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/categories*')  ? 'active' : ''}}" href="{{url('admin/categories')}}">
                        <i class="fa fa-list text-orange"></i>
                        <span class="nav-link-text">{{__('Category')}}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/banner*')  ? 'active' : ''}}" href="{{url('admin/banner')}}">
                        <i class="fa fa-image  text-purple"></i>
                        <span class="nav-link-text">{{__('Banner')}}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/coupon*')  ? 'active' : ''}}" href="{{url('admin/coupon')}}">
                        <i class="fas fa-tag text-orange"></i>
                        <span class="nav-link-text">{{__('Coupon')}}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/offer*')  ? 'active' : ''}}" href="{{url('admin/offer')}}">
                        <i class="fa fa-gift "></i>
                        <span class="nav-link-text">{{__('Offer')}}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/review*')  ? 'active' : ''}}" href="{{url('admin/review')}}">
                        <i class="fas fa-star text-yellow"></i>
                        <span class="nav-link-text">{{__('Reported Review')}}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/product*')  ? 'active' : ''}}" href="{{url('admin/product')}}">
                            <i class="fa fa-shopping-bag text-green"></i>
                            <span class="nav-link-text">{{ __('Product') }}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/orders*')  ? 'active' : ''}}" href="{{url('admin/orders')}}">
                            <i class="fa fa-first-order text-blue"></i>
                            <span class="nav-link-text">{{ __('Orders') }}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/report*')  ? 'active_text' : ''}}" href="#navbar-examples1" data-toggle="collapse"  aria-expanded=" {{ request()->is('admin/report*')  ? 'true' : ''}}" role="button" aria-controls="navbar-examples">
                            <i class="fa fa-file text-blue"></i>
                            <span class="nav-link-text">{{__('Reports')}}</span>
                        </a>

                        <div class="collapse  {{ request()->is('admin/report*')  ? 'show' : ''}}" id="navbar-examples1">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('admin/report/user*')  ? 'active_text' : ''}}" href="{{url('admin/report/user')}}">{{__('User Report')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('admin/report/revenue*')  ? 'active_text' : ''}}" href="{{url('admin/report/revenue')}}">{{__('Revenue Report')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('admin/report/salon/revenue*')  ? 'active_text' : ''}}" href="{{url('admin/report/salon/revenue')}}">{{__('Salon Revenue Report')}}</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/notification*')  ? 'active' : ''}}" href="#navbar-examples" data-toggle="collapse"  aria-expanded=" {{ request()->is('admin/notification*')  ? 'true' : ''}}" role="button" aria-controls="navbar-examples">
                            <i class="fa fa-bell text-red"></i>
                            <span class="nav-link-text">{{__('Notification')}}</span>
                        </a>

                        <div class="collapse  {{ request()->is('admin/notification*')  ? 'show' : ''}}" id="navbar-examples">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('admin/notification/template')  ? 'active_text' : ''}}" href="{{url('admin/notification/template')}}">{{__('Template')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('admin/notification/send')  ? 'active_text' : ''}}" href="{{url('admin/notification/send')}}">{{__('Send Notification')}}</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/language*')  ? 'active' : ''}}" href="{{url('admin/language')}}">
                        <i class="fas fa-language text-pink"></i>
                        <span class="nav-link-text">{{__('Language')}}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/module*')  ? 'active' : ''}}" href="{{url('admin/module')}}">
                        <i class="fas fa-tasks text-purple"></i>
                        <span class="nav-link-text">{{__('Module')}}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/settings*')  ? 'active' : ''}}" href="{{url('admin/settings')}}">
                        <i class="fa fa-cog text-green"></i>
                        <span class="nav-link-text">{{__('Settings')}}</span>
                        </a>
                    </li>

                </ul>
                {{-- Salon Owner --}}
            @elseif (Auth()->user()->role == 2)
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('owner/dashboard')  ? 'active' : ''}}" href="{{url('owner/dashboard')}}">
                            <i class="ni ni-tv-2 text-teal"></i>
                            <span class="nav-link-text">{{ __('Dashboard') }}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('owner/cart')  ? 'active' : ''}}" href="{{url('owner/cart')}}">
                            <i class="ni ni-cart text-teal"></i>
                            <span class="nav-link-text">{{ __('Cart') }}</span>
                            <span class="badge bg-secondary ml-2">{{session()->has('cart') ?  count(session()->get('cart')) : 0}}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('owner/calendar*')  ? 'active' : ''}}" href="{{url('owner/calendar')}}">
                            <i class="ni ni-calendar-grid-58 text-pink"></i>
                            <span class="nav-link-text">{{ __('Calendar') }}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('owner/booking*')  ? 'active' : ''}}" href="{{url('owner/booking')}}">
                        <i class="ni ni-collection text-blue"></i>
                        <span class="nav-link-text">{{ __('Booking') }}</span>
                        </a>
                    </li>

                    <li class="nav-item ">
                        <a class="nav-link {{ request()->is('owner/users*')  ? 'active' : ''}}" href="{{url('owner/users')}}">
                            <i class="fa fa-user text-cyan"></i>
                            <span class="nav-link-text ">{{ __('Client') }}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('owner/employee*')  ? 'active' : ''}}" href="{{url('owner/employee')}}">
                        <i class="fa fa-users text-orange"></i>
                        <span class="nav-link-text">{{ __('Employee') }}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('owner/services*')  ? 'active' : ''}}" href="{{url('owner/services')}}">
                        <i class="fa fa-magic text-teal"></i>
                        <span class="nav-link-text">{{ __('Services') }}</span>
                        </a>
                    </li>





                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('owner/gallery*')  ? 'active' : ''}}" href="{{url('owner/gallery')}}">
                        <i class="fa fa-image  text-purple"></i>
                        <span class="nav-link-text">{{ __('Gallery') }}</span>
                        </a>
                    </li>



                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('owner/report*')  ? 'active_text' : ''}}" href="#navbar-examples1" data-toggle="collapse"  aria-expanded=" {{ request()->is('owner/report*')  ? 'true' : ''}}" role="button" aria-controls="navbar-examples">
                            <i class="fa fa-file text-red"></i>
                            <span class="nav-link-text">{{ __('Reports') }}</span>
                        </a>

                        <div class="collapse  {{ request()->is('owner/report*')  ? 'show' : ''}}" id="navbar-examples1">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('owner/report/user*')  ? 'active_text' : ''}}" href="{{url('owner/report/user')}}">{{ __('Client Report') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('owner/report/revenue*')  ? 'active_text' : ''}}" href="{{url('owner/report/revenue')}}">{{ __('Revenue Report') }}</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('owner/review*')  ? 'active' : ''}}" href="{{url('owner/review')}}">
                        <i class="fas fa-star text-yellow"></i>
                        <span class="nav-link-text">{{ __('Review') }}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('owner/product*')  ? 'active' : ''}}" href="{{url('owner/product')}}">
                        <i class="fa fa-shopping-bag text-green"></i>
                        <span class="nav-link-text">{{ __('Product') }}</span>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('owner/orders*')  ? 'active' : ''}}" href="{{url('owner/orders')}}">
                            <i class="fa fa-first-order text-blue"></i>
                            <span class="nav-link-text">{{ __('Orders') }}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('owner/market-place*')  ? 'active' : ''}}" href="{{url('owner/market-place')}}">
                            <i class="fa fa-briefcase text-blue"></i>
                            <span class="nav-link-text">{{ __('Market Place') }}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('owner/settings*')  ? 'active' : ''}}" href="{{url('owner/settings')}}">
                            <i class="fa fa-cog text-green"></i>
                            <span class="nav-link-text">{{ __('Settings') }}</span>
                        </a>
                    </li>
                </ul>
            @endif
        </div>
    </div>
</nav>

@extends('layouts.app')
@section('content')

@include('layouts.top-header', [
        'title' => __('Clients'),
        'class' => 'col-lg-7'
    ])

<div class="container-fluid mt--6 mb-5 only_search">
    <div class="row">
      <div class="col">
        <div class="card">
          <!-- Card header -->
          <div class="card-header border-0">
            <span class="h3">{{__('Users table')}}</span>
            <button class="btn btn-primary addbtn float-right p-2 add_user" id="add_user"><i class="fas fa-plus mr-1"></i>{{__('Add New')}}</button>
          </div>
          
          <form action="{{url('/owner/users/filter')}}" method="post" class="ml-4" id="filter_revene_form">
            @csrf
            <div class="row rtl-date-filter-row">
                <div class="form-group col-3">
                    <input type="text" id="filter_date" value="{{$pass}}" name="filter_date" class="form-control" placeholder="{{__('-- Select Date --')}}">
                
                    @if($errors->any())
                        <h4 class="text-center text-red mt-2">{{$errors->first()}}</h4>
                    @endif
                </div>
                <div class="form-group col-3">
                    <button type="submit" id="filter_btn" class="btn btn-primary  rtl-date-filter-btn">{{ __('Apply') }}</button>
                </div>
            </div>
        </form>

          <!-- table -->
          <div class="table-responsive">
            <table class="table align-items-center table-flush" id="dataTableUser" class="dataTableUser">
              <thead class="thead-light">
                <tr>
                    <th scope="col" class="sort">{{__('#')}}</th>
                    <th scope="col" class="sort">{{__('Image')}}</th>
                    <th scope="col" class="sort">{{__('Name')}}</th>
                    <th scope="col" class="sort">{{__('Email')}}</th>
                    <th scope="col" class="sort">{{__('Created_at')}}</th>
                    <th scope="col" class="sort">{{__('Updated_at')}}</th>
                    <th scope="col"></th>
                </tr>
              </thead>
              <tbody class="list">
                    @foreach ($users as $key => $user)
                        <tr>
                            <th>{{$loop->iteration}}</th>
                            <td>
                                <img alt="Image placeholder" class="tableimage rounded" src="{{asset('storage/images/users/'.$user->image)}}">
                            </td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->created_at}}</td>
                            <td>{{$user->updated_at}}</td>
                            <td class="table-actions">
                                <a href="{{url('owner/users/'.$user->id)}}" class="table-action text-warning" data-toggle="tooltip" data-original-title="{{__('View client')}}">
                                    <i class="fas fa-eye"></i>
                                </a>
                          </td>
                        </tr>
                    @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
</div>

@include('owner.user.create')
@endsection
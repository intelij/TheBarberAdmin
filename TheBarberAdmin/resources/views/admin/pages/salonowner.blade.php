@extends('layouts.app')
@section('content')

@include('layouts.top-header', [
        'title' => __('Salon Owner') ,
        'class' => 'col-lg-7'
    ])

<div class="container-fluid mt--6 mb-5 only_search">
    <div class="row">
      <div class="col">
        <div class="card">
          <!-- Card header -->
          <div class="card-header border-0">
            <span class="h3">{{__('Salon Owners table')}}</span>
          </div>
          <!-- table -->
          <div class="table-responsive">
            <table class="table align-items-center table-flush" id="dataTableUser">
              <thead class="thead-light">
                <tr>
                    <th scope="col" class="sort">{{__('#')}}</th>
                    <th scope="col" class="sort">{{__('Image')}}</th>
                    <th scope="col" class="sort">{{__('Name')}}</th>
                    <th scope="col" class="sort">{{__('Salon name')}}</th>
                    <th scope="col" class="sort">{{__('Email')}}</th>
                    <th scope="col" class="sort">{{__('Created_at')}}</th>
                    <th scope="col" class="sort">{{__('Updated_at')}}</th>
                    <th scope="col" class="sort">{{__('Status')}}</th>
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
                            <td>{{$user->salonName}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->created_at}}</td>
                            <td>{{$user->updated_at}}</td>
                            <td>
                              <label class="custom-toggle">
                                  <input type="checkbox"  onchange="hideUser({{$user->id}})"{{$user->status == 0?'checked': ''}}>
                                  <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Hide"></span>
                              </label>
                            </td>
                            <td class="table-actions">
                              @php
                                  $base_url = url('/');
                              @endphp
                              <button class="btn-white btn shadow-none p-0 m-0 table-action text-warning bg-white" onclick="show_owner({{$user->id}},'{{$base_url}}')" data-toggle="tooltip" data-original-title="{{__('View Owner')}}">
                                  <i class="fas fa-eye"></i>
                              </button>
                              <button class="btn-white btn shadow-none p-0 m-0 table-action text-danger bg-white" onclick="deleteData('admin/salonowner',{{$user->id}},'{{$base_url}}')" data-toggle="tooltip" data-original-title="{{__('Delete Owner')}}">
                                <i class="fas fa-trash"></i>
                            </button>
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
@include('admin.salon owner.show')
@endsection
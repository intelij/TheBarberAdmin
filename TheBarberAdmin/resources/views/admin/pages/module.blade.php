@extends('layouts.app')
@section('content')

@include('layouts.top-header', [
        'title' => __('Modules'),
        'class' => 'col-lg-7'
    ])

<div class="container-fluid mt--6 mb-5">
    <div class="row">
      <div class="col">
        <div class="card">
          <!-- Card header -->
          <div class="card-header border-0">
            <span class="h3">{{__('Module table')}}</span>
            <button class="btn btn-primary addbtn float-right p-2 add_module" id="add_module"><i class="fas fa-plus mr-1"></i>{{__('Add New')}}</button>
          </div>
          <!-- table -->
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                    <th scope="col" class="sort">{{__('#')}}</th>
                    <th scope="col" class="sort">{{__('Name')}}</th>
                    <th scope="col" class="sort">{{__('Settings')}}</th>
                </tr>
              </thead>
              <tbody class="list">
                @if (count($modules) != 0)
                      @foreach ($modules as $key => $module)
                          <tr>
                              <th>{{$modules->firstItem() + $key}}</th>
                              <td>{{$module->module}}</td>
                              <td>
                                @if ($module->module == "loyalty_module")
                                  <button class="btn-white btn shadow-none p-0 m-0 table-action text-info bg-white" onclick="loyaltyModule({{$module->id}})">
                                      <i class="fas fa-cog"></i>
                                  </button>
                                @endif
                              </td>
                          </tr>
                      @endforeach
                @else
                  <tr>
                      <th colspan="10" class="text-center">{{__('No modules')}}</th>
                  </tr>
                @endif
              </tbody>
            </table>
            <div class="float-right mr-4 mb-1">
                {{ $modules->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

@include('admin.module.create')
@if (config('point.active') == 1)
  @include('admin.module.loyaltyModuleSetting')
@endif

@endsection
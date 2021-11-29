<div class="container-fluid sidebar_open @if($errors->any()) show_sidebar_create @endif" id="add_module_sidebar">
    <div class="row">
        <div class="col">            
            <div class="card py-3 border-0">
                <div class="border_bottom_pink pb-3 pt-2 mb-4">
                    <span class="h3">{{__('Create Module')}}</span>
                    <button type="button" class="add_module close">&times;</button>
                </div>
                <form class="form-horizontal" id="create_module_form" method="post" enctype="multipart/form-data" action="{{url('/admin/module')}}">
                    @csrf
                    <div class="my-0">
                        <div class="form-group">
                            <label class="form-control-label" for="zip">{{__('Upload Module Zip')}}</label>
                            <input type="file" accept=".zip" name="zip" placeholder="{{__('Module Zip file')}}" autofocus>
                            <div class="invalid-div "><span class="zip"></span></div>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label">{{__('Module Of:')}}</label>

                            <div class="custom-control custom-radio mb-3">
                              <input name="module" class="custom-control-input" value="loyalty_module" id="loyalty_module" type="radio">
                              <label class="custom-control-label" for="loyalty_module"> {{__('Loyalty point system')}} </label>
                            </div>
                            <div class="invalid-div "><span class="module"></span></div>
                        </div>

                        <div class="text-center">
                            <button type="button" id="create_btn" onclick="all_create('create_module_form','module')" class="btn rtl-float-none btn-primary mt-4 mb-5">{{ __('Create') }}</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
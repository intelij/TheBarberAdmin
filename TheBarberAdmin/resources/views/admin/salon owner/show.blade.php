<div class="container-fluid  sidebar_open" id="show_owner_sidebar">
    <div class="row">
        <div class="col">
            <div class="card py-3 border-0">
                <!-- Card header -->
                <div class="border_bottom_pink pb-3 pt-2 mb-4">
                    <span class="h3">{{__('View Salon Owner')}}</span>
                    <button type="button" class="show_owner_close close">&times;</button>
                </div>
                <div class="card card-profile shadow mt-5">
                    <div class="row justify-content-center">
                        <div class="card-profile-image">
                            <img src="" class="rounded-circle owner_img owner_img_round">
                        </div>
                    </div>
                    <div class="card-body pt-0 pt-md-4 mt-8">
                        <div class="text-center">
                            <h3 id="owner_name"></h3>

                            <div class="h4 font-weight-400" id="owner_email"></div>
                            <div class="h4 font-weight-400" id="owner_phone"></div>

                            <hr class="my-4" />
                            
                            <h3 id="salon_name"></h3>
                            <img src="" class="salon_size my-3">
                            <a href="" class="btn btn-primary rtl-float-none" id="view_salon">{{__('View Salon')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
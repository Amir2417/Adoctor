@if (admin_permission_by_name("admin.health.package.store"))
    <div id="add-health-package" class="mfp-hide large">
        <div class="modal-data">
            <div class="modal-header px-0">
                <h5 class="modal-title">{{ __("Add Health Package") }}</h5>
            </div>
            <div class="modal-form-data">
                <form class="card-form" action="{{ setRoute('admin.health.package.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-10-none">
                        <div class="col-xl-12 col-lg-12 form-group">
                            @include('admin.components.form.input',[
                                'label'             => __("Package Name")."*",
                                'name'              => "name",
                                'placeholder'       => __("Write Name")."...",
                                'value'             => old('name'),  
                            ])
                        </div>
                        <div class="col-xl-12 col-lg-12 form-group">
                            @include('admin.components.form.input',[
                                'label'             => __("Package Title"),
                                'name'              => "title",
                                'placeholder'       => __("Write Title")."...",
                                'value'             => old('title'),  
                            ])
                        </div>
                        <div class="col-xl-12 col-lg-12 form-group">
                            <label>{{ __("Regular Price")}}*</label>
                            <div class="input-group">
                                @include('admin.components.form.input',[
                                'name'              => "price",
                                'class'             => "number-input",
                                'placeholder'       => __("Write Price")."...",
                                'value'             => old('price'),   
                                ])
                                <span class="input-group-text">{{ get_default_currency_code($default_currency) }}</span>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 form-group">
                            <label>{{__("Offer Price")}}</label>
                            <div class="input-group">
                                @include('admin.components.form.input',[
                                'name'              => "offer_price",
                                'class'             => "number-input",
                                'placeholder'       => __("Write Offer Price")."...",
                                'value'             => old('offer_price'),   
                                ])
                                <span class="input-group-text">{{ get_default_currency_code($default_currency) }}</span>
                            </div>
                        </div>
                        
                        <div class="col-xl-12 col-lg-12 form-group">
                            @include('admin.components.button.form-btn',[
                                'class'         => "w-100 btn-loading",
                                'text'          => "Submit",
                                'permission'    => "admin.health.package.store"
                            ])
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

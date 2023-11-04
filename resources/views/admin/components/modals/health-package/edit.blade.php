@if (admin_permission_by_name("admin.health.package.update"))
    <div id="health-package-edit" class="mfp-hide large">
        <div class="modal-data">
            <div class="modal-header px-0">
                <h5 class="modal-title">{{ __("Edit Health Package") }}</h5>
            </div>
            <div class="modal-form-data">
                <form class="card-form" action="{{ setRoute('admin.health.package.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <input type="hidden" name="target" value="{{ old('target') }}">
                    <div class="row mb-10-none">
                        <div class="col-xl-12 col-lg-12 form-group">
                            @include('admin.components.form.input',[
                                'label'             => __("Package Name"),
                                'name'              => "edit_name",
                                'placeholder'       => __("Write Name")."...",
                                'value'             => old('edit_name'),
                                
                            ])
                        </div>
                        <div class="col-xl-12 col-lg-12 form-group">
                            @include('admin.components.form.input',[
                                'label'             => __("Package Title"),
                                'name'              => "edit_title",
                                'placeholder'       => __("Write Title")."...",
                                'value'             => old('edit_title'),  
                            ])
                        </div>
                        
                        <div class="col-xl-12 col-lg-12 form-group">
                            <label>{{__("Regular Price") }}*</label>
                            <div class="input-group">
                                @include('admin.components.form.input',[
                                'name'              => "edit_price",
                                'class'             => "number-input",
                                'placeholder'       => __("Write Price")."...",
                                'value'             => old('edit_price'),   
                                ])
                                <span class="input-group-text">{{ get_default_currency_code($default_currency) }}</span>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 form-group">
                            <label>{{__("Offer Price")}}</label>
                            <div class="input-group">
                                @include('admin.components.form.input',[
                                'name'              => "edit_offer_price",
                                'class'             => "number-input",
                                'placeholder'       => __("Write Offer Price")."...",
                                'value'             => old('edit_offer_price'),   
                                ])
                                <span class="input-group-text">{{ get_default_currency_code($default_currency) }}</span>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 form-group">
                            @include('admin.components.button.form-btn',[
                                'class'         => "w-100 btn-loading",
                                'text'          => "Update",
                                'permission'    => "admin.health.package.update"
                            ])
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('script')
        <script>
            openModalWhenError("health-package-edit","#health-package-edit");
            
            $(".edit-modal-button").click(function(){
                var oldData = JSON.parse($(this).parents("tr").attr("data-item"));
                var editModal = $("#health-package-edit");

                editModal.find("form").first().find("input[name=target]").val(oldData.id);
                editModal.find("input[name=edit_name]").val(oldData.name);
                editModal.find("input[name=edit_title]").val(oldData.title);
                editModal.find("input[name=edit_price]").val(oldData.price);
                editModal.find("input[name=edit_offer_price]").val(oldData.offer_price);
                editModal.find("input[name=edit_home_service]").val(oldData.home_service);

                refreshSwitchers("#health-package-edit");
                openModalBySelector("#health-package-edit");
            });
        </script>
        
    @endpush
@endif
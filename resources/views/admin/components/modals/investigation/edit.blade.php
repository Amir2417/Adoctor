@if (admin_permission_by_name("admin.investigation.update"))
    <div id="investigation-edit" class="mfp-hide large">
        <div class="modal-data">
            <div class="modal-header px-0">
                <h5 class="modal-title">{{ __("Edit Investigation") }}</h5>
            </div>
            <div class="modal-form-data">
                <form class="card-form" action="{{ setRoute('admin.investigation.update') }}" method="POST">
                    @csrf
                    @method("PUT")
                    <input type="hidden" name="target" value="{{ old('target') }}">
                    <div class="row mb-10-none">
                        <div class="col-xl-12 col-lg-12 form-group">
                            @include('admin.components.form.input',[
                                'label'         => __("Test Name")."*",
                                'name'          => "edit_name",
                                'placeholder'   => __("Write Name")."...",
                                'value'         => old('edit_name'),
                            ])
                        </div>
                        <div class="col-xl-12 col-lg-12 form-group">
                            <label>{{ __("Regular Price") }}*</label>
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
                            <label>{{ __("Offer Price") }}*</label>
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
                            @include('admin.components.form.switcher',[
                                'label'         => __("Home Service"),
                                'name'          => 'edit_home_service',
                                'value'         => old('edit_home_service'),
                                'options'       => [__("Home Service") => 1,__("Investigation") => 0],
                            ])
                        </div>
                        <div class="col-xl-12 col-lg-12 form-group d-flex align-items-center justify-content-between mt-4">
                            <button type="button" class="btn btn--danger modal-close">{{ __("Cancel") }}</button>
                            <button type="submit" class="btn btn--base">{{ __("Update") }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('script')
        <script>
            openModalWhenError("investigation-edit","#investigation-edit");
            
            $(".edit-modal-button").click(function(){
                var oldData = JSON.parse($(this).parents("tr").attr("data-item"));
                var editModal = $("#investigation-edit");

                editModal.find("form").first().find("input[name=target]").val(oldData.id);
                editModal.find("input[name=edit_name]").val(oldData.name);
                editModal.find("input[name=edit_price]").val(oldData.price);
                editModal.find("input[name=edit_offer_price]").val(oldData.offer_price);
                editModal.find("input[name=edit_home_service]").val(oldData.home_service);

                refreshSwitchers("#investigation-edit");
                openModalBySelector("#investigation-edit");
            });
        </script>
        
    @endpush
@endif
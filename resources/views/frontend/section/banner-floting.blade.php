<div class="banner-flotting-section {{ $class ?? "" }}">
    <div class="container">
        <div class="banner-flotting-item">
            <form class="banner-flotting-item-form" method="GET" action="{{ setRoute('frontend.doctor.search') }}">
                @csrf
                <div class="form-group">
                    <select class="form--control select2-basic" name="branch" spellcheck="false" data-ms-editor="true">
                        <option disabled selected>{{ __("Select Branch") }}</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <select class="form--control select2-basic" name="department" spellcheck="false" data-ms-editor="true">
                        <option disabled selected>{{ __("Select Department") }}</option>
                    </select>
                </div>
                <div class="form-group dr-name">
                    <input type="text" class="form--control" name="doctor" value="{{ $searchDoctor ?? "" }}" placeholder="{{ __("Doctor Name") }}" spellcheck="false" data-ms-editor="true">
                    <i class="fas fa-user"></i>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn--base search-btn w-100"><i class="fas fa-search me-1"></i>{{ __("Search") }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script')
    <script>

        $(document).ready(function(){

            var getDepartmentURL = "{{ setRoute('get.branch.departments') }}";

            $('select[name="branch"]').on('change',function(){
                var branch = $(this).val();

                if(branch == "" || branch == null) {
                    return false;
                }

                $.post(getDepartmentURL,{branch:branch,_token:"{{ csrf_token() }}"},function(response){
                    var option = '';
                    if(response.data.branch.departments.length > 0) {
                        $.each(response.data.branch.departments,function(index,item) {
                            option += `<option value="${item.hospital_department_id}">${item.department.name}</option>`
                        });
                        $("select[name=department]").html(option);
                        $("select[name=department]").select2();

                    }
                }).fail(function(response) {

                    var errorText = response.responseJSON;
                    
                });

            });
        });
   
    </script>
@endpush
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Banner floting Section
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="banner-flotting-section home pt-120 mb-20">
    <div class="container">
        <div class="banner-flotting-item">
            <form action="{{ setRoute('frontend.branch.search') }}" method="GET">
                <div class="row mb-30-none justify-content-center">
                    <div class="col-lg-9 col-md-9 col-sm-8 mb-30">
                        <input type="search" name="branch" value="{{ $search_string ?? "" }}" class="form--control" placeholder="{{ __("Search") }}...">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 mb-30">
                        <div class="branch-btn-search">
                            <button type="submit" class="btn--base search-btn w-100"><i class="fas fa-search me-1"></i> {{ __("Search") }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End  floting Section
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

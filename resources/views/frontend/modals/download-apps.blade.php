
<div class="modal fade bd-example-modal-app" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" id="mySmallModalLabel">
      <div class="modal-content">
        <div class="payment-form-modal-wrapper">
            <div class="date-select-wrapper mb-60">
                <h4 class="title"><i class="fas fa-cloud-download-alt"></i> {{ __("Download App") }}...!</h4>
                
            </div>
            <p>{{ __($app_settings->url_title) ?? '' }}</p>
            <div class="footer-download d-flex justify-content-center">
                <div class="footer-download-btn">
                    <a href="{{ $app_settings->android_url ?? "" }}" target="_blank"><img src="{{ asset('public/frontend/images/app/play_store.png')}} " alt="app"></a>
                </div>
                <div class="footer-download-btn ms-4">
                    <a href="{{ $app_settings->iso_url ?? "" }}" target="_blank"><img src="{{ asset('public/frontend/images/app/app_store.png')}} " alt="app"></a>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>

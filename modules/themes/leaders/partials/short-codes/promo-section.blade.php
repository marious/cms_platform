<div class="container">
    <div class="row">
        @foreach(get_latest_services(3) as $index => $service)
            <div class="col-md-4 col-lg-4">
                <div class="single-promo-block promo-hover-bg-{{ $index+1 }} hover-image shadow-lg p-5 custom-radius white-bg">
                    <div class="promo-block-icon mb-3">
                        <span class="{{ $service->icon }}"></span>
                    </div>
                    <div class="promo-block-content">
                        <h5>{{ $service->name }}</h5>
                        <p>{{ $service->description }}</p>
                    </div>
                </div>
            </div>
        @endforeach
        {{-- <div class="col-md-4 col-lg-4">
            <div class="single-promo-block promo-hover-bg-1 hover-image shadow-lg p-5 custom-radius white-bg">
                <div class="promo-block-icon mb-3">
                    <span class="fab fa-superpowers icon-md color-primary"></span>
                </div>
                <div class="promo-block-content">
                    <h5>Creative Design</h5>
                    <p>Compellingly promote collaborative products without synergistic schemas. </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <div class="single-promo-block promo-hover-bg-2 hover-image shadow-lg p-5 custom-radius white-bg">
                <div class="promo-block-icon mb-3">
                    <span class="far fa-clock icon-md color-primary"></span>
                </div>
                <div class="promo-block-content">
                    <h5>Cyber Security</h5>
                    <p>Enthusiastically scale mission-critical imperatives rather than an expanded array.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <div class="single-promo-block promo-hover-bg-3 hover-image shadow-lg p-5 custom-radius white-bg">
                <div class="promo-block-icon mb-3">
                    <span class="fas fa-headphones-alt icon-md color-primary"></span>
                </div>
                <div class="promo-block-content">
                    <h5>Cloud Services</h5>
                    <p>Rapidiously create cooperative resources rather than client-based leadership skills.</p>
                </div>
            </div>
        </div> --}}
    </div>
</div>

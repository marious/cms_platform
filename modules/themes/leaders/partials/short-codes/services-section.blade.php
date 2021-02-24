<div class="row">
    @foreach(get_latest_business_solutions(6) as $item)
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="services-single d-flex p-5 my-md-3 my-lg-3 my-sm-0 shadow-sm white-bg rounded">
                <div class="service-icon mr-4">
                    <span class="{{ $item->icon }}"></span>
                </div>
                <div class="services-content-wrap">
                    <h5>{{ $item->name }}</h5>
                    <p class="mb-0">{{ $item->description }}</p>
                    <a href="{{ $item->url }}" target="_blank" class="detail-link mt-3">Read more <span class="ti-arrow-right"></span></a>
                </div>
            </div>
        </div>
    @endforeach
</div>

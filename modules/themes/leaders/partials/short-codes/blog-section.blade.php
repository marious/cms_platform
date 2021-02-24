<div class="row justify-content-center">
    @foreach(get_featured_posts(3) as $post)
        <div class="col-md-6 col-lg-4">
            <div class="single-blog-card card border-0 shadow-sm">
                <div class="blog-img">
                    <a href="{{ $post->url }}"><span class="category position-absolute">{{ $post->categories[0]->name }}</span></a>
                    <a href="{{ $post->url }}"><img src="{{ get_image_url($post->image, 'medium') }}" class="card-img-top position-relative img-fluid" alt="blog"></a>
                </div>
                <div class="card-body">
                    <h3 class="h5 mb-2 card-title"><a href="{{ $post->url }}">{{ $post->name }}</a></h3>
                </div>
                <div class="card-footer border-0 d-flex align-items-center justify-content-between">
                    <div class="author-meta d-flex align-items-center">
                        <span class="fa fa-user mr-2 p-3 bg-white rounded-circle border"></span>
                        <div class="author-content">
                            <a href="#" class="d-block">ThemeTags</a>
                            <small>
                                <span class="created__month">{{ $post->created_at->format('M') }}</span>
                                <span class="created__date">{{ $post->created_at->format('d') }}</span>
                                <span class="created__year">{{ $post->created_at->format('Y') }}</span>
                            </small>
                        </div>
                    </div>
                    <div class="author-like">
                        <a href="#"><span class="fa fa-share-alt"></span> 50</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- <div class="col-md-6 col-lg-4">
        <div class="single-blog-card card border-0 shadow-sm">
            <div class="blog-img">
                <a href="#"><span class="category position-absolute">SEO, Analytics</span></a>
                <a href="#"><img src="{!! Theme::asset()->url('img/blog/2.jpg') !!} " class="card-img-top position-relative img-fluid" alt="blog"></a>
            </div>
            <div class="card-body">
                <h3 class="h5 mb-2 card-title"><a href="#">Quickly formulate backend</a></h3>
                <p class="card-text">Synergistically engage effective ROI after customer directed partnerships.</p>
            </div>
            <div class="card-footer border-0 d-flex align-items-center justify-content-between">
                <div class="author-meta d-flex align-items-center">
                    <span class="fa fa-user mr-2 p-3 bg-white rounded-circle border"></span>
                    <div class="author-content">
                        <a href="#" class="d-block">ThemeTags</a>
                        <small>May 28, 2020</small>
                    </div>
                </div>
                <div class="author-like">
                    <a href="#"><span class="fa fa-share-alt"></span> 30</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="single-blog-card card border-0 shadow-sm">
            <div class="blog-img">
                <a href="#"><span class="category position-absolute">Marketing</span></a>
                <a href="#"><img src="{!! Theme::asset()->url('img/blog/3.jpg') !!} " class="card-img-top position-relative img-fluid" alt="blog"></a>
            </div>
            <div class="card-body">
                <h3 class="h5 mb-2 card-title"><a href="#">Objectively extend extensive</a></h3>
                <p class="card-text">Holisticly mesh open-source leadership rather than proactive users.</p>
            </div>
            <div class="card-footer border-0 d-flex align-items-center justify-content-between">
                <div class="author-meta d-flex align-items-center">
                    <span class="fa fa-user mr-2 p-3 bg-white rounded-circle border"></span>
                    <div class="author-content">
                        <a href="#" class="d-block">ThemeTags</a>
                        <small>May 30, 2020</small>
                    </div>
                </div>
                <div class="author-like">
                    <a href="#"><span class="fa fa-share-alt"></span> 55</a>
                </div>
            </div>
        </div>
    </div> --}}
</div>

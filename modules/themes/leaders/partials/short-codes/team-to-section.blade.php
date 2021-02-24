<div class="row">
    @foreach(get_latest_members(3) as $members)
        <div class="col-md-4">
            <div class="staff-member">
                <div class="card text-center border-0">
                    <img src=" {{ get_image_url($members->image, 'medium') }} " alt="team image" class="card-img-top">
                    <div class="card-body">
                        <h5 class="teacher mb-0">{{ $members->name }}</h5>
                        <span>{{ $members->position }}</span>
                        <ul class="list-inline pt-2 social">
                            <li class="list-inline-item"><a href="{{ $members->facebook }}" target="_blank"><span class="ti-facebook"></span></a></li>
                            <li class="list-inline-item"><a href="{{ $members->linkedin }}" target="_blank"><span class="ti-linkedin"></span></a></li>
                            <li class="list-inline-item"><a href="{{ $members->dribbble }}" target="_blank"><span class="ti-dribbble"></span></a></li>
                        </ul>
                    </div>
                </div>
                <div class="overlay d-flex align-items-center justify-content-center">
                    <div class="overlay-inner">
                        <p class="teacher-quote">"{{ $members->quote }}" </p><a
                            href="#" class="teacher-name">
                            <h5 class="mb-0 teacher text-white">{{ $members->name }}</h5></a>
                        <span class="teacher-field text-white">{{ $members->position }}</span>
                        <ul class="list-inline py-4 social">
                            <li class="list-inline-item"><a href="{{ $members->facebook }}" target="_blank"><span class="ti-facebook"></span></a></li>
                            <li class="list-inline-item"><a href="{{ $members->linkedin }}" target="_blank"><span class="ti-linkedin"></span></a></li>
                            <li class="list-inline-item"><a href="{{ $members->dribbble }}" target="_blank"><span class="ti-dribbble"></span></a></li>
                        </ul>
                        <p class="teacher-see-profile">
                            <a href="#" class="btn outline-white-btn">View my profile</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{--     <div class="col-md-4">
            <div class="staff-member">
                <div class="card text-center border-0">
                    <img src=" {!! Theme::asset()->url('img/team-1.jpg') !!} " alt="team image" class="card-img-top">
                    <div class="card-body">
                        <h5 class="teacher mb-0">Richard Ford</h5>
                        <span>Instructor of Mathematics</span>
                        <ul class="list-inline pt-2 social">
                            <li class="list-inline-item"><a href="" target="_blank"><span
                                    class="ti-facebook"></span></a></li>
                            <li class="list-inline-item"><a href="" target="_blank"><span
                                    class="ti-linkedin"></span></a></li>
                            <li class="list-inline-item"><a href="" target="_blank"><span
                                    class="ti-dribbble"></span></a></li>
                        </ul>
                    </div>
                </div>
                <div class="overlay d-flex align-items-center justify-content-center">
                    <div class="overlay-inner">
                        <p class="teacher-quote">"Dramatically leverage existing fully researched platforms vis-a-vis viral." </p><a
                            href="#" class="teacher-name">
                        <h5 class="mb-0 teacher text-white">Richard Ford</h5></a>
                        <span class="teacher-field text-white">Instructor of Mathematics</span>
                        <ul class="list-inline py-4 social">
                            <li class="list-inline-item"><a href="" target="_blank"><span
                                    class="ti-facebook"></span></a></li>
                            <li class="list-inline-item"><a href="" target="_blank"><span
                                    class="ti-linkedin"></span></a></li>
                            <li class="list-inline-item"><a href="" target="_blank"><span
                                    class="ti-dribbble"></span></a></li>
                        </ul>
                        <p class="teacher-see-profile">
                            <a href="#" class="btn outline-white-btn">View my profile</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="staff-member">
                <div class="card text-center border-0">
                    <img src="{!! Theme::asset()->url('img/team-3.jpg') !!} " alt="team image" class="card-img-top">
                    <div class="card-body">
                        <h5 class="teacher mb-0">Kely Roy</h5>
                        <span>Lead Designer</span>
                        <ul class="list-inline pt-2 social">
                            <li class="list-inline-item"><a href="" target="_blank"><span
                                    class="ti-facebook"></span></a></li>
                            <li class="list-inline-item"><a href="" target="_blank"><span
                                    class="ti-linkedin"></span></a></li>
                            <li class="list-inline-item"><a href="" target="_blank"><span
                                    class="ti-dribbble"></span></a></li>
                        </ul>
                    </div>
                </div>
                <div class="overlay d-flex align-items-center justify-content-center">
                    <div class="overlay-inner">
                        <p class="teacher-quote">"Credibly extend high-payoff web-readiness via top-line relationships." </p><a
                            href="#" class="teacher-name">
                        <h5 class="mb-0 teacher text-white">Kely Roy</h5></a><span class="teacher-field text-white">Lead Designer</span>
                        <ul class="list-inline py-4 social">
                            <li class="list-inline-item"><a href="" target="_blank"><span
                                    class="ti-facebook"></span></a></li>
                            <li class="list-inline-item"><a href="" target="_blank"><span
                                    class="ti-linkedin"></span></a></li>
                            <li class="list-inline-item"><a href="" target="_blank"><span
                                    class="ti-dribbble"></span></a></li>
                        </ul>
                        <p class="teacher-see-profile">
                            <a href="#" class="btn outline-white-btn">View my profile</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="staff-member">
                <div class="card text-center border-0">
                    <img src="{!! Theme::asset()->url('img/team-2.jpg') !!} " alt="team image" class="img-fluid">
                    <div class="card-body">
                        <h5 class="teacher mb-0">Gerald Nichols</h5>
                        <span>Managing Director</span>
                        <ul class="list-inline pt-2 social">
                            <li class="list-inline-item"><a href="" target="_blank"><span
                                    class="ti-facebook"></span></a></li>
                            <li class="list-inline-item"><a href="" target="_blank"><span
                                    class="ti-linkedin"></span></a></li>
                            <li class="list-inline-item"><a href="" target="_blank"><span
                                    class="ti-dribbble"></span></a></li>
                        </ul>
                    </div>
                </div>
                <div class="overlay d-flex align-items-center justify-content-center">
                    <div class="overlay-inner">
                        <p class="teacher-quote">"Authoritatively evolve stand-alone e-tailers whereas prospective partnerships." </p><a
                            href="#" class="teacher-name">
                        <h5 class="mb-0 teacher text-white">Gerald Nichols</h5></a>
                        <span class="teacher-field text-white">Managing Director</span>
                        <ul class="list-inline py-4 social">
                            <li class="list-inline-item"><a href="" target="_blank"><span
                                    class="ti-facebook"></span></a></li>
                            <li class="list-inline-item"><a href="" target="_blank"><span
                                    class="ti-linkedin"></span></a></li>
                            <li class="list-inline-item"><a href="" target="_blank"><span
                                    class="ti-dribbble"></span></a></li>
                        </ul>
                        <p class="teacher-see-profile">
                            <a href="#" class="btn outline-white-btn">View my profile</a>
                        </p>
                    </div>
                </div>
            </div>
        </div> --}}
</div>

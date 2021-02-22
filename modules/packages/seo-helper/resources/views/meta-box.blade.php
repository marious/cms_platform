<a href="#" class="btn-trigger-show-seo-detail">{{ trans('packages/seo-helper::seo-helper.edit_seo_meta') }}</a>

@php
    $locales = Language::getSupportedLocales();
    $default = $locales[Language::getDefaultLocale()];

@endphp

@if ($locales && count($locales) > 1)
    <div class="tabbable-custom mb-3">
        <ul class="nav nav-tabs" id="seo-tab">
            <li class="nav-item">
                <a href="#tab_seo_detail_{{ $default['lang_locale'] }}" class="nav-link seo-tab active" data-toggle="tab" data-lang="{{ $default['lang_locale'] }}">
                    {!! language_flag($default['lang_flag'], $default['lang_name']) !!}
                    {{ $default['lang_name'] }}
                </a>
            </li>
            @foreach ($locales as $key => $locale)

                @foreach($meta as $item)
                    @if (!isset($meta[$locale['lang_locale']. '_seo_title']))
                        @php
                            $meta[$locale['lang_locale']. '_seo_title'] = $meta['seo_title'];
                        @endphp
                    @endif
                        @if (!isset($meta[$locale['lang_locale']. '_seo_description']))
                            @php
                             $meta[$locale['lang_locale']. '_seo_description'] = $meta['seo_description'];
                            @endphp
                        @endif
                @endforeach

                @if ($default['lang_code'] == $locale['lang_code']) @continue @endif
                <li class="nav-item">
                    <a href="#tab_seo_detail_{{ $locale['lang_locale'] }}" class="nav-link seo-tab" data-toggle="tab" data-lang="{{ $locale['lang_locale'] }}">
                        {!! language_flag($locale['lang_flag'], $locale['lang_name']) !!}
                        {{ $locale['lang_name'] }}
                    </a>
                </li>
            @endforeach

        </ul>

        <div class="tab-content">

            <div class="tab-pane active" id="tab_seo_detail_{{ $default['lang_locale'] }}" data-lang="{{$default['lang_locale']}}">
                <div class="seo-preview">
                    <p class="default-seo-description @if (!empty($object->id)) hidden @endif">{{ trans('packages/seo-helper::seo-helper.default_description') }}</p>
                    <div class="existed-seo-meta @if (empty($object->id)) hidden @endif">
        <span class="page-title-seo">
             {{ $meta['seo_title'] ?? (!empty($object->id) ? $object->name ?? $object->title : null) }}
        </span>

                        <div class="page-url-seo ws-nm">
                            <p>{{ !empty($object->id) && $object->url ? $object->url : '-' }}</p>
                        </div>

                        <div class="ws-nm">
                            <span style="color: #70757a;">{{ !empty($object->id) && $object->created_at ? $object->created_at->format('M d, Y')  : now()->format('M d, Y') }} - </span>
                            <span class="page-description-seo">
                {{ strip_tags($meta['seo_description'] ?? (!empty($object->id) ? $object->description : (!empty($object->id) && $object->content ? Str::limit($object->content, 250) : old('seo_meta.seo_description')))) }}
            </span>
                        </div>
                    </div>
                </div>
                <div class="{{ $default['lang_locale'] }}-seo-edit-section hidden">
                    <hr>
                    <div class="form-group">
                        <label for="{{ $default['lang_locale'] }}_seo_title" class="control-label">{{ trans('packages/seo-helper::seo-helper.seo_title') }}</label>
                        {!! Form::text('seo_meta['.$default['lang_locale'].'_seo_title]', $meta[''.$default['lang_locale'].'_seo_title'] ?? old('seo_meta.'.$default['lang_locale'].'_seo_title'), ['class' => 'form-control', 'id' => ''.$default['lang_locale'].'_seo_title', 'placeholder' => trans('packages/seo-helper::seo-helper.seo_title'), 'data-counter' => 120]) !!}
                    </div>
                    <div class="form-group">
                        <label for="{{ $default['lang_locale'] }}_seo_description" class="control-label">{{ trans('packages/seo-helper::seo-helper.seo_description') }}</label>
                        {!! Form::textarea('seo_meta['.$default['lang_locale'].'_seo_description]', strip_tags($meta[''.$default['lang_locale'].'_seo_description']) ?? old('seo_meta.'.$default['lang_locale'].'_seo_description'), ['class' => 'form-control', 'rows' => 3, 'id' => ''.$default['lang_locale'].'_seo_description', 'placeholder' => trans('packages/seo-helper::seo-helper.seo_description'), 'data-counter' => 155]) !!}
                    </div>
                </div>
            </div>

            @foreach ($locales as $key => $locale)
                @if ($default['lang_code'] == $locale['lang_code']) @continue @endif
                <div class="tab-pane" id="tab_seo_detail_{{ $locale['lang_locale']}}" data-lang="{{ $locale['lang_locale'] }}">
                    <div class="seo-preview">
                        <p class="default-seo-description @if (!empty($object->id)) hidden @endif">{{ trans('packages/seo-helper::seo-helper.default_description') }}</p>
                        <div class="existed-seo-meta @if (empty($object->id)) hidden @endif">
        <span class="page-title-seo">
             {{ $meta['seo_title'] ?? (!empty($object->id) ? $object->name ?? $object->title : null) }}
        </span>

                            <div class="page-url-seo ws-nm">
                                <p>{{ !empty($object->id) && $object->url ? $object->url : '-' }}</p>
                            </div>

                            <div class="ws-nm">
                                <span style="color: #70757a;">{{ !empty($object->id) && $object->created_at ? $object->created_at->format('M d, Y')  : now()->format('M d, Y') }} - </span>
                                <span class="page-description-seo">
                {{ strip_tags($meta['seo_description'] ?? (!empty($object->id) ? $object->description : (!empty($object->id) && $object->content ? Str::limit($object->content, 250) : old('seo_meta.seo_description')))) }}
            </span>
                            </div>
                        </div>
                    </div>
                    <div class="{{ $locale['lang_locale']}}-seo-edit-section hidden">
                        <hr>
                        <div class="form-group">
                            <label for="seo_title" class="control-label">{{ trans('packages/seo-helper::seo-helper.seo_title') }}</label>
                            {!! Form::text('seo_meta['.$locale['lang_locale'].'_seo_title]', $meta[''.$locale['lang_locale'].'_seo_title'] ?? old(''.$locale['lang_locale'].'_seo_meta.seo_title'), ['class' => 'form-control', 'id' =>''.$locale['lang_locale'].'_seo_title', 'placeholder' => trans('packages/seo-helper::seo-helper.seo_title'), 'data-counter' => 120]) !!}
                        </div>
                        <div class="form-group">
                            <label for="seo_description" class="control-label">{{ trans('packages/seo-helper::seo-helper.seo_description') }}</label>
                            {!! Form::textarea('seo_meta['.$locale['lang_locale'].'_seo_description]', strip_tags($meta[''.$locale['lang_locale'].'_seo_description']) ?? old('seo_meta.'.$locale['lang_locale'].'_seo_description'), ['class' => 'form-control', 'rows' => 3, 'id' => ''.$locale['lang_locale'].'_seo_description', 'placeholder' => trans('packages/seo-helper::seo-helper.seo_description'), 'data-counter' => 155]) !!}
                        </div>
                    </div>
                </div>
            @endforeach

        </div>





    </div>
@else
    <div class="seo-preview">
        <p class="default-seo-description @if (!empty($object->id)) hidden @endif">{{ trans('packages/seo-helper::seo-helper.default_description') }}</p>
        <div class="existed-seo-meta @if (empty($object->id)) hidden @endif">
        <span class="page-title-seo">
             {{ $meta['seo_title'] ?? (!empty($object->id) ? $object->name ?? $object->title : null) }}
        </span>

            <div class="page-url-seo ws-nm">
                <p>{{ !empty($object->id) && $object->url ? $object->url : '-' }}</p>
            </div>

            <div class="ws-nm">
                <span style="color: #70757a;">{{ !empty($object->id) && $object->created_at ? $object->created_at->format('M d, Y')  : now()->format('M d, Y') }} - </span>
                <span class="page-description-seo">
                {{ strip_tags($meta['seo_description'] ?? (!empty($object->id) ? $object->description : (!empty($object->id) && $object->content ? Str::limit($object->content, 250) : old('seo_meta.seo_description')))) }}
            </span>
            </div>
        </div>
    </div>
    <div class="seo-edit-section hidden">
        <hr>
        <div class="form-group">
            <label for="seo_title" class="control-label">{{ trans('packages/seo-helper::seo-helper.seo_title') }}</label>
            {!! Form::text('seo_meta[seo_title]', $meta['seo_title'] ?? old('seo_meta.seo_title'), ['class' => 'form-control', 'id' => 'seo_title', 'placeholder' => trans('packages/seo-helper::seo-helper.seo_title'), 'data-counter' => 120]) !!}
        </div>
        <div class="form-group">
            <label for="seo_description" class="control-label">{{ trans('packages/seo-helper::seo-helper.seo_description') }}</label>
            {!! Form::textarea('seo_meta[seo_description]', strip_tags($meta['seo_description']) ?? old('seo_meta.seo_description'), ['class' => 'form-control', 'rows' => 3, 'id' => 'seo_description', 'placeholder' => trans('packages/seo-helper::seo-helper.seo_description'), 'data-counter' => 155]) !!}
        </div>
    </div>
@endif




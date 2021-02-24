@php
    $prefix = apply_filters(FILTER_SLUG_PREFIX, $prefix);
    $value = $value ? $value : old('slug');
    if (isset($_GET['ref_lang'])) {
        $lang = trim($_GET['ref_lang']);
        $name = strpos($name, '_') ? $lang . '_' . Str::after($name, '_') : '';
    } else {
        $lang = strpos($name, '_') ? Str::before($name, '_') : '';
    }
    $prefix = $prefix ? $lang : '';
@endphp

<div id="{{ $lang ? $lang . '-' : '' }}edit-slug-box" data-lang="{{ $lang }}"
        @if (empty($value) && !$errors->has($name)) class="hidden edit-slug-box" @else class="edit-slug-box" @endif>
    <label class="control-label required" for="current-slug">{{ trans('core/base::forms.permalink') }}:</label>
    <span id="{{ $lang ? $lang . '-' : '' }}sample-permalink">
        <a class="{{ $lang ? $lang . '-' : '' }}permalink perma" target="_blank" href="{{ str_replace('--slug--', $value, url($prefix) . '/' . config('packages.slug.general.pattern')) }}{{ $ending_url }}@if (Auth::user() && $preview)?preview=true @endif">
            <span class="{{ $lang }}-default-slug">{{ url($prefix) }}/<span id="{{ $lang ? $lang . '-' : '' }}editable-post-name" class="editable-post-name">{{ $value }}</span>{{ $ending_url }}</span>
        </a>
    </span>
    <span id="{{ $lang ? $lang . '-' : '' }}edit-slug-buttons">
        <button type="button" data-lang="{{ $lang }}" class="btn btn-secondary change_slug" id="{{ $lang ? $lang . '_' : '' }}change_slug">{{ trans('core/base::forms.edit') }}</button>
        <button type="button" data-lang="{{ $lang }}" class="save btn btn-secondary btn-ok" id="{{ $lang ? $lang . '-' : '' }}btn-ok">{{ trans('core/base::forms.ok') }}</button>
        <button type="button" class="cancel button-link" data-lang="{{ $lang }}">{{ trans('core/base::forms.cancel') }}</button>
        @if (Auth::user() && $preview)
            <a class="btn btn-info btn-preview" target="_blank" href="{{ str_replace('--slug--', $value, url($prefix) . '/' . config('packages.slug.general.pattern')) }}{{ $ending_url }}?preview=true">{{ __('Preview') }}</a>
        @endif
    </span>
</div>
<input type="hidden" id="{{ $lang ? $lang . '-' : '' }}current-slug" name="{{ $name }}" value="{{ $value }}">
<div data-url="{{ route('slug.create') }}" data-view="{{ rtrim(str_replace('--slug--', '', url($prefix) . '/' . config('packages.slug.general.pattern')), '/') . '/' }}" id="{{ $lang ? $lang . '_' : '' }}slug_id" data-id="{{ $id ? $id : 0 }}"></div>
<input type="hidden" name="slug_id" value="{{ $id ? $id : 0 }}">

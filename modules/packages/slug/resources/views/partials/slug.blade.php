@php
$value = '';
if (!isset($lang)) {
    if (isset($_GET['ref_lang'])) {
        $lang = trim($_GET['ref_lang']);
    } else {
        $lang = Language::getDefaultLocale();
    }
}

if ($object->id && $object->slug) {
    $value = $object->getSlugItem()->getTranslation('key', $lang);
}

@endphp
@if (!$object->id)
    <div class="form-group @if ($errors->has('slug')) has-error @endif">
        {!! Form::permalink($lang.'_slug', old('slug'), 0, $prefix) !!}
        {!! Form::error($lang.'_slug', $errors) !!}
    </div>
@else
    <div class="form-group @if ($errors->has('slug')) has-error @endif">
        {!! Form::permalink($lang.'_slug', $value, $object->slug_id, $prefix, SlugHelper::canPreview(get_class($object)) && $object->status != \EG\Base\Enums\BaseStatusEnum::PUBLISHED) !!}
        {!! Form::error($lang.'_slug', $errors) !!}
    </div>
@endif
<input type="hidden" name="model" value="{{ get_class($object) }}">

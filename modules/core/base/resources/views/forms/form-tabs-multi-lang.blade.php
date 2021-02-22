@extends('core/base::layouts.master')
@section('content')
    @if ($showStart)
        {!! Form::open(Arr::except($formOptions, ['template'])) !!}
    @endif

    @php do_action(BASE_ACTION_TOP_FORM_CONTENT_NOTIFICATION, request(), $form->getModel()) @endphp
    <div class="row">
        <div class="col-md-9">
            <div class="tabbable-custom mb-3">
                <ul class="nav nav-tabs">
                    @php
                    $locales = Language::getSupportedLocales();
                    $default = $locales[Language::getDefaultLocale()];
                    @endphp
                    <li class="nav-item">
                        <a href="#tab_detail_{{ $default['lang_locale'] }}" class="nav-link active" data-toggle="tab">
                            {!! language_flag($default['lang_flag'], $default['lang_name']) !!}
                            {{ $default['lang_name'] }}
                        </a>
                    </li>

                    @foreach ($locales as $key => $locale)
                        @if ($default['lang_code'] == $locale['lang_code']) @continue @endif
                    <li class="nav-item">
                        <a href="#tab_detail_{{ $locale['lang_locale'] }}" class="nav-link" data-toggle="tab">
                            {!! language_flag($locale['lang_flag'], $locale['lang_name']) !!}
                            {{ $locale['lang_name'] }}
                        </a>
                    </li>
                    @endforeach

                    {!! apply_filters(BASE_FILTER_REGISTER_CONTENT_TABS, null, $form->getModel()) !!}
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_detail_{{ $default['lang_locale'] }}">
                        @if ($showFields)
                            @foreach ($fields as $key => $field)
                                @if ($field->getName() == $form->getBreakFieldPoint())
                                    @break
                                @endif
                                @if (!in_array($field->getName(), $exclude))
                                    {!! $field->render() !!}
                                    @if ($field->getName() == 'name' && defined('BASE_FILTER_SLUG_AREA'))
                                        {!! apply_filters(BASE_FILTER_SLUG_AREA, $form->getModel(), $default['lang_locale']) !!}
                                    @endif
                                @endif
                            @endforeach
                        @endif
                        <div class="clearfix"></div>
                    </div>

                    @foreach ($locales as $key => $locale)
                        @if ($default['lang_code'] == $locale['lang_code']) @continue @endif
                        <div class="tab-pane" id="tab_detail_{{ $locale['lang_locale']}}">
                            @if ($showFields)
                                @foreach ($fields as $key => $field)
                                    @php
                                    $defaultFieldName = $field->getName();
                                    @endphp
                                    @if ($field->getName() == $form->getBreakFieldPoint())
                                        @break
                                    @endif
                                    @if (in_array($field->getName(), config('core.base.multiLang.allowed')))
                                        @php
                                        $transFieldValue = $form->getModel()->getTranslation($field->getName(), $locale['lang_locale']);
                                        $field->setValue($transFieldValue);
                                        $field->setOption('attr.data-lang', $locale['lang_locale']);
                                        $field->setName($locale['lang_locale'].'_'.$field->getName());
                                        @endphp
                                        {!! $field->render() !!}
                                            @if ($field->getName() == $locale['lang_locale'].'_name' && defined('BASE_FILTER_SLUG_AREA'))
                                                {!! apply_filters(BASE_FILTER_SLUG_AREA, $form->getModel(), $locale['lang_locale']) !!}
                                            @endif
                                    @endif

                                    @php
                                    $field->setName($defaultFieldName);
                                    @endphp
                                @endforeach
                            @endif
                            <div class="clearfix"></div>
                        </div>
                    @endforeach


                    @php
                    $form->getModel()->setLocale($default['lang_locale']);
                    @endphp


                    {!! apply_filters(BASE_FILTER_REGISTER_CONTENT_TAB_INSIDE, null, $form->getModel()) !!}
                </div>
            </div>

            @foreach ($form->getMetaBoxes() as $key => $metaBox)
                {!! $form->getMetaBox($key) !!}
            @endforeach


            @php do_action(BASE_ACTION_META_BOXES, 'advanced', $form->getModel()) @endphp
        </div>
        <div class="col-md-3 right-sidebar">
            {!! $form->getActionButtons() !!}
            @php do_action(BASE_ACTION_META_BOXES, 'top', $form->getModel()) @endphp


            @foreach($fields as $key => $field)
                @if ($field->getName() == $form->getBreakFieldPoint())
                    @break
                @else
                    @unset($fields[$key])
                @endif
            @endforeach


            @foreach ($fields as $field)
                @if (!in_array($field->getName(), $exclude))
                    <div class="widget meta-boxes">
                        <div class="widget-title">
                            <h4>{!! Form::customLabel($field->getName(), $field->getOption('label'), $field->getOption('label_attr')) !!}</h4>
                        </div>
                        <div class="widget-body">
                            {!! $field->render([], false) !!}
                        </div>
                    </div>
                @endif
            @endforeach


            @php do_action(BASE_ACTION_META_BOXES, 'side', $form->getModel()) @endphp
        </div>
    </div>


    @if ($showEnd)
        {!! Form::close() !!}
    @endif
@stop

@if ($form->getValidatorClass())
    @if ($form->isUseInlineJs())
        {!! Assets2::scriptToHtml('jquery') !!}
        {!! Assets2::scriptToHtml('form-validation') !!}
        {!! $form->renderValidatorJs() !!}
    @else
        @push('footer')
            {!! $form->renderValidatorJs() !!}
        @endpush
    @endif
@endif


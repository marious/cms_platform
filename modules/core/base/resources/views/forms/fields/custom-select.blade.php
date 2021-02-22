@if ($showLabel && $showField)
    @if ($options['wrapper'] !== false)
        <div {!! $options['wrapperAttrs'] !!}>
    @endif
@endif

            @if ($showLabel && $options['label'] !== false && $options['label_show'])
                {!! Form::customLabel($name, $options['label'], $options['label_attr']) !!}
            @endif

            @if ($showField)
                @php
                    Arr::set($options['attr'], 'class', Arr::get($options['attr'], 'class') . ' ui-select');
                    $emptyVal = $options['empty_value'] ? ['' => $options['empty_value']] : null;
                @endphp
                <div class="ui-select-wrapper">
                    @php
                        Arr::set($selectAttributes, 'class', Arr::get($selectAttributes, 'class') . ' ui-select');
                    @endphp
                {!! Form::select($name, (array)$emptyVal + $options['choices'], $options['selected'], $options['attr']) !!}
                    <svg class="svg-next-icon svg-next-icon-size-16">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#select-chevron"></use>
                    </svg>
                </div>


                {{--                @include('forms.partials.help-block')--}}
            @endif

{{--            @include('forms.partials.errors')--}}

            @if ($showLabel && $showField)
                @if ($options['wrapper'] !== false)
        </div>
    @endif
@endif

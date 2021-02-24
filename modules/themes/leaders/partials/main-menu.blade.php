<ul {!! clean($options) !!}>
    @foreach ($menu_nodes as $key => $row)
        <li @if($row->parent_id == 0) class="nav-item @if ($row->has_child) dropdown @endif {{ $row->css_class }} @endif">
            <a href="{{ $row->url }}"  class=" @if($row->parent_id == 0) nav-link @else dropdown-item @endif" target="{{ $row->target }}">
                @if ($row->icon_font)<i class='{{ trim($row->icon_font) }}'></i> @endif{{ $row->title }}
                @if ($row->has_child) <span class="toggle-icon"><i class="fa fa-angle-down"></i></span>@endif
            </a>
            @if ($row->has_child)
                {!!
                    Menu::generateMenu([
                        'menu'       => $menu,
                        'menu_nodes' => $row->child,
                        'view'       => 'main-menu',
                        'options'    => ['class' => 'sub-menu dropdown-menu'],
                    ])
                !!}
            @endif
        </li>
    @endforeach
</ul>

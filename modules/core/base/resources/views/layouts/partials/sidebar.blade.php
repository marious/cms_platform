<aside class="left-sidebar" data-sidebarbg="skin5">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="p-t-30">
                @foreach ($menus = dashboard_menu()->getAll() as $menu)
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark @if(isset($menu['children']) && count($menu['children'])) has-arrow @endif" href="{{ $menu['url'] }} @if($menu['active']) selected @endif" aria-expanded="false">
                            <i class="{{ $menu['icon'] }}"></i>
                            <span class="hide-menu">
                                {{ !is_array(trans($menu['name'])) ? trans($menu['name']) : null }}
                            </span>
                        </a>
                        @if(isset($menu['children']) && count($menu['children']))
                            <ul aria-expanded="false" class="@if(!$menu['active']) collapse @endif first-level">
                                @foreach($menu['children'] as $item)
                                    <li class="sidebar-item @if($item['active']) active @endif" id="{{ $item['id'] }}">
                                        <a href="{{ $item['url'] }}" class="sidebar-link">
                                            <i class="{{ $item['icon'] }}"></i><span class="hide-menu"> {{ trans($item['name']) }} </span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>

                @endforeach


            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>

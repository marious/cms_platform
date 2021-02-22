<a data-type="select"
   data-source="{{ route('roles.list.json') }}"
   data-pk="{{ $item->id }}"
   data-url="{{ route('roles.assign') }}"
   data-value="{{ $item->role_id ? $item->role_id : 0 }}"
   data-title="{{ trans('users.assigned_role') }}"
   class="editable"
   href="#">
    {{ $item->role_name ? $item->role_name : trans('users.no_role_assigned') }}
</a>

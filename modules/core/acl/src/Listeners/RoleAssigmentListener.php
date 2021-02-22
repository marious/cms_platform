<?php
namespace EG\ACL\Listeners;

use Auth;
use EG\ACL\Events\RoleAssignmentEvent;

class RoleAssigmentListener
{
    public function handle(RoleAssignmentEvent $event)
    {
        $permissions = $event->role->permissions;
        $permissions[ACL_ROLE_SUPER_USER] = $event->user->super_user;
        $permissions[ACL_ROLE_MANAGE_SUPERS] = $event->user->manage_supers;

        $event->user->permissions = $permissions;
        $event->user->save();
        cache()->forget(md5('cache-dashboard-menu-' . Auth::user()->getKey()));
    }
}

<?php
namespace EG\ACL\Listeners;

use Auth;
use EG\ACL\Events\RoleUpdateEvent;

class RoleUpdateListener
{
    public function handle(RoleUpdateEvent $event)
    {
        $permissions = $event->role->permissions;
        foreach ($event->role->users()->get() as $user) {
            $permissions[ACL_ROLE_SUPER_USER] = $user->super_user;
            $permissions[ACL_ROLE_MANAGE_SUPERS] = $user->manage_supers;

            $user->permissions = $permissions;
            $user->save();
        }

        cache()->forget(md5('cache-dashboard-menu-' . Auth::user()->getKey()));
    }
}

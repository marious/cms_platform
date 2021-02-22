<?php
namespace EG\ACL\Events;

use Event;
use EG\ACL\Models\Role;
use Illuminate\Queue\SerializesModels;

class RoleUpdateEvent extends Event
{
    use SerializesModels;

    public $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }
}

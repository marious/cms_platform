<?php
namespace EG\ACL\Events;

use Event;
use EG\ACL\Models\Role;
use EG\ACL\Models\User;
use Illuminate\Queue\SerializesModels;

class RoleAssignmentEvent extends Event
{
    use SerializesModels;

   /**
     * @var Role
     */
    public $role;

    /**
     * @var User
     */
    public $user;


    public function __construct(Role $role, User $user)
    {
        $this->role = $role;
        $this->user = $user;
    }
}

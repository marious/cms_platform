<?php
namespace EG\ACL\Repositories\Interfaces;

use EG\Support\Repositories\Interfaces\RepositoryInterface;

interface UserInterface extends RepositoryInterface
{
     /**
     * Get unique username from email
     * @param $email
     * @return mixed
     */
    public function getUniqueUsernameFromEmail($email);
}

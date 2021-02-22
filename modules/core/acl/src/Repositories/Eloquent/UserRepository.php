<?php
namespace EG\ACL\Repositories\Eloquent;

use EG\ACL\Repositories\Interfaces\UserInterface;
use EG\Support\Repositories\Eloquent\RepositoriesAbstract;

class UserRepository extends RepositoriesAbstract implements UserInterface
{
  public function getUniqueUsernameFromEmail($email)
  {
      $emailPrefix = substr($email,0, strpos($email, '@'));
      $username = $emailPrefix;
      $offset = 1;
      while ($this->getFirstBy(['username' => $username])) {
          $username = $emailPrefix . $offset;
      }
      $this->resetModel();
      return $username;
  }
}

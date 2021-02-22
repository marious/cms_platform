<?php
namespace EG\ACL\Repositories\Eloquent;

use Illuminate\Support\Str;
use EG\ACL\Repositories\Interfaces\RoleInterface;
use EG\Support\Repositories\Eloquent\RepositoriesAbstract;

class RoleRepository extends RepositoriesAbstract implements RoleInterface
{

  public function createSlug($name, $id)
  {
      $slug = Str::slug($name);
      $index = 1;
      $baseSlug = $slug;
      while ($this->model->where('slug', $slug)->where('id', '!=', $id)->count() > 0) {
          $slug = $baseSlug . '-' . $index++;
      }
      $this->resetModel();
      return $slug;
  }

}

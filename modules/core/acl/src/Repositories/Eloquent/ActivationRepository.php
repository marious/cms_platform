<?php
namespace EG\ACL\Repositories\Eloquent;

use Carbon\Carbon;
use EG\ACL\Models\User;
use Illuminate\Support\Str;
use EG\ACL\Models\Activation;
use EG\ACL\Repositories\Interfaces\ActivationInterface;
use EG\Support\Repositories\Eloquent\RepositoriesAbstract;


class ActivationRepository extends RepositoriesAbstract implements ActivationInterface
{
    /**
       * The activation expiration time, in seconds
       *
       * @var int
       */
      protected $expires = 259200;

      public function createUser(User $user)
      {
          $activation = $this->model;
          $code = $this->generateActivationCode();
          $activation->fill(compact('code'));
          $activation->user_id = $user->getKey();
          $activation->save();
          return $activation;
      }

      public function exists(User $user, $code = null)
      {
          $expires = $this->expires();

          $activation = $this
                      ->model
                      ->newQuery()
                      ->where('user_id', $user->getKey())
                      ->where('completed', false)
                      ->where('created_at', '>', $expires);
          if ($code) {
              $activation->where('code', $code);
          }

          return $activation ?: false;
      }

      public function complete(User $user, $code)
      {
          $expires = $this->expires();

          /**
           * @var Activation $activation
           */
          $activation = $this
              ->model
              ->newQuery()
              ->where('user_id', $user->getKey())
              ->where('code', $code)
              ->where('completed', false)
              ->where('created_at', '>', $expires)
              ->first();

          if ($activation === null) {
              return false;
          }

          $activation->fill([
              'completed'    => true,
              'completed_at' => now(config('app.timezone')),
          ]);

          $activation->save();

          return true;
      }

      public function completed(User $user)
      {
          $activation = $this
              ->model
              ->newQuery()
              ->where('user_id', $user->getKey())
              ->where('completed', true)
              ->first();

          return $activation ?: false;
      }

      public function remove(User $user)
      {
          /**
           * @var Activation $activation
           */
          $activation = $this->completed($user);

          if ($activation === false) {
              return false;
          }

          return $activation->delete();
      }

      public function removeExpired()
      {
          $expires = $this->expires();

          return $this
              ->model
              ->newQuery()
              ->where('completed', false)
              ->where('created_at', '<', $expires)
              ->delete();
      }

      /**
       * Return the expiration date.
       *
       * @return Carbon
       */
      protected function expires()
      {
          return now(config('app.timezone'))->subSeconds($this->expires);
      }

      /**
       * Return a random string for an activation code.
       *
       * @return string
       */
      protected function generateActivationCode()
      {
          return Str::random(32);
      }
}

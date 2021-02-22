<?php
namespace EG\ACL\Services;

use Hash;
use EG\ACL\Models\User;
use Illuminate\Http\Request;
use EG\ACL\Events\RoleAssignmentEvent;
use Illuminate\Database\Eloquent\Model;
use EG\ACL\Services\ActivateUserService;
use EG\Support\Services\ProduceServiceInterface;
use EG\ACL\Repositories\Interfaces\RoleInterface;
use EG\ACL\Repositories\Interfaces\UserInterface;

class CreateUserService implements ProduceServiceInterface
{
    /**
     * @var UserInterface
     */
    protected $userRepository;

    /**
     * @var RoleInterface
     */
    protected $roleRepository;

    /**
     * @var ActivateUserService
     */
    protected $activateUserService;

      /**
     * CreateUserService constructor.
     * @param UserInterface $userRepository
     * @param RoleInterface $roleRepository
     * @param ActivateUserService $activateUserService
     */
    public function __construct(
      UserInterface $userRepository,
      RoleInterface $roleRepository,
      ActivateUserService $activateUserService
  ) {
      $this->userRepository = $userRepository;
      $this->roleRepository = $roleRepository;
      $this->activateUserService = $activateUserService;
  }

 /**
     * @param Request $request
     *
     * @return User|false|Model|mixed
     */
    public function execute(Request $request)
    {
        /**
         * @var User $user
         */
        $user = $this->userRepository->createOrUpdate($request->input());

        if ($request->has('username') && $request->has('password')) {
            $this->userRepository->update(['id' => $user->id], [
                'username' => $request->input('username'),
                'password' => Hash::make($request->input('password')),
            ]);

            if ($this->activateUserService->activate($user) && $request->input('role_id')) {
                $role = $this->roleRepository->findById($request->input('role_id'));

                if (!empty($role)) {
                    $role->users()->attach($user->id);

                    event(new RoleAssignmentEvent($role, $user));
                }
            }
        }

        return $user;
    }
}

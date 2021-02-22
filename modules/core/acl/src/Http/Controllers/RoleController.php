<?php

namespace EG\ACL\Http\Controllers;

use Assets2;
use EG\ACL\Forms\RoleForm;
use Illuminate\Http\Request;
use EG\ACL\Tables\RoleTable;
use EG\Base\Supports\Helper;
use EG\Base\Forms\FormBuilder;
use EG\ACL\Events\RoleUpdateEvent;
use EG\ACL\Events\RoleAssignmentEvent;
use EG\ACL\Http\Requests\RoleCreateRequest;
use EG\Base\Http\Controllers\BaseController;
use EG\Base\Http\Responses\BaseHttpResponse;
use EG\ACL\Repositories\Interfaces\RoleInterface;
use EG\ACL\Repositories\Interfaces\UserInterface;

class RoleController extends BaseController
{

    /**
     * @var RoleInterface
     */
    protected $roleRepository;

    /**
     * @var UserInterface
     */
    protected $userRepository;


    public function __construct(RoleInterface $roleRepository, UserInterface $userRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RoleTable $datatable)
    {
        page_title()->setTitle(trans('core/acl::permissions.role_permission'));

        return $datatable->renderTable();
    }





     /**
     * Return a correctly type casted permissions array
     * @param array $permissions
     * @return array
     */
    public function cleanPermission($permissions)
    {
        if (!$permissions) {
            return [];
        }
        $cleanedPermissions = [];
        foreach ($permissions as $permissionName) {
            $cleanedPermissions[$permissionName] = true;
        }

        return $cleanedPermissions;
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('core/acl::permissions.create_role'));

        return $formBuilder->create(RoleForm::class)->renderForm();
    }

   /**
     * @param RoleCreateRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(RoleCreateRequest $request, BaseHttpResponse $response)
    {
        if ($request->input('is_default')) {
            $this->roleRepository->getModel()->where('id', '>', 0)->update(['is_default' => 0]);
        }

        $role = $this->roleRepository->createOrUpdate([
            'name'        => $request->input('name'),
            'slug'        => $this->roleRepository->createSlug($request->input('name'), 0),
            'permissions' => $this->cleanPermission($request->input('flags')),
            'description' => $request->input('description'),
            'is_default'  => $request->input('is_default'),
            'created_by'  => $request->user()->getKey(),
            'updated_by'  => $request->user()->getKey(),
        ]);

        return $response
            ->setPreviousUrl(route('roles.index'))
            ->setNextUrl(route('roles.edit', $role->id))
            ->setMessage(trans('core/acl::permissions.create_success'));
    }



     /**
     * @param int $id
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function edit($id, FormBuilder $formBuilder)
    {
        $role = $this->roleRepository->findOrFail($id);
        page_title()->setTitle(trans('core/acl::permissions.details') . ' - ' . e($role->name));
        return $formBuilder->create(RoleForm::class, ['model' => $role])->renderForm();
    }

   /**
     * @param int $id
     * @param RoleCreateRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws Exception
     */
    public function update($id, RoleCreateRequest $request, BaseHttpResponse $response)
    {
        if ($request->input('is_default')) {
            $this->roleRepository->getModel()->where('id', '!=', $id)->update(['is_default' => 0]);
        }

        $role = $this->roleRepository->findOrFail($id);

        $role->name = $request->input('name');
        $role->permissions = $this->cleanPermission($request->input('flags'));
        $role->description = $request->input('description');
        $role->updated_by = $request->user()->getKey();
        $role->is_default = $request->input('is_default');
        $this->roleRepository->createOrUpdate($role);

        Helper::clearCache();

        event(new RoleUpdateEvent($role));

        return $response
            ->setPreviousUrl(route('roles.index'))
            ->setNextUrl(route('roles.edit', $id))
            ->setMessage(trans('core/acl::permissions.modified_success'));
    }

    public function getDuplicate($id, BaseHttpResponse $response)
    {
        $baseRole = $this->roleRepository->findOrFail($id);

        $role = $this->roleRepository->createOrUpdate([
            'name'        => $baseRole->name . ' (Duplicate)',
            'slug'        => $this->roleRepository->createSlug($baseRole->slug, 0),
            'permissions' => $baseRole->permissions,
            'description' => $baseRole->description,
            'created_by'  => $baseRole->created_by,
            'updated_by'  => $baseRole->updated_by,
        ]);

        return $response
            ->setPreviousUrl(route('roles.edit', $baseRole->id))
            ->setNextUrl(route('roles.edit', $role->id))
            ->setMessage(trans('core/acl::permissions.duplicated_success'));
    }

    /**
     * @param int $id
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function destroy($id, BaseHttpResponse $response)
    {
        $role = $this->roleRepository->findOrFail($id);
        $role->delete();
        Helper::clearCache();

        return $response->setMessage(trans('core/acl::permissions.delete_success'));
    }


     /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws Exception
     */
    public function deletes(Request $request, BaseHttpResponse $response)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('core/base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $role = $this->roleRepository->findOrFail($id);
            $role->delete();
        }

        Helper::clearCache();

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }


    public function getJson()
    {
        $pl = [];
        foreach ($this->roleRepository->all() as $role) {
            $pl[] = [
                'value' => $role->id,
                'text'  => $role->name,
            ];
        }

        return $pl;
    }

    public function postAssignMember(Request $request, BaseHttpResponse $response)
    {
        $user = $this->userRepository->findOrFail($request->input('pk'));
        $role = $this->roleRepository->findOrFail($request->input('value'));

        $user->roles()->sync([$role->id]);

        event(new RoleAssignmentEvent($role, $user));

        return $response;
    }
}

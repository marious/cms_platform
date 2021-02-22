<?php

namespace EG\ACL\Http\Controllers;

use File;
use Assets2;
use Exception;
use RvMedia;
use EG\ACL\Forms\UserForm;
use Illuminate\Http\Request;
use EG\ACL\Tables\UserTable;
use EG\ACL\Forms\ProfileForm;
use EG\ACL\Forms\PasswordForm;
use EG\Base\Forms\FormBuilder;
use EG\ACL\Services\CreateUserService;
use EG\ACL\Http\Requests\AvatarRequest;
use EG\Base\Events\CreatedContentEvent;
use EG\Base\Events\DeletedContentEvent;
use EG\Base\Events\UpdatedContentEvent;
use EG\Media\Services\ThumbnailService;
use EG\ACL\Services\ChangePasswordService;
use EG\ACL\Http\Requests\CreateUserRequest;
use EG\Base\Http\Controllers\BaseController;
use EG\Base\Http\Responses\BaseHttpResponse;
use EG\ACL\Http\Requests\UpdateProfileRequest;
use EG\ACL\Http\Requests\UpdatePasswordRequest;
use EG\ACL\Repositories\Interfaces\RoleInterface;
use EG\ACL\Repositories\Interfaces\UserInterface;
use EG\Media\Repositories\Interfaces\MediaFileInterface;

class UserController extends BaseController
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
     * @var MediaFileInterface
     */
    protected $fileRepository;


    /**
     * UserController constructor.
     * @param UserInterface $userRepository
     * @param RoleInterface $roleRepository
     * @param MediaFileInterface $fileRepository
     */
    public function __construct(
        UserInterface $userRepository,
        RoleInterface $roleRepository,
        MediaFileInterface $fileRepository
    ) {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->fileRepository = $fileRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserTable $datatable)
    {
        page_title()->setTitle(trans('core/acl::users.users'));

        Assets2::addScripts(['bootstrap-editable'])
            ->addStyles(['bootstrap-editable']);

        return $datatable->renderTable();
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('core/acl::users.create_new_user'));

        return $formBuilder->create(UserForm::class)->renderForm();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request, CreateUserService $service, BaseHttpResponse $response)
    {
        $user = $service->execute($request);

        event(new CreatedContentEvent(USER_MODULE_SCREEN_NAME, $request, $user));

        return $response
            ->setPreviousUrl(route('users.index'))
            ->setNextUrl(route('user.profile.view', $user->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request, BaseHttpResponse $response)
    {
        if ($request->user()->getKey() == $id) {
            return $response
                ->setError()
                ->setMessage(trans('core/acl::users.delete_user_logged_in'));
        }

        try {
            $user = $this->userRepository->findOrFail($id);

            if (!$request->user()->isSuperUser() && $user->isSuperUser()) {
                return $response
                    ->setError()
                    ->setMessage(trans('core/acl::users.cannot_delete_super_user'));
            }

            $this->userRepository->delete($user);
            event(new DeletedContentEvent(USER_MODULE_SCREEN_NAME, $request, $user));

            return $response->setMessage(trans('core/acl::users.deleted'));

        } catch (Exception $ex) {
            return $response
                ->setError()
                ->setMessage(trans('core/acl::users.cannot_delete'));
        }
    }

    public function deletes(Request $request, BaseHttpResponse $response)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                    ->setError()
                    ->setMessage(trans('core/base::notices.no_select'));
        }

        foreach ($ids as $id) {
            if ($request->user()->getKey() == $id) {
                return $response
                    ->setError()
                    ->setMessage(trans('core/acl::users.delete_user_logged_in'));
            }
            try {
                $user = $this->userRepository->findOrFail($id);
                if (!$request->user()->isSuperUser() && $user->isSuperUser()) {
                    continue;
                }
                $this->userRepository->delete($user);
                event(new DeletedContentEvent(USER_MODULE_SCREEN_NAME, $request, $user));
            } catch (Exception $exception) {
                return $response
                    ->setError()
                    ->setMessage($exception->getMessage());
            }
        }

        return $response->setMessage(trans('core/acl::users.deleted'));
    }

    /**
     * @param int $id
     * @param Request $request
     * @param FormBuilder $formBuilder
     * @return Factory|View| RedirectResponse
     */
    public function getUserProfile($id, Request $request, FormBuilder $formBuilder)
    {
        Assets2::addScripts(['bootstrap-pwstrength', 'cropper'])
                        ->addScriptsDirectly('vendor/core/acl/js/profile.js');

        $user = $this->userRepository->findOrFail($id);
        page_title()->setTitle(trans(':name', ['name' => $user->getFullName()]));

        $form = $formBuilder
                ->create(ProfileForm::class, ['model' => $user])
                ->setUrl(route('users.update-profile', $user->id));

        $passwordForm = $formBuilder
                ->create(PasswordForm::class)
                ->setUrl(route('users.change-password', $user->id));

        $canChangeProfile = $request->user()->getKey() == $id || $request->user()->isSuperUser();

        if (!$canChangeProfile) {
            $form->disableFields();
            $form->removeActionButtons();
            $passwordForm->disableFields();
            $passwordForm->removeActionButtons();
        }

        if ($request->user()->isSuperUser()) {
            $passwordForm->remove('old_password');
        }

        $form = $form->renderForm();
        $passwordForm = $passwordForm->renderForm();

        return view('core/acl::users.profile.base', compact('user', 'form', 'passwordForm', 'canChangeProfile'));
    }


    public function postUpdateProfile($id, UpdateProfileRequest $request, BaseHttpResponse $response)
    {
        $user = $this->userRepository->findOrFail($id);

        $currentUser = $request->user();
        if (($currentUser->hasPermission('users.update-profile') && $currentUser->getKey() === $user->id) ||
            $currentUser->isSuperUser()
        ) {
            if ($user->email !== $request->input('email')) {
                $users = $this->userRepository->getModel()
                    ->where('email', $request->input('email'))
                    ->where('id', '<>', $user->id)
                    ->count();
                if ($users) {
                    return $response
                        ->setError()
                        ->setMessage(trans('core/acl::users.email_exist'))
                        ->withInput();
                }
            }

            if ($user->username !== $request->input('username')) {
                $users = $this->userRepository->getModel()
                    ->where('username', $request->input('username'))
                    ->where('id', '<>', $user->id)
                    ->count();
                if ($users) {
                    return $response
                        ->setError()
                        ->setMessage(trans('core/acl::users.username_exist'))
                        ->withInput();
                }
            }
        }

        $user->fill($request->input());
        $this->userRepository->createOrUpdate($user);
        do_action(USER_ACTION_AFTER_UPDATE_PROFILE, USER_MODULE_SCREEN_NAME, $request, $user);

        event(new UpdatedContentEvent(USER_MODULE_SCREEN_NAME, $request, $user));
        return $response->setMessage(trans('core/acl::users.update_profile_success'));

    }


    public function postChangePassword(
        $id,
        UpdatePasswordRequest $request,
        ChangePasswordService $service,
        BaseHttpResponse $response
    )
    {
        $request->merge(['id' => $id]);
        $result = $service->execute($request);

        if ($result instanceof Exception) {
            return $response
                ->setError()
                ->setMessage($result->getMessage());
        }

        return $response->setMessage(trans('core/acl::users.password_update_success'));
    }


    public function postAvatar($id, AvatarRequest $request, ThumbnailService $thumbnailService, BaseHttpResponse $response)
    {
        try {
            $user = $this->userRepository->findOrFail($id);

            $result = RvMedia::handleUpload($request->file('avatar_file'), 0, 'users');

            if ($result['error'] != false) {
                return $response->setError()->setMessage($result['message']);
            }

            $avatarData = json_decode($request->input('avatar_data'));

            $file = $result['data'];

            $thumbnailService
                ->setImage(RvMedia::getRealPath($file->url))
                ->setSize((int)$avatarData->width, (int)$avatarData->height)
                ->setCoordinates((int)$avatarData->x, (int)$avatarData->y)
                ->setDestinationPath(File::dirname($file->url))
                ->setFileName(File::name($file->url) . '.' . File::extension($file->url))
                ->save('crop');

            $this->fileRepository->forceDelete(['id' => $user->avatar_id]);

            $user->avatar_id = $file->id;

            $this->userRepository->createOrUpdate($user);

            return $response
            ->setMessage(trans('core/acl::users.update_avatar_success'))
            ->setData(['url' => RvMedia::url($file->url)]);

        } catch (Exception $ex) {
            return $response
                ->setError()
                ->setMessage($ex->getMessage());
        }
    }


    /**
     * @param int $id
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function makeSuper($id, BaseHttpResponse $response)
    {
        try {
            $user = $this->userRepository->findOrFail($id);

            $user->updatePermission(ACL_ROLE_SUPER_USER, true);
            $user->updatePermission(ACL_ROLE_MANAGE_SUPERS, true);
            $user->super_user = 1;
            $user->manage_supers = 1;
            $this->userRepository->createOrUpdate($user);

            return $response
                ->setNextUrl(route('users.index'))
                ->setMessage(trans('core/base::system.supper_granted'));
        } catch (Exception $ex) {
            return $response
                ->setError()
                ->setNextUrl(route('users.index'))
                ->setMessage($ex->getMessage());
        }
    }

    public function removeSuper($id, Request $request, BaseHttpResponse $response)
    {
        if ($request->user()->getKey() == $id) {
            return $response
                ->setError()
                ->setMessage(trans('core/base::system.cannot_revoke_yourself'));
        }
        $user = $this->userRepository->findOrFail($id);

        $user->updatePermission(ACL_ROLE_SUPER_USER, false);
        $user->updatePermission(ACL_ROLE_MANAGE_SUPERS, false);
        $user->super_user = 0;
        $user->manage_supers = 0;
        $this->userRepository->createOrUpdate($user);

        return $response
            ->setNextUrl(route('users.index'))
            ->setMessage(trans('core/base::system.supper_revoked'));
    }
}

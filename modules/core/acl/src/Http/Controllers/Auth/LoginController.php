<?php
namespace EG\ACL\Http\Controllers\Auth;

use Assets2;
use BaseHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use EG\ACL\Traits\AuthenticatesUsers;
use EG\Base\Http\Controllers\BaseController;
use EG\Base\Http\Responses\BaseHttpResponse;
use Illuminate\Validation\ValidationException;
use EG\ACL\Repositories\Interfaces\UserInterface;
use EG\ACL\Repositories\Interfaces\ActivationInterface;

class LoginController extends BaseController
{
    use AuthenticatesUsers;

      /**
     * Where to redirect users after login.
     *
     * @var string
     */
    public $redirectTo;

    /**
     * @var BaseHttpResponse
     */
    protected $response;

    public function __construct(BaseHttpResponse $response)
    {
        $this->middleware('guest', ['except' => 'logout']);
        $this->redirectTo = BaseHelper::getAdminPrefix();
        $this->response = $response;
    }


    public function showLoginForm()
    {
        page_title()->setTitle(trans('core/acl::auth.login.title'));
        Assets2::addScripts(['jquery-validation'])
                ->addScriptsDirectly('vendor/core/acl/js/login.js')
                ->addStylesDirectly('vendor/core/acl/css/login.css')
                ->removeStyles([
                ])
            ->removeScripts([
                'waves',
            ]);
        return view('core/acl::auth.login');
    }

     /**
     * Handle a login request to the application.
     *
     * @param Request $request
     * @return BaseHttpResponse|Response
     * @throws ValidationException
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $request->merge([$this->username() => $request->input('username')]);
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            $this->sendLockoutResponse($request);
        }

        $user = app(UserInterface::class)->getFirstBy([$this->username() => $request->input($this->username())]);
        if (!empty($user)) {
            if (!app(ActivationInterface::class)->completed($user)) {
                return $this
                        ->response
                        ->setError()
                        ->setMessage(trans('core/acl::auth.login.not_active'));
            }
        }

        if ($this->attemptLogin($request)) {
            app(UserInterface::class)->update(['id' => $user->id], ['last_login' => now(config('app.timezone'))]);
            if (!session()->has('url.intended')) {
                session()->flash('url.intended', url()->current());
            }
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function username()
    {
        return filter_var(request()->input('username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    }


    public function logout(Request $request)
    {
        do_action(AUTH_ACTION_AFTER_LOGOUT_SYSTEM, $request, $request->user());

        $this->guard()->logout();
        $request->session()->invalidate();
        return $this->response
                ->setNextUrl(route('access.login'))
                ->setMessage(trans('core/acl::auth.login.logout_success'));
    }

}

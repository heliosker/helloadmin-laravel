<?php
/**
 *
 * User: bing
 * Date: 2020/12/27
 * Time: 15:18
 */

namespace App\Admin\Controllers;


use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Auth\StatefulGuard;

class AuthController extends AdminController
{
    /**
     * Handle a login request.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function login(Request $request)
    {
        $credentials = $request->only([$this->username(), 'password']);
        $remember = (bool)$request->input('remember', true);

        /** @var \Illuminate\Validation\Validator $validator */
        $validator = Validator::make($credentials, [
            $this->username() => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator);
        }

        if ($token = $this->guard()->attempt($credentials, $remember)) {
            return $this->data($this->withToken($token))->success();
        }

        return $this->loginFailed();
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function admin()
    {
        return $this->data($this->guard()->user())->success();
    }

    /**
     * Logout
     *
     * @return JsonResponse
     */
    public function logout()
    {
        try {
            $this->guard()->logout();
            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    protected function username()
    {
        return 'username';
    }

    /**
     * Get the token array structure.
     *
     * @param $token
     * @return array
     */
    protected function withToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ];
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return Guard|StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard(config('admin.auth.guard') ?: 'admin');
    }

    /**
     * login failed
     *
     * @return JsonResponse
     */
    protected function loginFailed()
    {
        $message = Lang::has('admin.auth_failed')
            ? trans('admin.auth_failed')
            : 'These credentials do not match our records.';

        return $this->error($message, 422);
    }
}

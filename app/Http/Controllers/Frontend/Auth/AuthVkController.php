<?php

namespace App\Http\Controllers\Frontend\Auth;


use App\Http\Controllers\Controller;
use App\Repositories\Frontend\UserRepository;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Laracasts\Flash\Flash;
use \VK\VK as vk;
use \VK\VKException;

class AuthVkController extends Controller
{
    private $default_redirect = '/';
    private $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function redirect()
    {
        $vk = new vk(env('VK_CLIENT_ID'), env('VK_CLIENT_SECRET'));

        return redirect($vk->getAuthorizeUrl('user', env('VK_REDIRECT')));
    }

    public function login(UserRepository $userRepo, Guard $auth)
    {
        $vk = new vk(env('VK_CLIENT_ID'), env('VK_CLIENT_SECRET'));

        try {
            $access_token = $vk->getAccessToken($_REQUEST['code'], env('VK_REDIRECT'));

            $data = $vk->api('users.get',
                [
                    'uids' => $access_token['user_id'],
                    'fields' => 'first_name,last_name,photo_big,status,screen_name'
                ]
            );

            $user = $userRepo->findOrCreate($data['response'][0]);
        } catch (VKException $e) {
            Flash::error(trans('exceptions.auth.vk_exception'));
            return redirect($this->default_redirect);
        }

        $this->auth->login($user, true);
        if (!Session::has('user')) {
            Session::set('user', $user);
        };

        if (
            url()->previous() &&
            strpos(url()->previous(), url('/')) !== false &&
            url()->previous() != route('auth')

        ) {
            return redirect(url()->previous());
        }

        return  redirect($this->default_redirect);
    }

    public function logout()
    {
        $this->auth->logout();
        Flash::error(trans('fro'));

        return redirect($this->default_redirect);
    }
}
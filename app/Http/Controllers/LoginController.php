<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use stdClass;

class LoginController extends Controller
{
    function showLogin()
    {
        // $this->SEO("Đăng nhập", 'login');
        if (!session('url'))
            session(['url' => url()->previous()]);

        return view('pages.signin');
    }

    function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    function login(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'not_regex:/[`!#$%^&*()+\-=\[\]{};\':"\\|,<>\/?~]/'
            ],
            'password' => ['required'],
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        $remember = $request->filled('remember') ? true : false;

        if (Auth::attempt(
            ['email' => $email, 'password' => $password],
            $remember
        ))
            return redirect()->intended();

        return back()->withErrors(
            ['message' => 'Password or email does not match!']
        );
    }

    function createUser(ProfileRequest $request)
    {
        $roleUserId = Role::select('id')
            ->firstWhere('name', 'user');
        $avatar = 'profile_picture/1024px-User-avatar.png';

        $newUser = User::create([
            'email' => $request->input('email'),
            'avatar' => $avatar,
            'fullname' => $request->input('fullname'),
            'slug' => Str::slug($request->input('fullname'), ''),
            'password' => Hash::make($request->input('password')),
            'role_id' => $roleUserId->id,
            'account_status' => 1
        ]);

        Auth::login($newUser, true);

        if (session('url')) {
            $url = session('url');
            $request->session()->forget('url');
            return redirect($url);
        }

        return redirect()->route('home');
    }

    function signUp()
    {
        // $this->createUser();
        return view('pages.signup');
    }

    private function existUser($column, $value)
    {
        return User::where($column, $value)->first();
    }

    // private function SEO($title, $url)
    // {
    //     SEOMeta::setTitle($title);

    //     OpenGraph::addProperty('type', 'website');
    //     OpenGraph::setUrl('https://homiezgame.com/' . $url);
    //     OpenGraph::setTitle($title . ' - HomiezGame');
    //     OpenGraph::addProperty('type', 'article');

    //     JsonLd::setTitle($title . ' - HomiezGame');
    //     JsonLd::setType('website');
    // }
}

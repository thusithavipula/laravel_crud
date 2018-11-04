<?php

namespace App\Http\Controllers;

use URL;
use Auth;
use Validator;
use Redirect;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller {

    protected function validator(array $data) {
        return Validator::make($data, [
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|min:6|confirmed',
                    'role' => 'required|string|',
        ]);
    }

    protected function create(array $data) {
        return User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
                    'role' => $data['role'],
        ]);
    }

    public function register(Request $request) {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        return Redirect::route('admin-settings');
    }

    public function logout() {
        Auth::logout();
        return redirect('/login');
    }

    public function getLoginPage() {
        return view('guest.login');
    }

    public function postLogin(Request $request) {
        $this->validate($request, [
            'email' => 'required|email', 'password' => 'required',
        ]);
        $credentials = array('email' => $request->email, 'password' => $request->password);
        if (Auth::attempt($credentials, $request->has('remember'))) {
            return Redirect::intended(URL::route('admin-home'));
        }
        return Redirect::route('guest-login')->with(['message'=>'Incorrect email address or password', 'type'=>'danger'])->withInput();
    }

}

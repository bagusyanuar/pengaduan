<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest')->except('logout');
    }

    public function login()
    {
        if ($this->request->method() === 'POST') {
            $credentials = [
                'username' => $this->postField('username'),
                'password' => $this->postField('password')
            ];
            if ($this->isAuth($credentials)) {
                if (\auth()->user()->role === 'admin') {
                    return redirect('/admin');
                }

                if (\auth()->user()->role === 'uki') {
                    if (Session::get('redirect')) {
                        return redirect(Session::get('redirect'));
                    }
                    return redirect('/admin-uki');
                }

                if (\auth()->user()->role === 'satker') {
                    if (Session::get('redirect')) {
                        return redirect(Session::get('redirect'));
                    }
                    return redirect()->route('dashboard.satker');
                }

                if (\auth()->user()->role === 'ppk') {
                    if (Session::get('redirect')) {
                        return redirect(Session::get('redirect'));
                    }
                    return redirect()->route('dashboard.ppk');
                }
            }
            return redirect()->back()->with('failed', 'Periksa Kembali Username dan Password Anda');
        }
        return view('admin.auth.login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}

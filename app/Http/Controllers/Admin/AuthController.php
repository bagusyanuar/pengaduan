<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use Illuminate\Support\Facades\Auth;

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
                    return redirect('/admin-uki');
                }
            }
            return redirect()->back()->with('failed', 'Periksa Kembali Username dan Password Anda');
        }
        return view('admin.auth.login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}

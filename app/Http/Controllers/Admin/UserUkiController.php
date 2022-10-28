<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\User;
use App\Models\UserUki;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserUkiController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = User::with('uki')->where('role', '=', 'uki')->get();
        return view('admin.users.uki.index')->with(['data' => $data]);
    }

    public function add()
    {
        if ($this->request->method() === 'POST') {
            DB::beginTransaction();
            try {
                $user_data = [
                    'username' => $this->postField('username'),
                    'email' => $this->postField('email'),
                    'password' => Hash::make($this->postField('password')),
                    'role' => 'uki'
                ];
                $user = User::create($user_data);
                $uki_data = [
                    'user_id' => $user->id,
                    'name' => $this->postField('name'),
                    'phone' => $this->postField('phone'),
                ];
                UserUki::create($uki_data);
                DB::commit();
                return redirect()->back()->with('success', 'Berhasil Menambahkan Data...');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('failed', 'Terjadi Kesalahan Server...');
            }
        }
        return view('admin.users.uki.add');
    }

    public function patch($id)
    {
        $data = User::with('uki')->findOrfail($id);
        if ($this->request->method() === 'POST') {
            DB::beginTransaction();
            try {
                $data->update([
                    'username' => $this->postField('username'),
                    'email' => $this->postField('email'),
                ]);

                $data->uki()->update([
                    'name' => $this->postField('name'),
                    'phone' => $this->postField('phone'),
                ]);
                DB::commit();
                return redirect()->route('users.uki.index')->with('success', 'Berhasil Merubah Data...');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('failed', 'Terjadi Kesalahan Server...');
            }
        }
        return view('admin.users.uki.edit')->with(['data' => $data]);
    }

    public function change_password($id)
    {
        $data = User::whereJsonContains('roles', 'admin')->where('id', '=', $id)->firstOrFail();
        if ($this->request->method() === 'POST') {
            try {
                $data->update([
                    'password' => Hash::make($this->postField('password'))
                ]);
                return redirect('/admin/admin')->with('success', 'Berhasil Mengganti Password...');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'Terjadi Kesalahan Server...');
            }
        }
        return view('admin.admin.change-password')->with(['data' => $data]);
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            UserUki::where('user_id', '=', $id)->delete();
            User::destroy($id);
            DB::commit();
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->jsonResponse('Terjadi Kesalahan Server...', 500);
        }
    }
}

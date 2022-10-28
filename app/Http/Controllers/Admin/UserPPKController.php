<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\PPK;
use App\Models\SatuanKerja;
use App\Models\User;
use App\Models\UserPPK;
use App\Models\UserSatuanKerja;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserPPKController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = User::with('ppk.ppk')->where('role', '=', 'ppk')->get();
        return view('admin.users.ppk.index')->with(['data' => $data]);
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
                    'role' => 'ppk'
                ];
                $user = User::create($user_data);
                $ppk_data = [
                    'user_id' => $user->id,
                    'ppk_id' => $this->postField('ppk'),
                    'name' => $this->postField('name'),
                    'phone' => $this->postField('phone'),
                ];
                UserPPK::create($ppk_data);
                DB::commit();
                return redirect()->back()->with('success', 'Berhasil Menambahkan Data...');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('failed', 'Terjadi Kesalahan Server...');
            }
        }
        $ppk = PPK::all();
        return view('admin.users.ppk.add')->with(['ppk' => $ppk]);
    }

    public function patch($id)
    {
        $data = User::with('ppk')->findOrfail($id);
        if ($this->request->method() === 'POST') {
            DB::beginTransaction();
            try {
                $data->update([
                    'username' => $this->postField('username'),
                    'email' => $this->postField('email'),
                ]);

                $data->ppk()->update([
                    'name' => $this->postField('name'),
                    'phone' => $this->postField('phone'),
                    'ppk_id' => $this->postField('ppk'),
                ]);
                DB::commit();
                return redirect()->route('users.ppk.index')->with('success', 'Berhasil Merubah Data...');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('failed', 'Terjadi Kesalahan Server...');
            }
        }
        $ppk = PPK::all();
        return view('admin.users.ppk.edit')->with(['data' => $data, 'ppk' => $ppk]);
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
            UserPPK::where('user_id', '=', $id)->delete();
            User::destroy($id);
            DB::commit();
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->jsonResponse('Terjadi Kesalahan Server...', 500);
        }
    }
}

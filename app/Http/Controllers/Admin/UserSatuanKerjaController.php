<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\SatuanKerja;
use App\Models\User;
use App\Models\UserSatuanKerja;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSatuanKerjaController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = User::with('satker.unit')->where('role', '=', 'satker')->get();
        return view('admin.users.satker.index')->with(['data' => $data]);
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
                    'role' => 'satker'
                ];
                $user = User::create($user_data);
                $satker_data = [
                    'user_id' => $user->id,
                    'satker_id' => $this->postField('unit'),
                    'name' => $this->postField('name'),
                    'phone' => $this->postField('phone'),
                ];
                UserSatuanKerja::create($satker_data);
                DB::commit();
                return redirect()->back()->with('success', 'Berhasil Menambahkan Data...');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('failed', 'Terjadi Kesalahan Server...');
            }
        }
        $unit = SatuanKerja::all();
        return view('admin.users.satker.add')->with(['unit' => $unit]);
    }

    public function patch($id)
    {
        $data = User::with('satker')->findOrfail($id);
        if ($this->request->method() === 'POST') {
            DB::beginTransaction();
            try {
                $data->update([
                    'username' => $this->postField('username'),
                    'email' => $this->postField('email'),
                ]);

                $data->satker()->update([
                    'name' => $this->postField('name'),
                    'phone' => $this->postField('phone'),
                    'satker_id' => $this->postField('unit'),
                ]);
                DB::commit();
                return redirect()->route('users.satker.index')->with('success', 'Berhasil Merubah Data...');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('failed', 'Terjadi Kesalahan Server...');
            }
        }
        $unit = SatuanKerja::all();
        return view('admin.users.satker.edit')->with(['data' => $data, 'unit' => $unit]);
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
            UserSatuanKerja::where('user_id', '=', $id)->delete();
            User::destroy($id);
            DB::commit();
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->jsonResponse('Terjadi Kesalahan Server...', 500);
        }
    }
}

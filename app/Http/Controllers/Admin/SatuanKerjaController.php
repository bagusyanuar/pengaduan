<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\SatuanKerja;

class SatuanKerjaController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = SatuanKerja::all();
        return view('admin.satuan-kerja.index')->with(['data' => $data]);
    }

    public function add()
    {
        if ($this->request->method() === 'POST') {
            try {
                $data = [
                    'name' => $this->postField('name')
                ];
                SatuanKerja::create($data);
                return redirect()->back()->with('success', 'Berhasil Menambahkan Data...');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'Terjadi Kesalahan Server...');
            }
        }
        return view('admin.satuan-kerja.add');
    }

    public function patch($id)
    {
        $data = SatuanKerja::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $request = [
                    'name' => $this->postField('name')
                ];
                $data->update($request);
                return redirect()->route('unit.index')->with('success', 'Berhasil Merubah Data...');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'Terjadi Kesalahan Server...');
            }
        }
        return view('admin.satuan-kerja.edit')->with(['data' => $data]);
    }

    public function destroy($id)
    {
        try {
            SatuanKerja::destroy($id);
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('Terjadi Kesalahan Server...', 500);
        }
    }
}

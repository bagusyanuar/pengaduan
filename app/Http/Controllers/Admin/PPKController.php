<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\PPK;
use App\Models\SatuanKerja;

class PPKController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = PPK::with('unit')->get();
        return view('admin.ppk.index')->with(['data' => $data]);
    }

    public function add()
    {
        if ($this->request->method() === 'POST') {
            try {
                $data = [
                    'satker_id' => $this->postField('unit'),
                    'name' => $this->postField('name'),
                ];
                PPK::create($data);
                return redirect()->back()->with('success', 'Berhasil Menambahkan Data...');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'Terjadi Kesalahan Server...');
            }
        }
        $unit = SatuanKerja::all();
        return view('admin.ppk.add')->with(['unit' => $unit]);
    }

    public function patch($id)
    {
        $data = PPK::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $request = [
                    'satker_id' => $this->postField('unit'),
                    'name' => $this->postField('name'),
                ];
                $data->update($request);
                return redirect()->route('ppk.index')->with('success', 'Berhasil Merubah Data...');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'Terjadi Kesalahan Server...');
            }
        }
        $unit = SatuanKerja::all();
        return view('admin.ppk.edit')->with(['data' => $data, 'unit' => $unit]);
    }

    public function destroy($id)
    {
        try {
            PPK::destroy($id);
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('Terjadi Kesalahan Server...', 500);
        }
    }
}

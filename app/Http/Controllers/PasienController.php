<?php

namespace App\Http\Controllers;

use App\Models\Gender;
use App\Models\Pasien;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pasiens.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $datas['genders'] = Gender::orderBy('id')->get();

        return view('pasiens.create', $datas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'gender_id' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
        ]);

        $data = $request->except(['_token', '_method']);

        $stored = Pasien::create($data);

        if (!$stored) {
            return redirect()->back()->with('error', 'Pasien gagal ditambah');
        }

        return redirect('/pasiens')->with('success', 'Pasien berhasil ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $datas['pasien'] = Pasien::find($id);
        $datas['genders'] = Gender::orderBy('id')->get();

        return view('pasiens.edit', $datas);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'gender_id' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
        ]);

        $data = $request->except(['_token', '_method']);

        $updated = Pasien::find($id)->update($data);

        if (!$updated) {
            return redirect()->back()->with('error', 'Pasien gagal diubah');
        }

        return redirect('/pasiens')->with('success', 'Pasien berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = Pasien::find($id)->delete();

        if (!$deleted) {
            return redirect()->back()->with('error', 'Pasien gagal dihapus');
        }

        return redirect()->back()->with('success', 'Pasien berhasil dihapus');
    }

    public function pasiensDatatable()
    {
        $pasiens = Pasien::orderBy('id')->get();

        foreach ($pasiens as $pasien) {
            $pasien['gender_string'] = $pasien->gender->nama;
            $pasien['ttl'] = $pasien->tempat_lahir . '/' . $pasien->tanggal_lahir;
        }

        return datatables()->of($pasiens)->addIndexColumn()->toJson();
    }
}

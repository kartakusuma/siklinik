<?php

namespace App\Http\Controllers;

use App\Models\Bangsal;
use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\Ruang;
use App\Models\User;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RekamMedisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('rekam_medis.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $datas['pasiens'] = Pasien::orderBy('id')->get();
        $datas['perawats'] = User::where('role_id', 20);
        if (Auth::user()->role_id == 20) {
            $datas['perawats'] = $datas['perawats']->where('id', Auth::user()->id);
        }
        $datas['perawats'] = $datas['perawats']->orderBy('id')->get();
        $datas['dokters'] = User::where('role_id', 10);
        if (Auth::user()->role_id == 10) {
            $datas['dokters'] = $datas['dokters']->where('id', Auth::user()->id);
        }
        $datas['dokters'] = $datas['dokters']->orderBy('id')->get();
        $datas['bangsals'] = Bangsal::orderBy('id')->get();

        return view('rekam_medis.create', $datas);
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
            'pasien_id' => 'required',
            'perawat_id' => 'required',
            'dokter_id' => 'required',
            'objektif' => 'required',
            'subjektif' => 'required',
            'kesadaran' => 'required',
            'tingkat_nyeri' => 'required'
        ]);

        $data = $request->except(['_token', '_method']);

        $stored = RekamMedis::create($data);

        if (!$stored) {
            return redirect()->back()->with('error', 'Rekam medis gagal disimpan');
        }

        return redirect('/rekam-medis')->with('success', 'Rekam medis berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $datas['rekamMedis'] = RekamMedis::find($id);

        $datas['rekamMedis']->tanggal = $datas['rekamMedis']->created_at->format('Y-m-d');
        $datas['rekamMedis']->jam = $datas['rekamMedis']->created_at->format('H:i');

        return view('rekam_medis.show', $datas);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $datas['rekamMedis'] = RekamMedis::find($id);
        $datas['pasiens'] = Pasien::orderBy('id')->get();
        $datas['perawats'] = User::where('role_id', 20);
        if (Auth::user()->role_id == 20) {
            $datas['perawats'] = $datas['perawats']->where('id', Auth::user()->id);
        }
        $datas['perawats'] = $datas['perawats']->orderBy('id')->get();
        $datas['dokters'] = User::where('role_id', 10);
        if (Auth::user()->role_id == 10) {
            $datas['dokters'] = $datas['dokters']->where('id', Auth::user()->id);
        }
        $datas['dokters'] = $datas['dokters']->orderBy('id')->get();
        $datas['bangsals'] = Bangsal::orderBy('id')->get();
        if ($datas['rekamMedis']->ruang_id) {
            $datas['ruangs'] = Ruang::where('bangsal_id', $datas['rekamMedis']->ruang->bangsal_id)->get();
        }

        return view("rekam_medis.edit", $datas);
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
            'pasien_id' => 'required',
            'perawat_id' => 'required',
            'dokter_id' => 'required',
            'objektif' => 'required',
            'subjektif' => 'required',
            'kesadaran' => 'required',
            'tingkat_nyeri' => 'required'
        ]);

        $data = $request->except(['_token', '_method']);

        $updated = RekamMedis::find($id)->update($data);

        if (!$updated) {
            return redirect()->back()->with('error', 'Rekam medis gagal diubah');
        }

        return redirect('/rekam-medis')->with('success', 'Rekam medis berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = RekamMedis::find($id)->delete();

        if (!$deleted) {
            return redirect()->back()->with('error', 'Rekam medis gagal dihapus');
        }

        return redirect('/rekam-medis')->with('success', 'Rekam medis berhasil dihapus');
    }

    public function rekamMedisDatatable()
    {
        if (Auth::user()->role_id == 10) {
            $rekamMedises = RekamMedis::where('dokter_id', Auth::user()->id)->orderBy('id', 'desc')->get();
        } else if (Auth::user()->role_id == 20) {
            $rekamMedises = RekamMedis::where('perawat_id', Auth::user()->id)->orderBy('id', 'desc')->get();
        } else {
            $rekamMedises = RekamMedis::orderBy('id', 'desc')->get();
        }

        foreach ($rekamMedises as $rekamMedis) {
            if ($rekamMedis->ruang_id) {
                $rekamMedis['bangsal_string'] = $rekamMedis->ruang->bangsal->nama;
                $rekamMedis['ruang_string'] = $rekamMedis->ruang->nomor;
            } else {
                $rekamMedis['bangsal_string'] = '-';
                $rekamMedis['ruang_string'] = '-';
            }

            $rekamMedis['pasien_string'] = $rekamMedis->pasien->nama;
            $rekamMedis['tanggal'] = $rekamMedis->created_at->format('Y-m-d');
            $rekamMedis['jam'] = $rekamMedis->created_at->format('H:i');
        }

        return datatables()->of($rekamMedises)->addIndexColumn()->toJson();
    }
}

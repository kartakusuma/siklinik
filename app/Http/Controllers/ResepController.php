<?php

namespace App\Http\Controllers;

use App\Models\Bangsal;
use App\Models\Pasien;
use App\Models\Resep;
use App\Models\Ruang;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Calculation\Token\Stack;

class ResepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('reseps.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $datas['pasiens'] = Pasien::orderBy('id')->get();
        $datas['dokters'] = User::where('role_id', 10)->orderBy('id')->get();
        $datas['bangsals'] = Bangsal::orderBy('id')->get();

        return view('reseps.create', $datas);
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
            'dokter_id' => 'required',
            'catatan_resep' => 'required',
        ]);

        $data = $request->except(['_token', '_method']);

        $resep = '';
        foreach ($data['catatan_resep'] as $catatan_resep) {
            $resep .= $catatan_resep . ' ||';
        }

        $data['catatan_resep'] = $resep;

        $stored = Resep::create($data);

        if (!$stored) {
            return redirect()->back()->with('error', 'Resep gagal dibuat');
        }

        return redirect('/reseps')->with('success', 'Resep berhasil dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $datas['resep'] = Resep::find($id);
        $datas['statuses'] = Status::orderBy('id')->get();

        $catatan_resep = '<ol>';
        $catatans = explode(' ||', $datas['resep']->catatan_resep);

        foreach ($catatans as $catatan) {
            if ($catatan) {
                $catatan_resep .= '<li>'.$catatan.'</li>';
            }
        }
        $catatan_resep .= '</ol>';
        $datas['resep']->catatan_resep = $catatan_resep;

        $datas['resep']->tanggal = $datas['resep']->created_at->format('Y-m-d');

        return view('reseps.show', $datas);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $datas['resep'] = Resep::find($id);
        $datas['pasiens'] = Pasien::orderBy('id')->get();
        $datas['dokters'] = User::where('role_id', 10)->orderBy('id')->get();
        $datas['bangsals'] = Bangsal::orderBy('id')->get();
        if ($datas['resep']->ruang_id) {
            $datas['ruangs'] = Ruang::where('bangsal_id', $datas['resep']->ruang->bangsal_id)->get();
        }

        $catatan_resep = explode(' ||', $datas['resep']->catatan_resep);
        $datas['resep']->catatan_resep = $catatan_resep;

        return view('reseps.edit', $datas);
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
            'dokter_id' => 'required',
            'catatan_resep' => 'required',
        ]);

        $data = $request->except(['_token', '_method']);

        $resep = '';
        foreach ($data['catatan_resep'] as $catatan_resep) {
            $resep .= $catatan_resep . ' ||';
        }

        $data['catatan_resep'] = $resep;

        $updated = Resep::find($id)->update($data);

        if (!$updated) {
            return redirect()->back()->with('error', 'Resep gagal diubah');
        }

        return redirect('/reseps')->with('success', 'Resep berhasil diubah');
    }

    public function updateResepStatus(Request $request, $id)
    {
        $data = $request->except(['_token', '_method']);
        $updated = Resep::find($id)->update($data);

        if (!$updated) {
            return redirect()->back()->with('error', 'Status resep gagal diubah');
        }

        return redirect('/reseps')->with('success', 'Status resep berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = Resep::find($id)->delete();

        if (!$deleted) {
            return redirect()->back()->with('error', 'Resep gagal dihapus');
        }

        return redirect('/reseps')->with('success', 'Resep berhasil dihapus');
    }

    public function resepsDatatable()
    {
        if (Auth::user()->role_id == 10) {
            $reseps = Resep::where('dokter_id', Auth::user()->id)->orderBy('id', 'desc')->get();
        } else {
            $reseps = Resep::orderBy('id', 'desc')->get();
        }

        foreach ($reseps as $resep) {
            if ($resep->ruang_id) {
                $resep['bangsal_string'] = $resep->ruang->bangsal->nama;
                $resep['ruang_string'] = $resep->ruang->nomor;
            } else {
                $resep['bangsal_string'] = '-';
                $resep['ruang_string'] = '-';
            }
            $resep['pasien_string'] = $resep->pasien->nama;
            $resep['dokter_string'] = $resep->dokter->nama;
            $resep['status_string'] = $resep->status->nama;
            $resep['tanggal'] = $resep->created_at->format('Y-m-d');
        }

        return datatables()->of($reseps)->addIndexColumn()->toJson();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Bangsal;
use App\Models\Ruang;
use Illuminate\Http\Request;

class RuangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas['bangsals'] = Bangsal::orderBy('id')->get();

        return view('ruangs.index', $datas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'bangsal_id' => 'required',
            'nomor' => 'required'
        ]);

        $data = $request->except(['_token', '_method']);

        $stored = Ruang::create($data);

        if (!$stored) {
            return redirect()->back()->with('error', 'Ruang gagal ditambah');
        }

        return redirect('/ruangs')->with('success', 'Ruang berhasil ditambah');
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
        //
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
            'bangsal_id' => 'required',
            'nomor' => 'required'
        ]);

        $data = $request->except(['_token', '_method']);

        $updated = Ruang::find($id)->update($data);

        if (!$updated) {
            return redirect()->back()->with('error', 'Ruang gagal diubah');
        }

        return redirect('/ruangs')->with('success', 'Ruang berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = Ruang::find($id)->delete();

        if (!$deleted) {
            return redirect()->back()->with('error', 'Ruang gagal dihapus');
        }

        return redirect('/ruangs')->with('success', 'Ruang berhasil dihapus');
    }

    public function ruangsDatatable()
    {
        $ruangs = Ruang::orderBy('id')->get();

        foreach ($ruangs as $ruang) {
            $ruang['bangsal_string'] = $ruang->bangsal->nama;
        }

        return datatables()->of($ruangs)->addIndexColumn()->toJson();
    }

    public function ruangsOptions(Request $request)
    {
        $html = '<option value="">-- Pilih Ruang --</option>';

        if ($request->bangsal_id) {
            $ruangs = Ruang::where('bangsal_id', $request->bangsal_id)->get();

            foreach ($ruangs as $ruang) {
                $html .= '<option value="'.$ruang->id.'">'.$ruang->nomor.'</option>';
            }
        }

        return $html;
    }
}

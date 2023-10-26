<?php

namespace App\Http\Controllers;

use App\Models\Bangsal;
use App\Models\User;
use Illuminate\Http\Request;

class BangsalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas['perawats'] = User::where('role_id', 20)->orderBy('id')->get();

        return view('bangsals.index', $datas);
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
            'nama' => 'required'
        ]);

        $data = $request->except(['_token', '_method']);

        $stored = Bangsal::create($data);

        if (!$stored) {
            return redirect()->back()->with('error', 'Bangsal gagal ditambah');
        }

        return redirect('/bangsals')->with('success', 'Bangsal berhasil ditambah');
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
            'nama' => 'required'
        ]);

        $data = $request->except(['_token', '_method']);

        $updated = Bangsal::find($id)->update($data);

        if (!$updated) {
            return redirect()->back()->with('error', 'Bangsal gagal diubah');
        }

        return redirect('/bangsals')->with('success', 'Bangsal berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = Bangsal::find($id)->delete();

        if (!$deleted) {
            return redirect()->back()->with('error', 'Bangsal gagal dihapus');
        }

        return redirect('/bangsals')->with('success', 'Bangsal berhasil dihapus');
    }

    public function bangsalsDatatable()
    {
        $bangsals = Bangsal::orderBy('id')->get();

        return datatables()->of($bangsals)->addIndexColumn()->toJson();
    }
}

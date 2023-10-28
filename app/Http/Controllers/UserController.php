<?php

namespace App\Http\Controllers;

use App\Models\Bangsal;
use App\Models\Gender;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $datas['genders'] = Gender::orderBy('id')->get();
        $datas['roles'] = Role::orderBy('id')->get();
        // $datas['bangsals'] = Bangsal::orderBy('id')->get();

        return view('users.create', $datas);
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
            'username' => 'required',
            'password' => 'required',
            'role_id' => 'required'
        ]);

        $data = $request->except([]);

        if (User::where('username', $data['username'])->count() > 0) {
            return redirect()->back()->with('error', 'Username sudah digunakan');
        }

        $data['password'] = bcrypt($data['password']);

        $stored = User::create($data);
        if (!$stored) {
            return redirect()->back()->with('error', 'User gagal ditambah');
        }

        return redirect('/users')->with('success', 'User berhasil ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $datas['user'] = User::find($id);
        $datas['user']->role_string = $datas['user']->role->nama;
        $datas['user']->gender_string = '';
        if ($datas['user']->gender_id) {
            $datas['user']->gender_string = $datas['user']->gender->nama;
        }

        return view('users.show', $datas);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $datas['user'] = User::find($id);
        $datas['genders'] = Gender::orderBy('id')->get();
        $datas['roles'] = Role::orderBy('id')->get();

        return view('users.edit', $datas);
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
            'username' => 'required',
            'role_id' => 'required'
        ]);

        $data = $request->except(['password']);

        $user = User::find($id);

        if ((User::where('username', $data['username'])->count() > 1) && ($user->username != $data['username'])) {
            return redirect()->back()->with('error', 'Username sudah digunakan');
        }

        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        $updated = $user->update($data);
        if (!$updated) {
            return redirect()->back()->with('error', 'User gagal diubah');
        }

        return redirect('/users')->with('success', 'User berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = User::find($id)->delete();

        if (!$deleted) {
            return redirect()->back()->with('error', 'User gagal dihapus');
        }

        return redirect('/users')->with('success', 'User berhasil dihapus');
    }

    public function usersDatatable()
    {
        $users = User::orderBy('id')->get();

        foreach ($users as $user) {
            $user['role_string'] = $user->role->nama;
        }

        return datatables()->of($users)->addIndexColumn()->toJson();
    }
}

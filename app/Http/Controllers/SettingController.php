<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Karyawan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $role = Auth::user()->role;
        if ($role == 5) {
            
            $output = [

            ];
            return view('admin.datamaster.user.dashboardAdmin', compact('output',));
        } else {

            return redirect()->back();
        }
    }

    public function settinguser(Request $request)
    {
        $role = Auth::user()->role;
        if ($role == 5 || $role == 1 || $role == 2) {

            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $user = User::all();

            return view('admin.datamaster.user.settingUser', compact('user','row'));
        } else {

            return redirect()->back();
        }
    }

    public function editUser(Request $request, $id)
    {
        $user = User::all();

        User::where('id', $id)->update(
            [
                'role' => $request->post('role'),
                'password' => Hash::make($request['password']),

            ]
        );

        return back()->with("status", "Password changed successfully!");
    }
    public function hapususer($id)
    {
        $user = User::find($id);

        $user->delete();

        return redirect()->back();
        // return redirect('karyawan'); 
    }

    public function settingrole(Request $request)
    {
        $role = Auth::user()->role;
        if ($role == 5 || $role == 1) 
        {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $user = Role::all();

            return view('admin.datamaster.role.index', compact('user','row'));
        } else {

            return redirect()->back();
        }
    }
    public function storerole(Request $request)
    {
        $role = Auth::user()->role;
        if ($role == 5 || $role == 1) 
        {

            $user = new Role;
            $user->role = $request->role;
            $user->save();

            return redirect()->back();
        } else {

            return redirect()->back();
        }
    }
    public function editrole(Request $request, $id)
    {

        Role::where('id', $id)->update(
            [
                'role' => $request->post('role'),

            ]
        );

        return back()->with("status", "Role changed successfully!");
    }
    public function hapusrole($id)
    {
        $role = Role::find($id);

        $role->delete();

        return redirect()->back();
        // return redirect('karyawan'); 
    }
}

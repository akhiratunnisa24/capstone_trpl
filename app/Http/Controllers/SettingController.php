<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Partner;

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
        if (($role == 5)||$role == 7) {

            $output = [

            ];
            return view('admin.datamaster.user.dashboardAdmin', compact('output',));
        } else {

            return redirect()->back()->with('error','Anda tidak memiliki hak akses');
        }
    }

    public function settinguser(Request $request)
    {
        $role = Auth::user()->role;
        if ($role == 1 || $role == 2) {

            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $user = User::where('partner',Auth::user()->partner)->get();
            $partner = Partner::all();

            return view('admin.datamaster.user.settingUser', compact('user','row','partner','role'));
        }elseif($role == 5 ||$role == 7)
        {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $user = User::all();
            $partner = Partner::all();
            if($role == 7){
                $user = User::where('partner',Auth::user()->partner)->get();
            }

            return view('admin.datamaster.user.settingUser', compact('user','row','partner','role'));
        }
        else {

            return redirect()->back()->with('error','Anda tidak memiliki hak akses');
        }
    }

    public function editUser(Request $request, $id)
    {
        $role = Auth::user()->role;

        if ($role == 5 || $role == 7)
        {
            $user = User::all();
            User::where('id', $id)->update(
                [
                    'partner' => $request->post('partneradmin'),
                    'role' => $request->post('role'),
                    'password' => Hash::make($request['password']),

                ]
            );
            return redirect('settinguser')->with('success', 'Password changed successfully!');
        }elseif($role == 1 || $role == 2 || $role == 7)
        {
            $user = User::find($id);

            $data = User::where('id', $id)->update(
                [
                    'partner'=> $user->partner,
                    'role' => $request->post('role'),
                    'password' => Hash::make($request['password']),

                ]
            );

            return redirect('settinguser')->with('success', 'Password changed successfully!');
        }
        else {

            return redirect()->back()->with('error','Anda tidak memiliki hak akses');
        }
    }

    public function hapususer($id)
    {
        $user = User::find($id);

        $user->delete();

        return redirect()->back()->with('success','Data User berhasil dihapus');
        // return redirect('karyawan');
    }

    public function settingrole(Request $request)
    {
        $role = Auth::user()->role;
        if ($role == 5 || $role == 1 || $role == 7)
        {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $user = Role::all();

            return view('admin.datamaster.role.index', compact('user','row'));
        } else {

            return redirect()->back()->with('error','Anda tidak memiliki hak akses');
        }
    }
    public function storerole(Request $request)
    {
        $role = Auth::user()->role;
        if ($role == 5 || $role == 1 || $role == 7)
        {

            $user = new Role;
            $user->role = $request->role;
            $user->save();

            return redirect()->back()->with('success','Role berhasil ditambahkan');
        } else {

            return redirect()->back()->with('error','Anda tidak memiliki hak akses');
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

        return redirect()->back()->with('success','Role berhasil dihapus');
        // return redirect('karyawan');
    }

    public function setPartner($id)
    {
        if (Auth::user()->role == 7) {
            $user = User::findOrFail(Auth::user()->id);
            $user->partner = $id;
            $user->save();

            return redirect()->back()->with('success', 'Partner berhasil diupdate.');
        } else {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk melakukan aksi ini.');
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Role;


class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $role = Auth::user()->role;
        if ($role == 0) {
            
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
        if ($role == 0 || $role == 1) {

            $user = User::all();

            return view('admin.datamaster.user.settingUser', compact('user',));
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

    public function settingrole(Request $request)
    {
        $role = Auth::user()->role;
        if ($role == 0 || $role == 1) {

            $user = Role::all();

            return view('admin.datamaster.role.index', compact('user',));
        } else {

            return redirect()->back();
        }
    }
}

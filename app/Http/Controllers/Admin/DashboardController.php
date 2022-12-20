<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function dashboard(Request $req)
    {
        $contacts = ghl_api_call('contacts/');
        session()->put('ghlcontacts', $contacts);
        if (isset($contacts->status) && $contacts->status == 'error') {
            return redirect()->route('setting.index')->with('error', $contacts['message'] ?? '');
        }
        if (auth()->user()->role == 0) {
            return redirect()->route('user.list');
        }
        return view('admin.dashboard', get_defined_vars());
    }

    public function profile()
    {
        $user = Auth::user();
        return view('admin.profile.userprofile', get_defined_vars());
    }
    public function general(Request $req)
    {
        $user = Auth::user();
        $req->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'name' => 'required',
        ]);

        $user->name = $req->name;
        $user->email = $req->email;
        $user->location = $req->location;
        if ($req->image) {
            $user->image = uploadFile($req->image, 'uploads/profile', $req->name.'-'.time().'-'.$user->id);
        }
        $user->save();
        return redirect()->back()->with('success', 'Profile updated successfully');
    }

    public function password(Request $req)
    {
        $user = Auth::user();
        $req->validate([
            'current_password' => 'required|password',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password'
        ]);

        $user->password = bcrypt($req->password);
        $user->save();

        return redirect()->back()->with('success', 'Password updated Successfully!');
    }
}

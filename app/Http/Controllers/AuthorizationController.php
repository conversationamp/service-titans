<?php

namespace App\Http\Controllers;

use App\Models\AccountPermission;
use Illuminate\Http\Request;

class AuthorizationController extends Controller
{
    public function authorization()
    {
        return view('admin.authorization.index');
    }

    public function permissions()
    {
        $permissions = [];
        dd($permissions);
        return view('admin.settings.general', get_defined_vars());
    }

    public function savePermissions(Request $request)
    {
        $user = auth()->user();
        $product = AccountPermission::where('company_id' , $user->id)->first() ?? new AccountPermission();
        $permissions = $request->permissions;
        if (is_array($permissions) && count($permissions) > 0) {
            $obj = new \stdClass;
            foreach ($permissions as $key => $permission) {
                $obj->$key = $permission;
            }
        }
        //  dd();
        $product->permissions = $obj->permissions;
        $product->company_id = $user->id;
        $product->save();
        return response()->json('Account Permission saved successfully');
    }

    public function goHighLevelCallback(Request $request)
    {
        return ghl_token($request);
    }

    public function serviceTitan(Request $request){
        $abc = connectToSeviceTitan();
        if($abc){
            return redirect()->back()->with('success', 'Service Titan Connected');
        }else{
            return redirect()->back()->with('error', 'Service Titan Not Connected');
        }
    }
}

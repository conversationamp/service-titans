<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {

        return view('admin.auth.register');
    }
   public function registerprocess(){
        return view('admin.auth.registerprocess');
     }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:100'],
            'location_api' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'password' => ['required', 'min:8'],
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->location = $request->location;
        $user->password = bcrypt($request->password);
        $user->role = company_role();
        $user->is_active=0;
        //$user->email_verified_at='';
        $user->ghl_api_key = $request->location_api;
        $user->save();
        $usera = main_location();
        if($usera){
            add_session('ghl_api_key',$usera->ghl_api_key);
            // event(new Registered($user));
            sendDatatoghl($request,'account_requested');
        }else{
          //  Auth::login($user);

        //return redirect(RouteServiceProvider::HOME);
        }
        return redirect()->route('registerprocess');
        
    }
}

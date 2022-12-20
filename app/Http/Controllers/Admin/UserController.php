<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Opportuninty;
use App\Models\User;
use DataTables;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $route = 'user'; // route namespace
    protected $parent = 'Users'; //on list this will be title
    protected $model = \App\Models\User::class;
    protected $titles = ['add' => 'Add User', 'edit' => 'Edit User'];
    public function __construct()
    {
        view()->share('route', $this->route);
        view()->share('parent', $this->parent);
    }
    function list(Request $req)
    {
        if ($req->ajax()) {
            $query = User::where('role', company_role())->orderBy('id', 'DESC');
            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->editColumn('status', function ($row) {
                    return get_status($row->is_active);
                })
                //display only first four and last four with * in between ghl_api_key
                ->editColumn('ghl_api_key', function ($row) {
                    $len = strlen($row->ghl_api_key);
                    return substr($row->ghl_api_key, 0, 4) . str_repeat('*', $len - $len + 8) . substr($row->ghl_api_key, -4);
                })
                ->addColumn('action', function ($row) {
                    $html = getAction();
                    $html .= change_status($row->id, $row->is_active, $this->route);
                    $html .= show_edit_del($row->id, $this->route, ['edit' => ['status' => true], 'delete' => ['status' => true]]);
                    return $html;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view(admin_prefix() . $this->route . '.list', get_defined_vars());
    }

    public function add()
    {
        $title = $this->titles['add'];
        return view(admin_prefix() . $this->route . '.add', get_defined_vars());
    }

    public function edit($id = null)
    {
        $data = getUser($id);
        if (!$data) {
            return redirect()->back();
        }
        $title = $data->name;
        return view(admin_prefix() . $this->route . '.edit', get_defined_vars());
    }

    public function save(Request $req, $id = null)
    {
        $req->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            // 'password'   => 'required',
        ]);
        if (auth()->user()->role == admin_role()) {
            $req->validate([
                'location' => 'required',
            ]);
        }
        if (is_null($id)) {
            $req->validate([
                'password' => 'required',
            ]);
        }
        if (is_null($id)) {
            $user = new User;
            $user->role = company_role(true);
            $msg = "Record Added Successfully!";
        } else {
            $user = getUser($id);
            if (!$user) {
                return redirect()->back()->with('error', 'Not Found');
            }
            $msg = "Record Edited Successfully!";
        }
        $user->name = $req->name;
        if ($user->email != main_location(true)) {
            $user->email = $req->email;
        }

        $user->ghl_api_key = $req->api_key;
        $user->added_by = login_id();
        if (!is_null($req->password)) {
            $user->password = bcrypt($req->password);
        }
        $user->location = $req->location;
        $user->save();
        if ($req->has('save_add')) {
            return redirect()->route($this->route . '.list')->with('success', $msg);
        }
        return redirect()->back()->with('success', $msg);
    }

    public function delete($id = null)
    {

        $user = getUser($id);
        if (!$user) {
            return redirect()->back();
        }
        if ($user->email == main_location(true)) {
            return redirect()->back()->with('error', 'Unable to delete Main location');
        }
        $user->delete();
        return redirect()->back()->with('success', 'Record Delete Successfully!');
    }

    public function isActive($id)
    {
        $msg = messages('status');

        $user = getUser($id);
        if (!$user) {
            return redirect()->back();
        }
        if ($user->is_active == 1) {
            $user->is_active = 0;
        } elseif ($user->is_active == 0) {
            if (auth()->user()->role == admin_role()) {
                $usera  = main_location();
                if ($usera) {
                    add_session('ghl_api_key', $usera->ghl_api_key);
                    $msg .= ' and tag account_activated added';
                    sendDatatoghl($user, 'account_activated');
                }
            }
            $user->is_active = 1;
        }
        $user->save();
        return back()->with('success', $msg);
    }
}

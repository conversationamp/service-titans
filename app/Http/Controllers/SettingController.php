<?php

namespace App\Http\Controllers;

use App\Models\AccountPermission;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function authSetting()
    {
        return view('admin.settings.index');
    }

    public function crmSetting()
    {
        $id = auth()->user()->id;
        $p = AccountPermission::where('company_id', $id)->first();
        if ($p) {
            $permissions = json_decode($p->permissions);
        } else {
            $permissions = default_user_permissions();
            $permissions = $permissions->permissions;
        }

        $pipelines = ghl_api_call('opportunities/pipelines/');

        if (property_exists($pipelines, 'pipelines')) {
            $pipelines = $pipelines->pipelines;
        } else {
            $pipelines = [];
        }

        $calendars =  ghl_api_call('calendars/');
        if (property_exists($calendars, 'calendars')) {
            $calendars = $calendars->calendars;
        } else {
            $calendars = [];
        }

        return view('admin.settings.crm', get_defined_vars());
    }

    public function titanSetting()
    {

       
        $locations = curl_request('crm/v2/tenant/' . get_values_by_id('titan_tenant_id', Auth::id()) . '/locations', 'GET');
        if (property_exists($locations, 'data')) {
            $locations = $locations->data;
        } else {
            $locations = [];
        }

       

        $calendars = ghl_api_call('calendars/');
        if (property_exists($calendars, 'calendars')) {
            $calendars = $calendars->calendars;
        } else {
            $calendars = [];
        }

        
        return view('admin.settings.titan', get_defined_vars());
    }

    public function store(Request $request)
    {
        foreach ($request->except('_token') as $key => $value) {
            if ($request->has('its_locations')) {
                if ($key == 'titan_selected_location') {
                    //make one json

                    $value =  array_map(function ($t) {
                        return json_decode($t);
                    }, $value);
                    $value  = json_encode($value);
                }
            }

            if ($request->hasFile($key)) {
                $value = uploadFile($value, 'uploads/settings/logos', $key . '-' . time() . '-' . rand(11111, 99999));
            }
            save_custom_setting($key, $value);
        }
        return redirect()->back()->with('success', 'Setting Saved');
    }

    public function generalSetting()
    {
        return view('admin.settings.general');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\SyncSettings;
use Illuminate\Http\Request;
use DataTables;
use Validator;

class SyncSettingsController extends Controller
{
    protected $route = 'sync-settings'; // route namespace
    protected $parent = 'Sync'; //on list this will be title
    protected $model = \App\Models\SyncSettings::class;
    protected $titles = ['add' => 'Sync Settings', 'edit' => 'Edit Sync Settings'];


    public function __construct()
    {
        view()->share('route', $this->route);
        view()->share('parent', $this->parent);
    }


    function makeDefault($id, $index)
    {
        $model = $this->model;
        $all_duplicates = session('get_duplicates');
        $values = array_values($all_duplicates);
        $ar = $values[$index];
        unset($ar[$id]);
        $model::where('id', $id)->update(['is_default' => 1]);
        $model::whereIn('id', $ar)->update(['is_default' => 0]);
        return redirect()->back()->with('success', 'Default Sync Settings Updated');
    }

    function list(Request $req)
    {
        if ($req->ajax()) {
            $query = SyncSettings::where('location_id', login_id());
            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $html = getAction();
                    $html .= show_edit_del($row->id, $this->route, ['edit' => ['status' => true], 'delete' => ['status' => true]]);
                    return $html;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view(admin_prefix() . $this->route . '.list', get_defined_vars());
    }

    function getDefault(Request $req, $id = '')
    {

        if ($req->ajax()) {

            session(['get_duplicates' => []]);
            $query = SyncSettings::where('location_id', login_id());
            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->editColumn('position', function ($row) use ($id) {
                    return $this->check_for_index($row, $id);
                })
                ->editColumn('is_default', function ($row) use ($id) {
                    $st = $this->check_for_index($row, $id);

                    if ($row->is_default == 1) {
                        return '<span class="badge badge-success "> Default </span>';
                    } else {
                        // defaultMsg('.$row->id. ','.$st.')
                        return '<a href="' . route($this->route . '.save-default', [$id, $st]) . '" class="btn btn-gradient-primary btn-sm" onclick="event.preventDefault(); statusMsg(\'' . route($this->route . '.save-default', [$id, $st]) . '\')">Set as default</a>';
                    }
                })
                ->editColumn('action', function ($row) use ($id) {
                    $html = getAction();
                    $html .= show_edit_del($row->id, $this->route, ['edit' => ['status' => true], 'delete' => ['status' => true]]);
                    return $html;
                })
                ->rawColumns(['is_default', 'action'])
                ->make(true);
        }

        return view(admin_prefix() . $this->route . '.make-default', get_defined_vars());
    }

    function check_for_index($row, $index = 0)
    {
        $arr = $index == 0 ? ['pipeline_id', 'calendar_id', 'oppurtunity_status', 'pipeline_stage_id', 'appointment_status'] : ['titan_location_id', 'business_unit', 'job_type', 'slot', 'campaign', 'priority'];
        $all_duplicates = session('get_duplicates');
        $strc  =  '';
        foreach ($arr as $value) {
            $strc .= $row->$value;
        }
        if (!isset($all_duplicates[$strc])) {
            $all_duplicates[$strc] = [];
        }
        $all_duplicates[$strc][] = $row->id;
        $check_index = array_search($strc, array_keys($all_duplicates));
        session(['get_duplicates' => $all_duplicates]);
        return $check_index;
    }


    public function getData($id = null)
    {
        $data = $this->getSyncSetting($id);
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
        //service titans calls

        $tenant = get_values_by_id('titan_tenant_id', login_id());
        $locations = curl_request('crm/v2/tenant/' . $tenant . '/locations');
        if (property_exists($locations, 'data')) {
            $locations = $locations->data;
        } else {
            $locations = [];
        }

        $business_units = curl_request('settings/v2/tenant/' . $tenant . '/business-units');
        if (property_exists($business_units, 'data')) {
            $business_units = $business_units->data;
        } else {
            $business_units = [];
        }

        $compaigns = curl_request('marketing/v2/tenant/' . $tenant . '/campaigns');
        if (property_exists($compaigns, 'data')) {
            $compaigns = $compaigns->data;
        } else {
            $compaigns = [];
        }

        $job_types = curl_request('jpm/v2/tenant/' . $tenant . '/job-types');
        if (property_exists($job_types, 'data')) {
            $job_types = $job_types->data;
        } else {
            $job_types = [];
        }

        $technicians = curl_request('settings/v2/tenant/' . $tenant . '/technicians');
        if (property_exists($technicians, 'data')) {
            $technicians = $technicians->data;
        } else {
            $technicians = [];
        }

        $invoices = curl_request('accounting/v2/tenant/' . $tenant . '/invoices');
        if (property_exists($invoices, 'data')) {
            $invoices = $invoices->data;
        } else {
            $invoices = [];
        }

        $html = view('admin.sync-settings.sync-response', get_defined_vars())->render();
        $res = [
            'status' => 'success',
            'data' => $html,
            'pipelines' => $pipelines,
            'message' => 'Data fetched successfully'
        ];
        return response()->json($res);
    }
    public function add()
    {
        $title = $this->titles['add'];
        return view(admin_prefix() . $this->route . '.add', get_defined_vars());
    }

    public function getSyncSetting($id)
    {
        return SyncSettings::where('location_id', location_id())->where('id', $id)->first();
    }

    public function edit($id = null)
    {
        $data = $this->getSyncSetting($id);
        if (!$data) {
            return redirect()->back();
        }
        $title = 'Sync Setting';
        return view(admin_prefix() . $this->route . '.edit', get_defined_vars());
    }

    public function save(Request $req, $id = null)
    {
        $this->validate($req, [
            'calendar_id.*' => 'required | min:1',
            //   'calendar_name.*' => 'required | min:1',
            'pipeline_id.*' => 'required | min:1',
            //    'pipeline_name.*' => 'required | min:1',
            'pipeline_stage_id.*' => 'required | min:1',
            //   'pipeline_stage_name.*' => 'required | min:1',
            'oppurtunity_status.*' => 'required | min:1',
            //  'oppurtunity_status_name.*' => 'required | min:1',
            'appointment_status.*' => 'required | min:1',
            //  'appointment_status_name.*' => 'required | min:1',
            'location.*' => 'required | min:1',
            //   'location_name.*' => 'required | min:1',
            'business_unit.*' => 'required  | min:1',
            //  'business_unit_name.*' => 'required | min:1',
            'campaign.*' => 'required | min:1',
            //'campaign_name.*' => 'required | min:1',
            'priority.*' => 'required | min:1',
            'job_type.*' => 'required | min:1',
            //  'job_type_name.*' => 'required | min:1',
            'invoice_id.*' => 'required | min:1',
            // 'technician_id.*.*' => 'required  | min:1',
            'slot.*' => 'required | min:1',
        ]);


        $is_update = true;
        foreach ($req->calendar_id as $key => $value) {

            $data = [
                'calendar_id' => '',
                'calendar_name' => '',
                'pipeline_id' => '',
                'pipeline_name' => '',
                'pipeline_stage_id' => '',
                'pipeline_stage_name' => '',
                'oppurtunity_status' => '',
                //  'oppurtunity_status_name' => '',
                'appointment_status' => '',
                //    'appointment_status_name' => '',
                'location' => '',
                'location_name' => '',
                'business_unit' => '',
                'business_unit_name' => '',
                'campaign' => '',
                'campaign_name' => '',
                'priority' => '',
                'job_type' => '',
                'job_type_name' => '',
                'technician_id' => '',
                'technician_name' => '',
                'slot' => '',
                'invoice_id' => '',
            ];
            foreach (array_keys($data) as $k) {
                if (isset($req[$k][$key])) {
                    $data[$k] = $req[$k][$key];
                }
            }

            $data['titan_location_name'] = $data['location_name'];
            $data['titan_location_id'] = $data['location'];
            unset($data['location_name']);
            unset($data['location']);
            $data['location_id'] = login_id();

            $to_check = [
                'calendar_id' => '',
                'pipeline_id' => '',
                'pipeline_stage_id' => '',
                'oppurtunity_status' => '',
                'business_unit' => '',
                'titan_location_id' => '',
                'campaign' => '',
                'priority' => '',
                'job_type' => '',
                'slot' => '',
                'location_id' => '',
            ];


            foreach ($to_check as $ch => $v) {
                $to_check[$ch] = $data[$ch];
            }

            $check = SyncSettings::where($to_check);
            if (!is_null($id)) {
                $check->where('id', '<>', $id);
            }
            $check = $check->first();
            // dd($check);
            if (!$check) {
                if (is_null($id)) {
                    SyncSettings::create($data);
                } else {
                    SyncSettings::where('id', $id)->update($data);
                }
            } else {
                $is_update = false;
            }
        }

        $resp = ['status' => 'success', 'message' => 'Sync Setting added successfully'];
        if (!$is_update) {
            $resp = ['status' => 'error', 'message' => 'Same Sync Setting already exists'];
        }

        return response()->json($resp);
    }

    public function delete($id = null)
    {
        $data = $this->getSyncSetting($id);
        $msg = 'Sync Setting deleted successfully';
        $status = 'success';

        if (!$data) {
            $msg = 'Sync Setting not found';
            $status = 'error';
        } else {
            $data->delete();
        }

        return back()->with($status, $msg);
    }
}

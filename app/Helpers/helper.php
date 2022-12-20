<?php

use App\Models\CompanySetting;
use App\Models\Contact;
use App\Models\CustomField;
use App\Models\Setting;
use App\Models\SyncSettings;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\TryCatch;
use Termwind\Components\Dd;

function uploadFile($file, $path, $name)
{
    $name = $name . '.' . $file->getClientOriginalExtension();
    $file->move($path, $name);
    return $path . '/' . $name;
}
function login_id($id = "")
{
    if (session('location_id')) {
        return session('location_id');
    }

    if (request()->has('location_id')) {
        return request()->has('location_id');
    }

    if (!empty($id)) {
        return $id;
    }

    $id = auth()->user()->id;
    if (auth()->user()->role == user_role()) {
        // done by me at home
        // return auth()->user()->added_by;
        return $id;
    }
    return $id;
}

function location_id()
{
    return auth()->user()->location;
}

function admin_role()
{
    return 0;
}
function user_role()
{
    return 2;
}

function company_role($user = false)
{
    $id = 1;
    if (auth()->check() && $user) {
        $id = auth()->user()->role == admin_role() ? $id : user_role();
    }

    return $id;
}

function estimate_status()
{
    return ['paid', 'unpaid', 'draft', 'canceled'];
}

function dropdown_item($id, $route, $childroute, $title, $deletePopup = false)
{
    $deleteit = '';
    $route = route($route . '.' . $childroute, $id);
    if ($deletePopup) {
        $deleteit = 'onclick="event.preventDefault(); deleteMsg(\'' . $route . '\')"';
    }

    $html = '
        <a class="dropdown-item" href="' . $route . '" ' . $deleteit . '>' . $title . '</a>
        ';
    return $html;
}

function main_location($returnemail = false)
{
    $email = 'abraham_loc@nextlevelautomations.com';
    if ($returnemail) {
        return $email;
    }
    return \App\Models\User::where('email', $email)->first();
}
function change_status($id, $status, $route, $childroute = 'status')
{
    if ($status == 1) {
        $html = '
        <a class="dropdown-item" href="' . route($route . '.' . $childroute, $id) . '" onclick="event.preventDefault(); statusMsg(\'' . route($route . '.' . $childroute, $id) . '\')">Disable</a>
        ';
    } else {
        $html = '
        <a class="dropdown-item" href="' . route($route . '.' . $childroute, $id) . '" onclick="event.preventDefault(); statusMsg(\'' . route($route . '.' . $childroute, $id) . '\')">Activate</a>
        ';
    }
    return $html;
}

function sendDatatoghl($request, $tag, $notmodel = false)
{
    $replace = [];
    $fields = null;
    if (property_exists($request, 'pass')) {
        $replace['user_password'] = $request->pass;
        $fields = setCustomFields($replace);
    }

    if (property_exists($request, 'contactId') || (property_exists($request, 'id') && !$notmodel)) {
        add_tags($request->contactId ?? $request->id, $tag, $fields);
    } else {
        $data = new \stdClass;
        $name = explode(' ', $request->name);
        $data->firstName = $name[0] ?? '-';
        $data->lastName = $name[1] ?? '-';
        $data->email = $request->email;
        $data->customField = $fields;
        $data->tags = [$tag];
        ghl_api_call('contacts', 'POST', json_encode($data), [], true);
    }
}

function showOrderIcon()
{
    return '<i class="fas fa-list font-20 text-muted"></i>';
}

function getAction($order = '')
{
    if (empty($order)) {
        $order = '<i class="fas fa-ellipsis-v font-20 text-muted"></i>';
    }
    return $html = '
    <div class="dropdown d-inline-block float-right ">
        <a class="nav-link dropdown-toggle arrow-none" onclick="return false" id="dLabel4" data-toggle="dropdown" role="button" aria-haspopup="false" aria-expanded="false">
            ' . $order . '
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dLabel4" style="">
';
}

function getUser($id, $role = '')
{
    $role = empty($role) ? company_role() : $role;
    return $user = User::where('role', $role)->where('id', $id)->first();
}

function show_edit_del($id, $route, $data = ['edit' => ['status' => true], 'delete' => ['status' => true]])
{
    $html = '';
    if (isset($data['edit']) && $data['edit']['status'] == true) {
        $html = '
        <a class="dropdown-item" href="' . route($route . '.edit', $id) . '" class="mr-2">Edit</a>';
    }
    if (isset($data['delete']) && $data['delete']['status'] == true) {
        $html .= '<a class="dropdown-item" href="' . route($route . '.delete', $id) . '" onclick="event.preventDefault(); deleteMsg(\'' . route($route . '.delete', $id) . '\')">Delete</a>';
    }
    return $html;
}

function get_status($status)
{
    if ($status == 1) {
        $html = '<span class="badge badge-soft-success">Active</span>';
    } else {
        $html = '<span class="badge badge-soft-danger">Disabled</span>';
    }
    return $html;
}

function company_user_fk()
{
    return 'company_id';
}
function admin_prefix()
{
    return 'admin.';
}
function front_prefix()
{
    return 'front.';
}

function messages($msg)
{

    $messages = [
        'edit' => 'Record Edit Successfully',
        'add' => 'Record Add Successfully',
        'delete' => 'Record Deleted Successfully',
        'status' => 'Status Changed Successfully',
        'not' => 'Not Allowed',
    ];
    try {
        $msg = $messages[$msg];
    } catch (\Throwable $e) {
    }
    return $msg;
}

function get_pipelines()
{
    $pipelines = ghl_api_call('pipelines');
    if ($pipelines && property_exists($pipelines, 'pipelines')) {
        add_session('ghl_pipeline_resp', $pipelines->pipelines);
        return $pipelines->pipelines;
    }
    return [];
}

function get_users()
{
    $users = ghl_api_call('users/location');
    if ($users && property_exists($users, 'users')) {
        add_session('ghl_user_resp', $users->users);
        return $users->users;
    }
    return [];
}

function getName($contact)
{
    $contactname = $contact->name ?? $contact->fullName ?? null;
    if (!$contactname) {
        $contactname = $contact->firstName ?? '';
        if (!empty($contactname)) {
            $contactname .= ' ' . ($contact->lastName ?? '');
            add_session('ghl_contact_name', $contactname);
        }
    }
    return $contactname;
}

function splitDatetime($date, $sep = ' ')
{
    $ddate = ['date' => '', 'time' => ''];
    if (!is_null($date) && !empty($date)) {
        $date = explode($sep, $date);
        $ddate['date'] = $date[0];
        if (count($date) > 1) {
            $ddate['time'] = $date[1];
        }
    }
    return $ddate;
}
function get_tags_ghl()
{
    $tags = ghl_api_call('tags');
    if ($tags && property_exists($tags, 'tags')) {

        return $tags->tags;
    }
    return [];
}

function get_tags($type = 0)
{
    if (!is_array($type)) {
        $type = [$type];
    }
    $tags = \App\Models\Tag::where(
        company_user_fk(),
        login_id()
    )->where(function ($query) use ($type) {
        $query->whereIn('item_type', $type)
            ->orWhere('item_type', 2);
    })->orderBy('title')->get();
    return $tags;
}

function set_value($cat, $req, $req_key, $obj_key = '')
{
    if ($obj_key == '') {
        $obj_key = $req_key;
    }
    if (!empty($req->{$req_key})) {
        $cat->{$obj_key} = $req->{$req_key};
    }
    return $cat;
}

function get_custom_fields_loc_folders($type = 0)
{
    $tags = \App\Models\CustomField::with('fields')->where(
        company_user_fk(),
        login_id()
    )->where('type', 'Folder')->where(function ($query) use ($type) {
        $query->where('item_type', $type)
            ->orWhere('item_type', 2);
    })->orderBy('position')->get();
    return $tags;
}

function get_custom_fields_loc($type = 0)
{
    $tags = \App\Models\CustomField::where(
        company_user_fk(),
        login_id()
    )->whereNull('parent_id')->where('type', '<>', 'Folder')->where(function ($query) use ($type) {
        $query->where('item_type', $type)
            ->orWhere('item_type', 2);
    })->orderBy('position')->get();
    return $tags;
}

function get_ghl_timezones()
{
    $timezones = ghl_api_call('timezones');
    if ($timezones && property_exists($timezones, 'timezones')) {
        return $timezones->timezones;
    }
    return [];
}

function get_calendars()
{
    $services = ghl_api_call('calendars/services');
    if ($services && property_exists($services, 'services')) {
        add_session('ghl_calendar_resp', $services->services);
        return $services->services;
    }
    return [];
}
function get_contact($contactid)
{
    $contact = ghl_api_call('contacts/' . $contactid);
    if ($contact && property_exists($contact, 'contact')) {
        add_session('ghl_contact_resp', $contact->contact);
        return $contact->contact;
    }
    return null;
}

function getUTCOffset($timezone)
{
    $current = timezone_open($timezone);
    $utcTime = new \DateTime('now', new \DateTimeZone('UTC'));
    $offsetInSecs = timezone_offset_get($current, $utcTime);
    $hoursAndSec = gmdate('H:i', abs($offsetInSecs));
    return stripos($offsetInSecs, '-') === false ? "+{$hoursAndSec}" : "-{$hoursAndSec}";
}

function get_location($locationid)
{
    $contact = ghl_api_call('locations/' . $locationid);

    if ($contact && property_exists($contact, 'locations') && is_array($contact->locations) && count($contact->locations) > 0) {
        return $contact->locations[0];
    }
    if ($contact && property_exists($contact, 'id')) {
        return $contact;
    }

    return null;
}

function sendTagOrCustomFields($contact_id, $tag = '', $customFields = null)
{
    if (!is_object($contact_id)) {
        $contact_id = str_replace(' ', '', $contact_id);
        $response = ghl_api_call('contacts/' . $contact_id);
    } else {
        $response = new \stdClass;
        $response->contact = $contact_id;
    }

    if ($response && property_exists($response, 'contact')) {
        $contact = $response->contact;

        if (!empty($tag)) {
            if (!is_array($contact->tags)) {
                $contact->tags = [];
            }
            if (is_array($tag)) {
                $contact->tags = array_merge($contact->tags, $tag);
            } else {
                $contact->tags[] = $tag;
            }
        }

        if ($customFields) {
            $contact->customFields = $customFields;
        }

        $obj = new \stdClass;
        $obj->tags = $contact->tags;
        $obj->customFields = $contact->customFields;
        $response = pushghlContact($obj, $contact_id);
        if ($response && property_exists($response, 'contact')) {
            return $response->contact;
        } else {
            return $response;
        }
    }
}




function get_default_tag($tag)
{
    $defaults = ['tag_no_cost' => 'no_cost_estimate', 'tag_cost' => 'cost_estimate'];

    return get_custom_settings($tag, $defaults[$tag] ?? '');
}

function job_type($merge = false)
{
    $dt = [0 => 'Work Order', 1 => 'Job'];
    if ($merge) {

        $dt[] = 'Both';
    }
    return $dt;
}

function job_type_slug($type = '')
{
    $value = 0;
    try {
        $slugs = ['workorder' => 0, 'job' => 1, 'both' => 2];
        if ($type == '') {
            return $slugs;
        }
        $value = $slugs[$type];
    } catch (\Exception $e) {
    }
    return $value;
}

if (!function_exists('get_initials')) {
    function get_initials($string)
    {
        $words = explode(" ", $string);
        $initials = null;
        foreach ($words as $w) {
            $initials .= $w[0];
        }
        return $initials;
    }
}
if (!function_exists('quickRandom')) {
    function quickRandom($length = 16)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }
}

function items_list($merge = false)
{
    $dt = [0 => 'Materials', 1 => 'Services'];
    if ($merge) {

        $dt[] = 'Both';
    }
    return $dt;
}
function items_list_slug($type = '')
{
    $value = 0;
    try {
        $slugs = ['material' => 0, 'service' => 1, 'both' => 2];
        if ($type == '') {
            return $slugs;
        }
        $value = $slugs[$type];
    } catch (\Exception $e) {
    }
    return $value;
}

function jobs_list()
{
    return [0 => 'Work Order', 1 => 'Job'];
}
function setDateTime($date, $time)
{
    $datetime = '';
    if (!empty($date)) {
        $datetime .= $date;
    }
    if (!empty($time)) {
        $datetime .= ' ' . $time;
    }
    return $datetime;
}
function fields_type()
{
    return ['text', 'textarea', 'tel', 'numeric', 'date', 'time', 'url', 'color', 'checkbox', 'datetime-local'];
}

function getFileContent($key, $file_name)
{
    $extention = pathinfo($file_name, PATHINFO_EXTENSION);
    $image = file_get_contents($file_name);
    $keyy = $key . time();
    file_put_contents(public_path('uploads/' . $keyy . '.' . $extention), $image);
    return $keyy . '.' . $extention;
}

if (!function_exists('get_option')) {
    function get_option($name, $optional = '')
    {
        $value = Cache::get($name);
        if ($value == "") {
            $setting = DB::table('settings')->where('name', $name)->get();
            if (!$setting->isEmpty()) {
                $value = $setting[0]->value;
                Cache::put($name, $value);
            } else {
                $value = $optional;
            }
        }
        return $value;
    }
}

function add_session($key, $value)
{
    session()->put($key, $value);
}

function get_session($key, $default = null)
{
    return session()->get($key) ?? $default;
}

function pushghlContact($mycontact, $id = null)
{

    $method = 'put';
    if (!$id) {
        $method = 'post';
        $mycontact->locationId = get_values_by_id('location_id', login_id());
        $id = '';
    } else {
        try {
            unset($mycontact->locationId);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    $ghl_contact = ghl_api_call('contacts/' . $id, $method, json_encode($mycontact));

    if (isset($ghl_contact->message) && strpos($ghl_contact->message, 'not allow duplicated') !== false) {
        // loookup by email
        $email = $mycontact->email ?? '-';
        if ($email != '-') {
            $ghl_contact = ghl_api_call('contacts/?query=' . $email);
            if ($ghl_contact && property_exists($ghl_contact, 'contacts')) {
                $ghl_contact = $ghl_contact->contacts[0];
                $ghl_contact = ghl_api_call('contacts/' . $ghl_contact->id, 'put', json_encode($mycontact));
            }
        }
    }

    if ($ghl_contact && property_exists($ghl_contact, 'contact')) {
        return $ghl_contact;
    } else {
        return $ghl_contact;
    }
}

function jobCancelReasons($tenant_id, $job_id)
{
    $reason = curl_request('jpm/v2/tenant/' . $tenant_id . '/jobs/cancel-reasons?ids=' . $job_id);
    return $reason;
}

function jobType($tenant_id, $job_id)
{
    $job_type = curl_request('jpm/v2/tenant/' . $tenant_id . '/job-types?ids=' . $job_id);

    if ($job_type && property_exists($job_type, 'data')) {
        $job_type = $job_type->data[0];
        return $job_type->name ?? '';
    } else {
        return '';
    }
}

function projectStatus($tenant_id, $project_id)
{
    $project_status = curl_request('jpm/v2/tenant/' . $tenant_id . '/projects/statuses?ids=' . $project_id);

    if ($project_status && property_exists($project_status, 'data')) {
        $project_status = $project_status->data[0];
        return $project_status->name ?? '';
    } else {
        return '';
    }
}

function ghlUsers()
{
    $users = ghl_api_call('users/');
    if ($users && property_exists($users, 'users') && count($users->users) > 0) {
        $userid =  $users->users[0]->id;
        session()->put('userId', $userid);
    }
}

function createNotesObject($sync, $user, $data, $type)
{

    $tenant_id = get_values_by_id('titan_tenant_id', login_id());
    if (!session('userId')) {
        ghlUsers();
    }

    $titan = json_decode($user->go_response);
    if ($type == 'jobs') {
        $noteview =
            "Titan  Name: " . $titan->name . "\n" .
            "Titan  ID: " . $user->titan_customer_id . "\n" .
            "Pipeline  : " . $sync->pipeline_name . "\n" .
            "Pipeline Stage  : " . $sync->pipeline_stage_name . "\n" .
            "Job Number : " . $data->jobNumber . "\n" .
            "Job Status : " . $data->jobStatus . "\n" .
            "Job Type : " . jobType($tenant_id, $data->jobTypeId) . "\n" .
            "Job Priority : " . $data->priority . "\n" .
            "Job Summary : " . $data->summary . "\n" .
            "Job Created On : " . $data->createdOn . "\n" .
            "Job Modified On : " . $data->modifiedOn . "\n" .
            // "Job Booking Id : " . $data->bookingId . "\n" .
            "Job External Data : " . $data->externalData . "\n" .
            // "Job Location Id : " . $data->locationId . "\n" .
            "Job Business Unit  : " . $sync->business_unit_name . "\n" .
            "Job Campaign  : " . $sync->campaign_name . "\n" .
            // "Job Recall For Id : " . $data->recallForId . "\n" .
            // "Job Job Generated Lead Source : " . json_encode($data->jobGeneratedLeadSource) . "\n" .
            // "Job No Charge : " . $data->noCharge . "\n" .
            "Job Notifications Enabled : " . $data->notificationsEnabled . "\n";
        // "Job Created By Id : " . $data->createdById . "\n";
    } elseif ($type == 'projects') {
        $noteview =
            "Titan  Name: " . $titan->name . "\n" .
            "Titan  ID: " . $user->titan_customer_id . "\n" .
            "Project Number : " . $data->number . "\n" .
            "Project Name : " . $data->name . "\n" .
            "Project Summary : " . $data->summary . "\n" .
            "Project Status : " . $data->status . "\n" .
            // "Project Status Id : " . $data->statusId . "\n" .
            // "Project Customer Id : " . $data->customerId . "\n" .
            // "Project Location Id : " . $data->locationId . "\n" .
            "Project Start Date : " . $data->startDate . "\n" .
            "Project Target Completion Date : " . $data->targetCompletionDate . "\n" .
            "Project Actual Completion Date : " . $data->actualCompletionDate . "\n" .
            "Project Modified On : " . $data->modifiedOn . "\n";
    } elseif ($type == 'contacts') {
        //contacts view
    } elseif ($type == 'invoices') {
        $customs = [
            'invoice_id' => $data->id ?? '',
            'invoice_sync_status' => $data->syncStatus ?? '',
            'invoice_summary' => $data->summary ?? '',
            'invoice_reference_number' => $data->referenceNumber ?? '',
            'invoice_date' => $data->invoiceDate ?? '',
            'invoice_due_date' => $data->dueDate ?? '',
            'invoice_sub_total' => $data->subTotal ?? '',
            'invoice_sales_tax' => $data->salesTax ?? '',
            'invoice_sales_tax_code' => $data->salesTaxCode ?? '',
            'invoice_total' => $data->total ?? '',
            'invoice_balance' => $data->balance ?? '',
        ];

        $fields = setCustomFields($customs);




        $noteview =
            "Titan  Name: " . $titan->name ?? '' . "\n" .
            "Titan  ID: " . $user->titan_customer_id ?? '' . "\n" .
            "Invoice Number : " . $data->id ?? '' . "\n" .
            "Invoice syncStatus : " . $data->syncStatus ?? '' . "\n" .
            "Invoice summary : " . $data->summary  ?? '' . "\n" .
            "Invoice referenceNumber : " . $data->referenceNumber ?? '' . "\n" .
            "Invoice invoiceDate : " . $data->invoiceDate ?? '' . "\n" .
            "Invoice dueDate : " . $data->dueDate ?? '' . "\n" .
            "Invoice subTotal : " . $data->subTotal . "\n" .
            "Invoice salesTax : " . $data->salesTax ?? '' . "\n" .
            "Invoice salesTaxCode : " . $data->salesTaxCode ?? '' . "\n" .
            "Invoice total : " . $data->total ?? '' . "\n" .
            "Invoice balance : " . $data->balance ?? '' . "\n" .
            "Invoice customer : " . $data->customer->name ?? '' . "\n" .
            "Invoice customerAddress : " . $data->customerAddress->street  ?? '' . "\n" .
            "Invoice location : " . $data->location->name ?? '' . "\n" .
            "Invoice locationAddress : " . $data->locationAddress->street ?? '' . "\n" .
            "Invoice businessUnit : " . $data->businessUnit->name ?? '' . "\n" .
            "Invoice termName : " . $data->termName ?? '' . "\n" .
            "Invoice createdBy : " . $data->createdBy ?? '' . "\n" .
            "Invoice batch : " . $data->batch->number ?? '' . "\n" .
            "Invoice depositedOn : " . $data->depositedOn ?? '' . "\n" .
            "Invoice modifiedOn : " . $data->modifiedOn ?? '' . "\n" .
            "Invoice adjustmentToId : " . $data->adjustmentToId  ?? '' . "\n" .
            "Invoice job : " . $data->job->number ?? '' . "\n" .
            "Invoice job type : " . $data->job->type ?? '' . "\n" .
            "Invoice Royalty status : " . $data->royalty->status ?? '' . "\n" .
            "Invoice EmployeeInfo : " . $data->employeeInfo->name ?? '' . "\n" .
            "Invoice items : "  . "\n" .
            "Invoice items id : " . $data->items[0]->id  ?? '' .  "\n" .
            "Invoice items description : " . $data->items[0]->description ?? '' . "\n" .
            "Invoice items quantity : " . $data->items[0]->quantity ?? '' . "\n";
    }


    if (session('userId')) {
        $note = new stdClass;
        $note->userId = session('userId');
        $note->body = $noteview;
    }

    $res = ghl_api_call('contacts/' . $user->go_contact_id . '/notes/', 'post', json_encode($note));

    if ($res && property_exists($res, 'note')) {
        return true;
    } else {
        return false;
    }
}

function sendCustomFields($data, $id)
{
}

function sendAppointmentToGhl($data)
{
    $job = ghl_api_call('calendars/events/appointments/' . $data);
    if ($job && $job->id) {
        return $job->id;
    }
    return false;
}

function pushOpportunityGhl($data, $id = null)
{
    $method = 'put';
    if (!$id) {
        $method = 'post';
        $data->locationId = get_values_by_id('location_id', login_id());
        $id = '';
    } else {
        try {
            unset($data->locationId);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    $ghl_resp = ghl_api_call('opportunities/' . $id, $method, json_encode($data));
    //to string $ghl_resp->message;
    $errmsg = json_encode($ghl_resp->message);



    if (isset($errmsg) && strpos($errmsg, 'opportunity exists in this pipeline') !== false) {
        //opportunity already exists in this pipeline
    }
    if (isset($errmsg) && strpos($errmsg, 'opportunity contact is deleted') !== false) {
        //opportunity contact is deleted
    }

    if ($ghl_resp && property_exists($ghl_resp, 'opportunity')) {
        return $ghl_resp->opportunity;
    }
    return '';
}

function ghl_api_call($url = '', $method = 'get', $data = '', $headers = [], $json = false, $is_v2 = true)
{
    $baseurl = 'https://rest.gohighlevel.com/v1/';
    $bearer = 'Bearer ';
    if (get_default_settings('oauth_ghl', 'api') != 'oauth') {
        $token = company_user()->ghl_api_key;
    } else {
        $token = get_values_by_id('access_token', login_id());

        if (empty($token)) {
            if (session('cronjob')) {
                return false;
            }
            abort(redirect()->intended(route('setting.index')));
        }
        //   dd($token);
        $baseurl = 'https://api.msgsndr.com/';
        $version = get_default_settings('oauth_ghl_version', '2021-04-15');
        $location = get_values_by_id('location_id', login_id());
        $headers['Version'] = $version;

        if ($method == 'get') {
            $url .= (strpos($url, '?') !== false) ? '&' : '?';
            $url .= 'locationId=' . $location;
        }
        //for custom fields the url will change like this
        if (strpos($url, 'custom') !== false) {
            $url = 'locations/' . $location . '/' . $url;
        }
    }

    if ($token) {
        $headers['Authorization'] =  $bearer . $token;
    }

    $headers['Content-Type'] = "application/json";

    $client = new \GuzzleHttp\Client(['http_errors' => false, 'headers' => $headers]);
    $options = [];
    if (!empty($data)) {
        $options['body'] = $data;
    }
    $url1 = $baseurl . $url;
    // if(strpos($url, 'user') !== false){
    // if($method=='post')
    // {
    //     dd($url1, $method, $data, $headers, $json, $is_v2);
    // }

    $response = $client->request($method, $url1, $options);
    $bd = $response->getBody()->getContents();
    $bd = json_decode($bd);

    if (isset($bd->error) && $bd->error == 'Unauthorized') {
        request()->code  = get_values_by_id('refresh_token', login_id());

        if (strpos($bd->message, 'expired') !== false) {
            $tok = ghl_token(request(), '1');
            sleep(1);
            return ghl_api_call($url, $method, $data, $headers, $json, $is_v2);
        }
        if (session('cronjob')) {
            return false;
        }

        abort(401, 'Unauthorized');
    }

    return $bd;
}
function recheck($value)
{
    return $value == '-'  ? '' : $value;
}
function company_user($location = '', $key = 'location')
{
    if (!empty($location)) {
        return $loc = \App\Models\User::where($key, $location)->where('role', company_role())->first();
    } else if (\Auth::check()) {
        $user = auth()->user();
        if ($user->role == user_role()) {
            return $user->addedby;
        }
        return $user;
    }
}

function get_titan_time($time = '-1 hour')
{
    return 'modifiedOnOrAfter=' . date('Y-m-d\TH:i:s.Z', strtotime($time));
}

function curl_request($url = '', $method = 'GET', $data = '', $token = '', $json = false, $app_id = '')
{
    if (empty($token)) {
        $token = get_values_by_id('titan_access_token', login_id());
    }

    if (empty($app_id)) {
        $app_id = get_values_by_id('titan_app_id', login_id());
    }

    $headers = array(
        'Authorization: ' . $token,
        'ST-App-Key:' . $app_id,
    );

    if ($json) {
        $headers[] = "Content-Type: application/json";
    }
    $path = 'https://api-integration.servicetitan.io/' . $url;
    // dd($path);

    $curl = curl_init();
    $headers = array(
        'ST-App-Key: ' . $app_id,
        'Authorization: ' . $token
    );
    if ($json) {
        $headers[] = 'Content-Type: application/json';
    }

    curl_setopt_array($curl, array(
        CURLOPT_URL => $path,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => $headers,
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    $response = json_decode($response);
    if (is_object($response) && property_exists($response, 'status') && $response->status == '401') {
        //      $from = empty($app_id) ? true : false;
        $token = connectToSeviceTitan();
        \Illuminate\Support\Facades\Log::info($token);
        if ($token) {
            return curl_request($url, $method, $data, '', $json, $app_id);
        }
    }
    return $response;
}



function settings($key)
{
    $setting = Setting::where('user_id', Auth::user()->id)->where('name', $key)->first();
    if (!$setting) {
        $setting = Setting::where('user_id', 1)->pluck('value', 'name');
        $first = $setting[$key] ?? '';
    } else {
        $first = $setting->value;
    }

    return $first;
    // return SetCustomValues::where('user_id',Auth::user()->id)->where('name',$key)->first()->value ?? '';
}

function showLogo()
{
    return asset(get_values_by_id('company_logo', login_id()) ?? 'assets/images/logo-sm.png');
}

function showCompanyName()
{
    return get_values_by_id('company_name', login_id()) != '' ? get_values_by_id('company_name', login_id()) : 'Service Titans';
}

function save_custom_setting($key, $value, $id = "")
{
    if (empty($id)) {
        $id = Auth::user()->id;
    }
    $loginid = $id;
    $obj = Setting::where(company_user_fk(), $loginid)->where('key', $key)->first();
    if (!$obj) {
        $obj = new Setting();
        $obj->key = $key;
        $obj->{company_user_fk()} = $loginid;
    }
    $obj->value = $value;
    $obj->save();
}

function get_setting($company, $key, $default = '')
{
    $setting = Setting::where('company_id', $company)->pluck('value', 'key');
    return $setting[$key] ?? $default;
}

function get_custom_settings($key, $default = '')
{
    $setting = Setting::where('company_id', Auth::id())->pluck('value', 'key');
    return $setting[$key] ?? $default;
}

function get_default_settings($key, $default = '')
{
    $setting = Setting::pluck('value', 'key');
    return $setting[$key] ?? $default;
}

function get_values_by_id($key, $id)
{
    $setting = Setting::where('company_id', $id)->pluck('value', 'key');
    if ($key == 'companylogo') {
        return $setting[$key] ?? null;
    } else {
        return $setting[$key] ?? '';
    }
}

function get_custom_values($key)
{
    session()->put('ghl_api_key', $key);
    $values = ghl_api_call('custom-values');
    return $values;
}

function get_custom_field($key)
{
    session()->put('ghl_api_key', $key);
    $values = ghl_api_call('custom-fields');
    return $values;
}

function convertToString($string)
{
    $str = str_replace('_', ' ', $string);
    $str = ucwords($str);
    return $str;
}



function totalCompanies()
{
    return User::where('role', 1)->count();
}

function totalContacts()
{
    if (auth()->user()->role == 0) {
        return User::where('role', 2)->count();
    } else {
        return User::where('role', 2)->where('added_by', auth()->user()->id)->count();
    }
}

function updateCustomValues($request)
{
    try {
        $request_array = [];
        foreach ($request as $key => $value) {
            $request_array[$key] = $value;
        }
        $ghl_custom_values = ghl_api_call('custom-values');
        $custom_values = $ghl_custom_values;
        if (property_exists($custom_values, 'customValues')) {
            $custom_values = $custom_values->customValues;
            $custom_values = array_filter($custom_values, function ($value) use ($request_array) {
                return in_array($value->name, array_keys($request_array));
            });
            foreach ($custom_values as $key => $custom) {
                $value = $request_array[$custom->name];
                $custom->value = $value;
                $request_array[$custom->name] = $custom;
            }
            $i = 0;
            foreach ($request_array as $key => $custom) {
                if ($i % 5 == 0) {
                    sleep(2);
                }

                $i++;
                if (is_object($custom)) {
                    $abc = ghl_api_call('custom-values/' . $custom->id, 'PUT', json_encode(['value' => $custom->value]), [], true);
                } else {
                    $abc = ghl_api_call('custom-values/', 'POST', json_encode(['name' => $key, 'value' => $custom]), [], true);
                }
            }

            $res = [
                'status' => 'success',
                'message' => 'Custom values updated successfully',
            ];
            return $res;
        } else {
            $res = [
                'status' => 'error',
                'message' => 'Custom values not found',
            ];
            return $res;
        }
    } catch (\Exception $e) {
        $res = [
            'status' => 'error',
            'message' => $e->getMessage(),
        ];
        return $res;
    }
}

function process_na($val, $def = 'N/A')
{
    return $val ?? $def;
}

function get_ghl_value($data, $name)
{
    if (property_exists($data, 'customValues')) {
        $custom_values = $data->customValues;
        $custom_values = array_filter($custom_values, function ($value) use ($name) {
            return $value->name == $name;
        });
        foreach ($custom_values as $key => $val) {
            return $val->value ?? '';
        }
    }
    return '';
}

function key_error($array)
{
    $err = [];
    foreach ($array as $key => $error) {
        $err[$key] = $error->message;
    }
    return $err;
}

function show_err($errors)
{
    $error = '<ul>';
    foreach ($errors as $key => $value) {
        $error .= '<strong>' . $key . '</strong>';
        $error .= '<li style="margin-left:5px;">' . $value . '</li>';
    }
    $error .= '</ul>';
    $errors = [
        'status' => 'error',
        'message' => $error,
    ];

    return $errors;
}

function get_title($color = 'text-white')
{
    $title = '<h2 data-v-9f49e2de="" class="heading2">Project Management</h2><h6 class="' . $color . '"> by Nextlevel Automations</h6>';
    return $title;
}

function contactLogo($id)
{
    $contact = User::find($id);
    if ($contact) {
        $company = User::find($contact->added_by);
        $logo = CustomField::where(['name' => 'companylogo', 'company_id' => $company->id])->first();
        if ($logo) {
            return $logo->value;
        } else {
            return '';
        }
    }
}

if (!function_exists('get_date')) {
    function get_date($date)
    {
        $date_format = get_date_format();
        return \Carbon\Carbon::parse($date)->format("$date_format");
    }
}

function getFormatDate($date, $time = "")
{
    $date_format = "m-d-Y";
    $time_format = " h:i A";
    if (is_null($date)) {
        return "";
    }
    if (!is_null($time) && $time != "") {
        $date_format .= $time_format;
        $date .= ' ' . $time;
    } else if (strpos($date, 'T') !== false || strpos(trim($date), ' ') !== false) {
        $date_format .= $time_format;
    }
    return \Carbon\Carbon::parse($date)->format("$date_format");
}
if (!function_exists('get_time_format')) {
    function get_time_format()
    {
        $time_format = \Cache::get('time_format');

        if ($time_format == '') {
            $time_format = get_option('time_format');
            \Cache::put('time_format', $time_format);
        }

        $time_format = $time_format == 24 ? 'H:i' : 'h:i A';

        return $time_format;
    }
}

function get_css($key)
{
    $user = Auth::user();
    if ($user->role == 1) {
        $css = get_custom_settings($key);
        if ($css == '') {
            $css = get_default_settings($key);
            return $css;
        }
        return $css;
    }
    if ($user->role == 0) {
        $css = get_default_settings($key);
        return $css;
    }

    if ($user->role == 2) {
        $company = User::find($user->added_by);
        if ($company) {
            $css = get_custom_settings($key, $company->id);
            if ($css == '') {
                $css = get_default_settings($key);
                return $css;
            }
            return $css;
        }
    }
}

function default_user_permissions()
{
    $perms = '{
        "campaignsEnabled": true,
        "campaignsReadOnly": true,
        "contactsEnabled": true,
        "workflowsEnabled": true,
        "triggersEnabled": true,
        "funnelsEnabled": true,
        "websitesEnabled": true,
        "opportunitiesEnabled": true,
        "dashboardStatsEnabled": true,
        "bulkRequestsEnabled": true,
        "appointmentsEnabled": true,
        "reviewsEnabled": true,
        "onlineListingsEnabled": true,
        "phoneCallEnabled": true,
        "conversationsEnabled": true,
        "assignedDataOnly": true,
        "adwordsReportingEnabled": true,
        "membershipEnabled": true,
        "facebookAdsReportingEnabled": true,
        "attributionsReportingEnabled": true,
        "settingsEnabled": true,
        "tagsEnabled": true,
        "leadValueEnabled": true,
        "marketingEnabled": true
    }';
    $values = json_decode($perms);
    $obj = new \stdClass;
    $obj->permissions = $values;
    return $obj;
}

if (!function_exists('create_option')) {
    function create_option($table, $value, $display, $selected = '', $where = null)
    {
        $options = '';
        $condition = '';

        $already = false;
        if ($table == 'ghl_api') {
            $resp = ghl_api_call('contacts?limit=100');
            $resp = json_decode($resp);
            $options = '';
            if ($resp && $resp->contacts) {
                $i = 0;
                foreach ($resp->contacts as $res) {

                    $cnt = new \stdClass;
                    $cnt->id = $res->id;
                    $name = '';
                    if (!empty($res->contactName)) {
                        $name .= $res->contactName;
                    }
                    if (!empty($res->email)) {
                        if (!empty($name)) {
                            $name .= ' - ';
                        }
                        $name .= $res->email;
                    }
                    $cnt->text = $name;
                    $options .= "<option value='" . $cnt->id . "' ";
                    if ($cnt->id == $selected) {
                        $options .= ' selected';
                        $already = true;
                    }
                    $options .= '>' . ucwords($name) . "</option>";
                }
            }
            if (!$already) {
                $options .= '<option value=' . $selected . ' selected>' . $selected->user->name . '</option>';
            }
            echo $options;
            return;
        }
        if ($where != null) {
            $condition .= "WHERE ";
            foreach ($where as $key => $v) {
                $condition .= $key . "'" . $v . "' ";
            }
        }
        if (!is_array($selected)) {
            $selected = $selected == '' ? [] : [$selected];
        }
        $query = DB::select("SELECT * FROM $table $condition");
        foreach ($query as $d) {
            $disp_name = '';
            if (is_array($display)) {
                $i = 0;
                foreach ($display as $p) {
                    if ($i > 0) {
                        $disp_name .= ' - ';
                    }
                    $i++;
                    if (strpos($p, '|')) {

                        $dp = explode('|', $p);
                        $v = $dp[0];
                        $dp12 = explode(',', $dp[1]);

                        foreach ($dp12 as $p1) {
                            $dp2 = explode('=', $p1);

                            if (in_array($d->$v, $dp2)) {
                                $disp_name .= $dp2[1];
                            }
                        }
                    } else {
                        $disp_name .= $d->$p;
                    }
                }
            } else {
                $disp_name = $d->$display;
            }
            $options .= "<option value='" . $d->$value . "' ";
            if (in_array($d->$value, $selected)) {
                $options .= ' selected';
            }
            $options .= '>' . ucwords($disp_name) . "</option>";
        }

        echo $options;
    }
}

if (!function_exists('ghl_oauth_call')) {

    function ghl_oauth_call($code = '', $method = '')
    {
        $url = 'https://api.msgsndr.com/oauth/token';
        $curl = curl_init();
        $data = [];
        $data['client_id'] = get_default_settings('go_client_id');
        $data['client_secret'] = get_default_settings('go_client_secret');
        $md = empty($method) ? 'code' : 'refresh_token';
        $data[$md] = $code; // (empty($code)?company_user()->ghl_api_key:$code);
        $data['grant_type'] = empty($method) ? 'authorization_code' : 'refresh_token';
        //   $data['grant_type'] =  'authorization_code';
        $postv = '';
        $x = 0;

        foreach ($data as $key => $value) {
            if ($x > 0) {
                $postv .= '&';
            }
            $postv .= $key . '=' . $value;
            $x++;
        }

        $curlfields = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postv,
        );
        //dd($url,$postv);
        curl_setopt_array($curl, $curlfields);

        $response = curl_exec($curl);
        $response = json_decode($response);
        curl_close($curl);
        return $response;
    }
}

function array_string($dat, $return_string = false)
{
    if ($return_string && is_array($dat)) {
        $dat = implode(',', $dat);
    }
    return $dat;
}

function check_field($dat, $key, $default = '')
{
    $v1 = '-------';
    $v = $dat->$key ?? $v1;
    if ($v != $v1) {
        return $v;
    }
    if ($dat instanceof \Illuminate\Database\Eloquent\Collection) {

        return $dat->$key ?? $default;
    }
    if (is_object($dat) && property_exists($dat, $key)) {

        return $dat->$key;
    }
    if (is_array($dat) && isset($dat[$key])) {
        return $dat[$key];
    }
    return $default;
}

function ghl_token($request, $type = '')
{

    $code = $request->code;

    $code  =  ghl_oauth_call($code, $type);
    $route = '/';
    $id = login_id();

    if ($code) {
        if (property_exists($code, 'access_token')) {
            session()->put('ghl_api_token', $code->access_token);
            save_custom_setting('access_token', $code->access_token, $id);
            save_custom_setting('refresh_token', $code->refresh_token, $id);
            if (empty($type)) {


                save_custom_setting('location_id', $code->locationId, $id);
                save_custom_setting('hash_company_id', $code->hashedCompanyId, $id);
                save_custom_setting('user_type', $code->userType, $id);

                abort(redirect()->route('dashboard')->with('success', 'Successfully connected to CRM'));
            }
        } else {
            if (property_exists($code, 'error_description')) {
                if (empty($type)) {
                    abort(redirect()->route('dashboard')->with('error', $code->error_description));
                }
            }
            return null;
        }
    }
    if (empty($type)) {
        abort(redirect()->route('dashboard')->with('error', 'Server error'));
    }
}

if (!function_exists('get_percent')) {
    function get_percent($price, $amount = 3.85)
    {

        $percentToGet = $amount;
        $percentInDecimal = $percentToGet / 100;
        return $amount = $percentInDecimal * $price;
    }
}

if (!function_exists('get_response')) {
    function get_response($message, $status = false, $data = [])
    {
        return ['status' => $status, 'message' => $message, 'data' => $data];
    }
}

function breakCamelCase($letter, $separator = ' ')
{
    $letter = ucwords(implode(' ', explode($separator, $letter)));
    return $letter;
}

function settingForCron($key)
{
    $setting = Setting::where('key', $key)->first();
    if ($setting) {
        // $setting = $setting->where('company_id', $setting->company_id)->first();
        // if ($setting) {
        return $setting->value;
        // }
    }
    return null;
}

function connectToSeviceTitan($check = false, $cron = false)
{
    $client_id =  get_values_by_id('titan_client_id', login_id());
    $client_secret = get_values_by_id('titan_client_secret', login_id());
    $url = 'https://auth-integration.servicetitan.io/connect/token';
    //$client_id = get_values_by_id('titan_client_id', login_id());
    //$client_secret = get_values_by_id('titan_client_secret', login_id());
    $curl = curl_init();
    $data = [];
    $data['client_id'] = $client_id;
    $data['client_secret'] = $client_secret;
    $data['grant_type'] = 'client_credentials';
    $postv = '';
    $x = 0;
    foreach ($data as $key => $value) {
        if ($x > 0) {
            $postv .= '&';
        }
        $postv .= $key . '=' . $value;
        $x++;
    }

    $curlfields = array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $postv,
    );

    curl_setopt_array($curl, $curlfields);
    $response = curl_exec($curl);
    curl_close($curl);

    $response = json_decode($response);

    if (isset($response->access_token)) {
        save_custom_setting('titan_access_token', $response->access_token, login_id());
        session()->put('titan_access_token', $response->access_token);
        return true;
    } else {
        return false;
    }
}

function checkAuthConnection($service = 'ghl')
{
    if ($service == 'ghl') {
        $c = get_values_by_id('access_token', \Auth::id());
        if ($c) {
            return true;
        }
        return false;
    }
    if ($service == 'titan') {
        $c = get_values_by_id('titan_access_token', \Auth::id());
        if ($c) {
            return true;
        }
        return false;
    }
}

if (!function_exists('timezone_list')) {

    function timezone_list()
    {
        $zones_array = array();
        $timestamp = time();
        foreach (timezone_identifiers_list() as $key => $zone) {
            date_default_timezone_set($zone);
            $zones_array[$key]['ZONE'] = $zone;
            $zones_array[$key]['GMT'] = 'UTC/GMT ' . date('P', $timestamp);
        }
        return $zones_array;
    }
}

if (!function_exists('g_decimal_place')) {
    function g_decimal_place($number, $symbol = '', $format = '', $currency_position)
    {
        if ($symbol == '') {
            return money_format_2($number, $format);
        }

        if ($currency_position == 'left') {
            return $symbol . ' ' . money_format_2($number, $format);
        } else {
            return money_format_2($number, $format) . ' ' . $symbol;
        }
    }
}

if (!function_exists('decimalPlace')) {
    function decimalPlace($number, $symbol = '')
    {
        $format = money_format_2($number);
        if ($symbol == '') {
            return $format;
        }

        if (get_currency_position() == 'right') {
            return $format . ' ' . $symbol;
        } else {
            return $symbol . ' ' . $format;
        }
    }
}
if (!function_exists('decimalPlaceTag')) {
    function decimalPlaceTag($number, $symbol = '', $tag_start = '<span class="cost_value">', $tag_end = '</span>')
    {
        $format = $tag_start . money_format_2($number) . $tag_end;
        if ($symbol == '') {
            return $format;
        }

        if (get_currency_position() == 'right') {
            return $format . ' ' . $symbol;
        } else {
            return $symbol . ' ' . $format;
        }
    }
}

if (!function_exists('money_format_2')) {
    function money_format_2($floatcurr)
    {
        $decimal_place = get_option('decimal_places', 2);
        $decimal_sep = get_option('decimal_sep', '.');
        $thousand_sep = get_option('thousand_sep', ',');

        return number_format($floatcurr, $decimal_place, $decimal_sep, $thousand_sep);
    }
}

if (!function_exists('process_string')) {

    function process_string($search_replace, $string)
    {
        $result = $string;
        foreach ($search_replace as $key => $value) {
            $result = str_replace($key, $value, $result);
        }
        return $result;
    }
}

if (!function_exists('status')) {
    function status($status, $class = 'success')
    {
        if ($class == 'danger') {
            return "<span class='badge badge-danger'>$status</span>";
        } else if ($class == 'success') {
            return "<span class='badge badge-success'>$status</span>";
        } else if ($class == 'info') {
            return "<span class='badge badge-dark'>$status</span>";
        }
    }
}

if (!function_exists('xss_clean')) {
    function xss_clean($data)
    {
        // Fix &entity\n;
        $data = str_replace(array('&amp;', '&lt;', '&gt;'), array('&amp;amp;', '&amp;lt;', '&amp;gt;'), $data);
        $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
        $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
        $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

        // Remove any attribute starting with "on" or xmlns
        $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

        // Remove javascript: and vbscript: protocols
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

        // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

        // Remove namespaced elements (we do not need them)
        $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

        do {
            // Remove really unwanted tags
            $old_data = $data;
            $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
        } while ($old_data !== $data);

        // we are done...
        return $data;
    }
}

if (!function_exists('get_date_format')) {
    function get_date_format()
    {
        $date_format = Cache::get('date_format');

        if ($date_format == '') {
            $date_format = get_option('date_format', 'Y-m-d');
            \Cache::put('date_format', $date_format);
        }

        return $date_format;
    }
}

// convert seconds into time
if (!function_exists('time_from_seconds')) {
    function time_from_seconds($seconds)
    {
        $h = floor($seconds / 3600);
        $m = floor(($seconds % 3600) / 60);
        $s = $seconds - ($h * 3600) - ($m * 60);
        return sprintf('%02d:%02d:%02d', $h, $m, $s);
    }
}

if (!function_exists('create_timezone_option')) {

    function create_timezone_option($old = "")
    {
        $option = "";
        $timestamp = time();
        foreach (timezone_identifiers_list() as $key => $zone) {
            date_default_timezone_set($zone);
            $selected = $old == $zone ? "selected" : "";
            $option .= '<option value="' . $zone . '"' . $selected . '>' . 'GMT ' . date('P', $timestamp) . ' ' . $zone . '</option>';
        }
        echo $option;
    }
}

if (!function_exists('exists_field')) {
    function exists_field($field)
    {
        return request()->has($field) ? request()->$field : '';
    }
}

function asset_url($url)
{
    if (env('APP_ENV') == 'production') {
        return asset('public/' . $url);
    } else {
        return asset($url);
    }
}

function setCustomFields($request)
{
    $location_id = get_values_by_id('location_id', login_id());
    $user_custom_fields = [];
    try {
        $request_array = [];
        foreach ($request as $key => $value) {
            $request_array[$key] = $value;
        }
        $ghl_custom_values = ghl_api_call('customFields');
        $custom_values = $ghl_custom_values;


        if (property_exists($custom_values, 'customFields')) {
            $custom_values = $custom_values->customFields;
            $custom_values = array_filter($custom_values, function ($value) use ($request_array) {
                $kn = strtolower(str_replace(' ', '_', $value->name));
                return in_array($kn, array_keys($request_array));
            });


            foreach ($custom_values as $key => $custom) {
                $name = strtolower(str_replace(' ', '_', $custom->name));

                $custom->value = $request[$name];
                $request_array[$name] = $custom;
            }


            $i = 0;
            foreach ($request_array as $key => $custom) {
                $i++;
                $value = '';
                if (is_object($custom)) {
                    $id = $custom->id;
                    $value = $custom->value;
                } else {
                    if ($i % 5 == 0) {
                        sleep(2);
                    }
                    $value = $custom;
                    $type = strpos($key, 'date') !== false ? 'DATE' : 'TEXT';
                    $send_name = ucwords(str_replace('_', ' ', $key));
                    $abc = ghl_api_call('customFields', 'post', json_encode(['name' => $send_name, 'dataType' => $type]), [], true);

                    $cord = $abc;
                    if ($cord && property_exists($cord, 'id')) {
                        $id = $cord->id;
                    }
                }

                $field = new \stdClass();
                $field->id = $id;
                $field->field_value = $value;
                $user_custom_fields[] = $field;
            }
        }
    } catch (\Exception $e) {
    }
    return $user_custom_fields;
}


function set_location_id($location_id)
{
    $location = User::where('location', $location_id)->first();
    if ($location) {
        //   session()->put('location_id', $location_id);
        return true;
    }
    return false;
}

function get_titans_locations()
{
    $locations = [];
    $locations = get_values_by_id('titan_selected_locations', Auth::id());
    if (!empty($locations)) {
        $locations = json_decode($locations);
        dd($locations);
    }
}


function goName($request)
{

    $name = $request->firstName ?? '-';
    $name .= ' ';
    $name .= $request->lastName ?? '-';
    return $name;
}

function createtitanCustomerObject($req)
{
    $obj = new stdClass();
    $obj->name = $req->name;
    $obj->type = $req->type;
    $req->address = json_encode($req->address);
}


function saveContactToDb($request, $from = 'ghl')
{
    if ($from == 'ghl') {
        $obj = new stdClass;
        $obj->name = goName($request);
        $obj->phone = $request->phone ?? $request->email;
        $obj->locations = json_decode(get_values_by_id('titan_selected_location', login_id()));
        $obj->address = $request->address; // ?? '-';
        $data = json_encode($obj);
        $sendToSt = curl_request('crm/v2/tenant/' . get_values_by_id('titan_tenant_id', login_id()) . '/customers', 'POST', $data, '', true);
    
        // $con = null;
        $titan_response = new stdClass;
        if ($sendToSt && property_exists($sendToSt, 'id')) {
            $titan_response->name = $sendToSt->name ?? '-';
            $customer_id = $sendToSt->id;
            $url = 'crm/v2/tenant/' . get_values_by_id('titan_tenant_id', login_id()) . '/customers/' . $customer_id . '/contacts';
            //for email value
            if (property_exists($request, 'email') && $request->email != "-") {
                $con_obj = new stdClass;
                $con_obj->type = 'Email';
                $con_obj->value = $request->email;
                $sendEmail = curl_request($url, 'POST', json_encode($con_obj), '', true);

                if ($sendEmail && property_exists($sendEmail, 'id')) {
                    $titan_response->email = $sendEmail->value;
                }
            }

            if (property_exists($request, 'phone') && $request->phone != "-") {
                $con_obj = new stdClass;
                $con_obj->type = 'Phone';
                $con_obj->value = $request->phone;
                $sendEmail = curl_request($url, 'POST', json_encode($con_obj), '', true);
                if ($sendEmail && property_exists($sendEmail, 'id')) {
                    $titan_response->phone = $sendEmail->value;
                }
            }

            $titan_response->address = $request->address;
            $con = Contact::create([
                'go_contact_id' => $request->contact_id,
                'address' => json_encode($request->address ?? '-'),
                'company_id' => $request->locationId,
                'titan_customer_id' => $sendToSt->id,
                'go_response' => json_encode($request),
                'titan_response' => json_encode($titan_response)
            ]);
            return $con;
        }
       
    } else {
        $contactobj = contactObject($request);

        $contact = Contact::create([
            'go_contact_id' => $contactobj->id,
            'address' => json_encode($contactobj->address ?? '-'),
            'company_id' => $contactobj->locationId,
            'titan_customer_id' => $request->titan_customer_id ?? '-',
            'go_response' => json_encode($contactobj),
        ]);

        return $contact;
    }
}

function getContactName($contact)
{
    $contact = Contact::where('go_contact_id', $contact)->first();
    if ($contact) {
        $name = json_decode($contact->go_response)->firstName ?? '-';
        $name .= ' ';
        $name .= json_decode($contact->go_response)->lastName ?? '-';
        $con_name = $name;
    } else {
        $con_name = '-';
    }
    return $con_name;
}

function find_location($location)
{
    return User::where(['location' => $location])->first();
}

function contactObject($request)
{
    $contact = new stdClass;
    $contact->contact_id  = $request->id ?? $request->contact_id;
    $contact->firstName  = $request->firstName  ?? $request->first_name ?? '-';
    $contact->lastName  = $request->lastName ?? $request->last_name ?? '-';
    $contact->email  = $request->email ?? $request->email;
    $contact->phone  = $request->phone  ?? '-';
    $contact->locationId  = $request->locationId;

    $addr = [
        'street' => $contact->street ?? '-',
        'unit' => $contact->unit ?? '-',
        'city' => $contact->city ?? '-',
        'state' => $contact->state ?? '-',
        'zip' => $contact->zip ?? '-',
        'country' => $contact->country ?? 'PK',
        'latitude' => $contact->latitude ?? 0,
        'longitude' => $contact->longitude ?? 0,
    ];

    $contact->address = $addr;
    return $contact;

}

function extract_location_id($request)
{
    if (isset($request->calendar)) {
        $loc = $request['location']['id'];
    } else {
        $loc = $request->location_id;
    }
    return $loc;
}

function extract_contact_id($request)
{
    $opp = ['OpportunityCreate', 'OpportunityStageUpdate', 'OpportunityStatusUpdate', 'OpportunityAssignedToUpdate', 'OpportunityMonetaryValueUpdate'];

    if (isset($request->calendar)) {
        $contact_id = $request->contact_id;
    } elseif (property_exists($request, 'monetary_value') || property_exists($request, 'monetaryValue')) {
        $contact_id = $request->contact_id;
    } else {
        $contact_id = $request->id;
    }

    return $contact_id;
}

function check_contact($contact_id)
{
    $dbcontact = Contact::where('go_contact_id', $contact_id)->first();
    if (!$dbcontact) {

        $res =  ghl_api_call('contacts/' . $contact_id, 'GET', '', [], true);
        if ($res && property_exists($res, 'contact')) {
            $g_response = contactObject($res->contact);
            $dbcontact = saveContactToDb($g_response);
        }
        if ($res && property_exists($res, 'error')) {
            return false;
        }
    }
    // return $dbcontact;
    $ghl_contact = ghl_api_call('contacts/' . $dbcontact->go_contact_id);
    if ($dbcontact) {
        $ghl_contact = ghl_api_call('contacts/' . $dbcontact->go_contact_id);
        $ghl_contact = contactObject($ghl_contact->contact);

        if (str_replace('"', "", $dbcontact->go_response) == str_replace('"', "", json_encode($ghl_contact))) {
            return $dbcontact->titan_customer_id;
        } else {
            $con = saveContactToDb($ghl_contact);
            return $dbcontact->titan_customer_id;
        }
    } else {
        $ghl_contact = saveContactToDb($g_response);
        return $ghl_contact->titan_customer_id;
    }
}

function save_sync($data, $id = null)
{
    $is_update = true;
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
    ];
    foreach (array_keys($data) as $k) {
        if (isset($req[$k])) {
            $data[$k] = $req[$k];
        }
    }
    // $data['titan_location_name'] = $data['location_name'];
    // $data['titan_location_id'] = $data['location'];
    // unset($data['location_name']);
    // unset($data['location']);
    $data['location_id'] = $data['location_id'];

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

    $check = SyncSettings::where($to_check);
    if (!is_null($id)) {
        $check->where('id', '<>', $id);
    }
    $check = $check->first();
    if (!$check) {
        if (is_null($id)) {
            SyncSettings::create($data);
        } else {
            SyncSettings::where('id', $id)->update($data);
        }
    } else {
        $is_update = false;
    }
    $resp = ['status' => 'success', 'message' => 'Sync Setting added successfully'];
    if (!$is_update) {
        $resp = ['status' => 'error', 'message' => 'Same Sync Setting already exists'];
    }

    return $resp;
}

function check_sync($request)
{
    $to_check = [
        // 'calendar_id' => '',
        'pipeline_id' => '',
        'pipeline_stage_id' => '',
        'oppurtunity_status' => '',
        // 'business_unit' => '',
        // 'titan_location_id' => '',
        // 'campaign' => '',
        // 'priority' => '',
        // 'job_type' => '',
        // 'slot' => '',
        'location_id' => '',
    ];

    if (isset($request->calendar)) {
        $to_check['calendar_id'] = $request->calendar;
    }
    $check = SyncSettings::where($to_check)->get();
    if (count($check) == 1) {
        return $check->first();
    }
}

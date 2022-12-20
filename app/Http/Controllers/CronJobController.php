<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Opportuninty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Setting;
use App\Models\SyncSettings;
use Illuminate\Log\Logger;
use stdClass;

class CronJobController extends Controller
{
    public function customField()
    {
        $contact_id = 'ZNLRccjh5nvSroZZ75tN';
        $fields = ['test_field' => '123', 'test_field2' => '456', 'test_fields3' => '789'];
        $send = setCustomFields($fields);

        $con =  sendTagOrCustomFields($contact_id, '', $send);
    }
    public function customerObj($contact, $customer, $for = "ghl")
    {
        $obj = new stdClass;
        $obj->titan_customer_id = $contact->customerId;
        $obj->name = $customer->name ?? '-';
        if ($contact->type == 'Email')
            $obj->email = $contact->value ?? '-';
        if ($contact->type == 'Phone')
            $obj->phone = $contact->value ?? '-';
        if ($for == 'titan') {
            $obj->address = $customer->address ?? '-';
        } else {
            $obj->address1 = $customer->address->street ?? '-';
            $obj->city = $customer->city ?? '-';
            $obj->state = $customer->state ?? '-';
            $obj->postalCode = $customer->zip ?? '-';
            $obj->country = $customer->country ?? '-';
        }
        return $obj;
    }

    public function customerCheck($tenant_id, $contact)
    {
        $newContact = new stdClass;
        $newContact->name = $contact->name;
        $newContact->address = $contact->address;

        $url = 'crm/v2/tenant/' . $tenant_id . '/customers/' . $contact->id . '/contacts';
        $customer = curl_request($url, 'GET');
        //  Log::info('customerCheck', ['customer' => $customer]);
        if ($customer && property_exists($customer, 'data')) {
            $customers = $customer->data;
            if (is_array($customers)) {
                foreach ($customers as $key => $value) {
                    if ($value->type == 'Email') {
                        $newContact->email = $value->value;
                    }
                    if ($value->type == 'Phone') {
                        $newContact->phone = $value->value;
                    }
                }
            }
        }
        $ghl_contact = null;

        if (property_exists($newContact, 'email',) || property_exists($newContact, 'phone')) {
            $newContact->email = $newContact->email ?? '-';
            $go_response = json_encode($newContact);
            $newContact->phone = $newContact->phone ?? '-';
            $mycontact = new stdClass;
            $mycontact->name = $contact->name;
            if ($newContact->email != '-') {
                $mycontact->email = $newContact->email;
            }
            if ($newContact->phone != '-') {
                $mycontact->phone = $newContact->phone;
            }
            $mycontact->city = recheck($newContact->address->city ?? '');
            $mycontact->country = recheck($newContact->address->country ?? '');
            $mycontact->state = recheck($newContact->address->state ?? '');
            $mycontact->address1 = recheck($newContact->address->street ?? '');

            $mycontact->postalCode = recheck($newContact->address->zip);
            unset($mycontact->country);
            $dbcustomer = Contact::where('titan_customer_id', $contact->id)
                // by me at home
                ->where('company_id', login_id())
                ->first();
            // dd($dbcustomer,$newContact);
            if ($dbcustomer) {
                if ($dbcustomer->go_response !== json_encode($newContact)) {
                    $dbcustomer->go_response = $go_response;
                    //send custom field to ghl

                    $h = setCustomFields(['titan_customer_id' => $dbcustomer->titan_customer_id]);
                    //by me at home 
                    // $con =  sendTagOrCustomFields($dbcustomer->contact_id, '', $h);
                    $mycontact->customFields = $h;
                    $ghl_contact = pushghlContact($mycontact, $dbcustomer->go_contact_id);
                    if ($ghl_contact && property_exists($ghl_contact, 'contact')) {
                        $dbcustomer->save();
                    }
                } else {
                    // my side
                    // $dbcustomer = $dbcustomer;
                }
            } else {
                $dbcustomer = new Contact();
                $dbcustomer->titan_customer_id = $contact->id;
                $dbcustomer->go_response = $go_response;
                $dbcustomer->company_id = login_id();
                $ghl_contact = pushghlContact($mycontact);
                if ($ghl_contact && property_exists($ghl_contact, 'contact')) {
                    $dbcustomer->go_contact_id = $ghl_contact->contact->id;
                    $dbcustomer->save();
                }
            }
            return $dbcustomer;
        }
    }

    public function jobCheck($tenant_id, $job)
    {
        $url = 'crm/v2/tenant/' . $tenant_id . '/customers/' . $job->customerId;
        $customer = curl_request($url, 'GET');

        if ($customer && $customer->id) {
            $customer = $this->customerCheck($tenant_id, $customer);
            if ($customer) {
                $g_respo = json_decode($customer->go_response);
                $sync = SyncSettings::query();
                $check_fields = [
                    'titan_location_id' => $job->locationId,
                    'business_unit' => $job->businessUnitId,
                    'campaign' => $job->campaignId,
                    'job_type' => $job->jobTypeId,
                    'priority' => $job->priority,
                    'is_default' => 1,
                    'location_id' => login_id(),
                ];


                $sendJob = new stdClass;
                $sync = $sync->where($check_fields)->orWhere('location_id', login_id())->first();
                if ($sync) {
                    $sendJob->pipelineId = $sync->pipeline_id;
                    $sendJob->locationId = get_values_by_id('location_id', login_id());
                    $sendJob->pipelineStageId = $sync->stage_id;
                    $sendJob->name = $job->name ?? 'Test Job' . $job->id;
                    $sendJob->status = $sync->oppurtunity_status;
                    $sendJob->contactId = $customer->go_contact_id;
                    $p = pushOpportunityGhl($sendJob);
                    if ($p && property_exists($p, 'opportunity')) {
                        $dbjob = new Opportuninty();
                        $dbjob->job_id = $job->id;
                        $dbjob->opportunity_id = $p->opportunity->id;
                        $dbjob->location_id = login_id();
                        $dbjob->go_response = json_encode($p);
                        $dbjob->titan_response = json_encode($job);
                        $dbjob->save();


                        $confields = [
                            'titan_location_id' => $job->locationId,
                            'business_unit' => $sync->business_unit_name ?? '',
                            'campaign' => $sync->campaign_name,
                            'job_type' => $sync->job_type_name,
                            'priority' => $sync->priority,
                        ];

                        $sendToContact = setCustomFields($confields);
                    }
                    // call this function for job cancel resaons
                    // $jobcancelreason = jobCancelReasons($tenant_id, $job->id);
                    $nots = createNotesObject($sync, $customer, $job, 'jobs');
                }
            }
        } else {
            $sendJob = null;
        }

        return true;
    }

    public function projectCheck($tenant_id, $project)
    {
        $url = 'crm/v2/tenant/' . $tenant_id . '/customers/' . $project->customerId;
        $customer = curl_request($url, 'GET');
        if ($customer && $customer->id) {
            $customer = $this->customerCheck($tenant_id, $customer);
            if ($customer) {
                setCustomFields(['titan_project_id' => $project->id]);
                //write notes on the project
                $nots = createNotesObject('', $customer, $project, 'projects');
            }
        }
    }

    public function init_titan(Request $request)
    {
        session()->put('cronjob', 1);
        $tenants = Setting::with('user')->where('key', 'titan_tenant_id')
            // put my me at home
            ->where('company_id', login_id())
            ->get();

        // dd($tenants);

        foreach ($tenants as $tenant) {
            if ($tenant->user) {
                session()->put('location_id', $tenant->user->id);
                $tenant_id = $tenant->value;
                $url = 'crm/v2/tenant/' . $tenant_id . '/customers?' . get_titan_time('-1 days');
                $contacts = curl_request($url, 'GET', '');
                if ($contacts && property_exists($contacts, 'data')) {
                    $contacts = $contacts->data;
                } else {
                    $contacts = [];
                }

                foreach ($contacts as $contact) {
                    $this->customerCheck($tenant_id, $contact);
                }
            }
        }
    }

    //setup for jobs
    public function init_titan_jobs(Request $request)
    {
        @ini_set('max_execution_time', 0);
        @set_time_limit(0);
        session()->put('cronjob', 1);
        $tenants = Setting::with('user')->where('key', 'titan_tenant_id')
            // put by me at home
            ->where('company_id', login_id())
            ->get();


        foreach ($tenants as $tenant) {
            if ($tenant->user) {
                session()->put('location_id', $tenant->user->id);
                $tenant_id = $tenant->value;
                $url = 'jpm/v2/tenant/' . $tenant_id . '/jobs?' . get_titan_time('-1 days');
                $jobs = curl_request($url, 'GET', '');

                if ($jobs && property_exists($jobs, 'data')) {
                    $jobs = $jobs->data;
                } else {
                    $jobs = [];
                }

                foreach ($jobs as $job) {
                    $this->jobCheck($tenant_id, $job);
                }
            }
        }
    }

    public function init_titan_projects(Request $request)
    {
        session()->put('cronjob', 1);
        $tenants = Setting::with('user')->where('key', 'titan_tenant_id')->get();
        foreach ($tenants as $tenant) {
            if ($tenant->user) {
                session()->put('location_id', $tenant->user->id);
                $tenant_id = $tenant->value;
                $url = 'jpm/v2/tenant/' . $tenant_id . '/projects?' . get_titan_time('-5 days');
                $projects = curl_request($url, 'GET', '');
                if ($projects && property_exists($projects, 'data')) {
                    $projects = $projects->data;
                } else {
                    $projects = [];
                }

                foreach ($projects as $project) {
                    $this->projectCheck($tenant_id, $project);
                }
            }
        }
    }

    public function invoiceCheck($tenant_id, $invoice)
    {
        $url = 'crm/v2/tenant/' . $tenant_id . '/customers/' . $invoice->customerId;
        $customer = curl_request($url, 'GET');
        if ($customer && $customer->id) {
            $customer = $this->customerCheck($tenant_id, $customer);
            if ($customer) {
                $nots = createNotesObject('', $customer, $invoice, 'invoices');
            }
        }
    }

    public function init_titan_invoices(Request $request)
    {
        session()->put('cronjob', 1);
        $tenants = Setting::with('user')->where('key', 'titan_tenant_id')->get();
        foreach ($tenants as $tenant) {
            if ($tenant->user) {
                session()->put('location_id', $tenant->user->id);
                $tenant_id = $tenant->value;
                $url = 'accounting/v2/tenant/' . $tenant_id . '/invoices?' . get_titan_time('-5 days');
                $invoices = curl_request($url, 'GET', '');
                if ($invoices && property_exists($invoices, 'data')) {
                    $invoices = $invoices->data;
                } else {
                    $invoices = [];
                }

                foreach ($invoices as $invoice) {
                    $this->invoiceCheck($tenant_id, $invoice);
                }
            }
        }
    }

    public function appointmentCheck($tenant_id, $appointment)
    {
        $url = 'crm/v2/tenant/' . $tenant_id . '/customers/' . $appointment->customerId;
        $customer = curl_request($url, 'GET');
        if ($customer && $customer->id) {
            $customer = $this->customerCheck($tenant_id, $customer);
            if ($customer) {
                $name = $appointment->name ?? 'Test Appointment';
                $contact_id = $customer->go_contact_id;
                $location_id = session('location_id');
                $calendar_id = get_values_by_id('titan_nonjob_booking_calendar', login_id());
                $start = date('Y-m-d H:i:s', strtotime($appointment->start)) ?? date('Y-m-d H:i:s');

                $nApp = new stdClass;
                $nApp->calendarId = $calendar_id;
                $nApp->locationId = $location_id;
                $nApp->contactId = $contact_id;
                $nApp->startTime = $start;
                $nApp->title = $name;

                $jb = sendAppointmentToGhl($nApp);
                if ($jb && $jb->id) {
                    $nots = createNotesObject('', $customer, $appointment, 'appointments');
                }
            }
        }
    }
    public function init_nonjob_appointments(Request $request)
    {
        $jb = ghl_api_call('calendars/events/appointments/' . session('titan_nonjob_booking_calendar', login_id()));

        dd($jb);
        session()->put('cronjob', 1);
        $tenants = Setting::with('user')->where('key', 'titan_tenant_id')->get();
        foreach ($tenants as $tenant) {
            if ($tenant->user) {
                session()->put('location_id', $tenant->user->id);
                $tenant_id = $tenant->value;
                $url = 'dispatch/v2/tenant/' . $tenant_id . '/non-job-appointments?' . get_titan_time('-5 days');
                $appointments = curl_request($url, 'GET', '');
                if ($appointments && property_exists($appointments, 'data')) {
                    $appointments = $appointments->data;
                } else {
                    $appointments = [];
                }

                foreach ($appointments as $appointment) {
                    $this->appointmentCheck($tenant_id, $appointment);
                }
            }
        }
    }
}

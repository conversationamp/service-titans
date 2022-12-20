<?php

namespace App\Http\Controllers;

use App\Models\Opportuninty;
use App\Models\Setting;
use App\Models\SyncSettings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use stdClass;
use Termwind\Components\Dd;

class MainController extends Controller
{

    public function contactObject1($request)
    {
        $contact = new stdClass;
        $contact->contact_id  = $request->id ?? $request->contact_id;
        $contact->firstName  = $request->firstName  ?? $request->first_name;
        $contact->lastName  = $request->lastName ?? $request->last_name;
        $contact->email  = $request->email ?? $request->email;
        $contact->phone  = $request->phone ?? $request->phone;
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

    public function calendarObject($request)
    {
        $cal = $request->calendar;
        $calendar = new stdClass;
        $calendar->id = $cal['id'];
        $calendar->name  = $cal['calendarName'] ?? '';
        $calendar->appointment_id = $cal['appointmentId'] ?? null;
        $calendar->appointment_status = $cal['appoinmentStatus'] ?? null;
        $calendar->start_time = $cal['startTime'] ?? null;
        $calendar->end_time = $cal['endTime'] ?? null;
        $calendar->status = $cal['status'] ?? null;
        return $calendar;
    }

    public function opportunityObject($request)
    {
        $job = new stdClass;
        $job->location_id = $request->locationId ?? null;
        $job->job_id = $request->jobId ?? $request->job_id;
        $job->contact_id = $request->contactId ?? $request->contact_id;
        $job->monetary_value = $request->monetaryValue ?? $request->monetary_value;
        $job->name = $request->name ?? $request->name;
        $job->pipeline_id = $request->pipelineId;
        $job->pipeline_stage_id = $request->pipelineStageId;
        $job->oppurtunity_status = $request->status;
        $job->oppurtunity_id = $request->id ?? $request->opportunity_id;
        return $job;
    }

    public function invoiceObj($invoice_id)
    {
        // dd("Invoice=> " .$invoice_id);
        $invoice = new stdClass;
        $invoice->invoicedOn = date('Y-m-d h:iA');
        // $invoice->subtotal = $request->monetaryValue;
        $invoice->adjustmentToId = $invoice_id;
        return $invoice;
    }

    public function appointmentCallGtoS($userObj, $opportunityObj, $invoiceObj)
    {
        $contact = contactObject($userObj);
        $job = $this->opportunityObject($opportunityObj);
        $invoice = $this->invoiceObj($invoiceObj);
        $calendar = $this->calendarObject($userObj);
        dd($contact, $job, $invoice, $calendar);
    }

    public function serviceTitanJob($request, $type)
    {
        // $loc = $type == 'cal' ? $request['location']['id'] : $request->location_id;

        $loc = extract_location_id($request);
        $contact_id = extract_contact_id($request);
        $location = find_location($loc);
        $go_contact = check_contact($contact_id);
        $sync = SyncSettings::query();

        if ($type == 'cal') {
            $cal_id = $request->calendar['id'];
            $app_status = $request->calendar['appoinmentStatus'];
            $sync = $sync->where(['calendar_id' => $cal_id, 'appointment_status' => $app_status, 'location_id' => $loc, 'is_default' => 1])->orWhere(['location_id' => $loc, 'is_default' => 1])->first();
            $start_time = $request->calendar['startTime'];
            $end_time = $request->calendar['endTime'];
            $invoice_id  = $sync->invoice_id;
        } else {
            $sync = $sync->where(['pipeline_id' => $request->pipeline_id, 'pipeline_stage_id' => $request->pipeline_stage_id, 'oppurtunity_status' => $request->oppurtunity_status, 'location_id' => $loc, 'is_default' => 1])->orWhere(['location_id' => $loc, 'is_default' => 1])->first();
            $start_time = date('Y-m-d h:iA');
            $convertedTime = date('Y-m-d h:iA', strtotime('+' . $sync->slot . ' minutes', strtotime($start_time)));
            $end_time = $convertedTime;
            $invoice_id  = $sync->invoice_id;
        }

        // invoice object

        $job = new stdClass;
        $job->customerId = $go_contact;
        $job->locationId = $sync->titan_location_id;
        $job->businessUnitId = $sync->business_unit;
        $job->jobTypeId = $sync->job_type;
        $job->priority = ucwords($sync->priority);
        $job->campaignId = $sync->campaign;
        $job->invoice_id = $invoice_id;

        $cal_obj = new stdClass;
        $cal_obj->start = $start_time;
        $cal_obj->end = $end_time;
        $cal_obj->arrivalWindowStart = '';
        $cal_obj->arrivalWindowEnd = '';
        $cal_obj->technicianIds = $sync->technician_id;
        $job->appointments = [$cal_obj];

        return $job;
    }

    public function ghlWebhook(Request $request)
    {
        $opp = ['OpportunityCreate', 'OpportunityStageUpdate', 'OpportunityStatusUpdate', 'OpportunityAssignedToUpdate', 'OpportunityMonetaryValueUpdate'];

        if (isset($request->calendar)) {
            $comp = find_location($request->location['id']);
        } else {
            $comp = find_location($request->locationId);
        }
        session()->put('location_id', $comp->id);
        if ($request->type == 'ContactCreate' || $request->type == 'ContactTagUpdate') {
            $customer = contactObject($request);
            $res =  saveContactToDb($customer);
            return $res;
        }

        if (isset($request->calendar) || in_array($request->type, $opp)) {
            if (isset($request->calendar)) {
                $loc_id = $request->location['id'];
                $calendar = $this->serviceTitanJob($request, 'cal');
                //  unset invoice_id
                $invoice_id = $calendar->invoice_id;
                unset($calendar->invoice_id);

                $tenant_id = get_values_by_id('titan_tenant_id', login_id());
                $sendToSt = curl_request('jpm/v2/tenant/' . $tenant_id . '/jobs', 'POST', json_encode($calendar), '', true);

                //success
                if (isset($sendToSt->id)) {
                    // saving the data to db
                    $oppor = Opportuninty::where('location_id', $loc_id)->first() ?? new Opportuninty;
                    $oppor->job_id =  $sendToSt->id;
                    // $oppor->go_response = json_encode($request->all());
                    $oppor->titan_response = json_encode($sendToSt);
                    $oppor->save();

                    //sending the invoice to titan
                    $invoice = $this->invoiceObj($invoice_id);
                    $inv = curl_request('accounting/v2/tenant/' . $tenant_id . '/invoices', 'POST', json_encode($invoice), '', true);
                    if ($inv) {
                        return $inv;
                    }
                }
            }
            if (in_array($request->type, $opp)) {
                $job = $this->opportunityObject($request);
                $calendar = $this->serviceTitanJob($job, 'oppo');
                //  unset invoice_id
                $invoice_id = $calendar->invoice_id;
                unset($calendar->invoice_id);

                // return json_encode($calendar);
                $tenant_id = get_values_by_id('titan_tenant_id', login_id());

                $sendToSt = curl_request('jpm/v2/tenant/' . $tenant_id . '/jobs', 'POST', json_encode($calendar), '', true);

                if (isset($sendToSt->id)) {
                    // saving the data to db
                    $oppor = Opportuninty::where('job_id', $job->job_id)->first() ?? new Opportuninty;
                    $oppor->job_id =  $sendToSt->id;
                    $oppor->opportunity_id = $job->oppurtunity_id;
                    $oppor->location_id = $job->location_id;
                    $oppor->go_response = json_encode($job);
                    $oppor->titan_response = json_encode($sendToSt);
                    $oppor->save();

                    //sending the invoice to titan
                    $invoice = $this->invoiceObj($invoice_id);
                    $inv = curl_request('accounting/v2/tenant/' . $tenant_id . '/invoices', 'POST', json_encode($invoice), '', true);
                    if ($inv) {
                        abort(200, "Invoice sent to ServiceTitan");
                    }
                }
            }
        }
        // dd($this->opportunityObject($request));
        $location = $request->locationId;
        $loc = Setting::where('value', $location)->first();

        if (!$loc) {
            return;
        }

        // $customer = $this->contactObject($request);
        // dd($customer);


        session()->put('location_id', $loc->company_id);
    }

    public function titanWebhook(Request $request)
    {
        dd($request->all());
    }
}

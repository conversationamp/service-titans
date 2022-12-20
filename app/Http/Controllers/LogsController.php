<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Opportuninty;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    public function contactLogs()
    {
        $contacts = Contact::where('company_id', auth()->user()->location)->latest()->get();
        return view('admin.logs.contact', get_defined_vars());
    }

    public function opportunityLogs()
    {
        $opportunities = Opportuninty::where('location_id', auth()->user()->location)->latest()->get();
        return view('admin.logs.opportunity', get_defined_vars());
    }
}

<?php

//namespace App\Http\Controllers;
namespace App\Http\Controllers\Api;

// use App\Http\Controllers\Controller;
use Illuminate\Routing\Controller;
use App\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Middleware\VerifyCsrfToken;
use App\Invoice;

use App\Lead;
use App\Country;
use App\LeadAgent;
use App\LeadFollowUp;
use App\LeadSource;
use App\LeadStatus;
use App\LeadCategory;

class ApiLeadController extends Controller
{

    public function leadList(Request $request)
    {
		$data = [];
		//$data["totalLeads"] = $this->totalLeads = Lead::all();
		$data["sources"] = $this->sources = LeadSource::all();
		$data["categories"] = $this->categories = LeadCategory::all();
		
		$data["totalLeadsCount"] = $this->totalLeads = Lead::all()->count();
		$data["leadAgents"] = $this->leadAgents = LeadAgent::with('user')->has('user')->get();
		
		echo json_encode(["data"=>$data]);
		die('');
	}
	
	public function store()
    {
        $leadStatus = LeadStatus::where('default', '1')->first();

        $lead = new Lead();
        $lead->company_name = $request->company_name;
        $lead->website = $request->website;
        $lead->address = $request->address;
        $lead->client_name = $request->salutation.' '.$request->name;
        $lead->client_email = $request->email;
        $lead->mobile = $request->input('phone_code').' '.$request->input('mobile');
        $lead->office_phone = $request->office_phone;
        $lead->city = $request->city;
        $lead->state = $request->state;
        $lead->country = $request->country;
        $lead->postal_code = $request->postal_code;
        $lead->note = $request->note;
        $lead->category_id = $request->category_id;
        $lead->next_follow_up = $request->next_follow_up;
        $lead->agent_id = $request->agent_id;
        $lead->source_id = $request->source_id;
        $lead->value = ($request->value) ? $request->value : 0;
        $lead->currency_id = company()->currency_id;
        $lead->status_id = $leadStatus->id;
        $lead->save();

        // To add custom fields data
        if ($request->get('custom_fields_data')) {
            $lead->updateCustomFieldData($request->get('custom_fields_data'));
        }

        // Log search
        //$this->LogEntry($lead);
		die(json_encode(["status" => true]));
    }
	
	public function update(UpdateRequest $request, $id)
    {
        $lead = Lead::findOrFail($id);
        $lead->company_name = $request->company_name;
        $lead->website = $request->website;
        $lead->address = $request->address;
        $lead->client_name = $request->client_name;
        $lead->client_email = $request->email;
        $lead->mobile = $request->input('phone_code').' '.$request->input('mobile');
        $lead->office_phone = $request->office_phone;
        $lead->city = $request->city;
        $lead->state = $request->state;
        $lead->country = $request->country;
        $lead->postal_code = $request->postal_code;

        $lead->note = $request->note;
        $lead->status_id = $request->status;
        $lead->source_id = $request->source;
        $lead->category_id = $request->category_id;
        $lead->next_follow_up = $request->next_follow_up;
        $lead->agent_id = $request->agent_id;
        $lead->value = ($request->value) ? $request->value : 0;
        $lead->currency_id = company()->currency_id;
        $lead->save();

        // To add custom fields data
        if ($request->get('custom_fields_data')) {
            $lead->updateCustomFieldData($request->get('custom_fields_data'));
        }
		die(json_encode(["status" => true]));
    }
	
	/**
     * @param CommonRequest $request
     * @return array
     */
    public function changeStatus(Request $request)
    {
        $lead = Lead::findOrFail($request->leadID);
        $lead->status_id = $request->statusID;
        $lead->save();

		return json_encode(["status" => true]);
    }
	
}
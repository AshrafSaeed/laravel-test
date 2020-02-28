<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\CampaignRequest;
use App\Repositories\Campaign\CampaignRepositoryImplement;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;


class CampaignController extends Controller
{
    protected $campaign;

    public function __construct(CampaignRepositoryImplement $campaign ) {
        
        return $this->campaign = $campaign;
    
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (Gate::denies('campaign.view', Auth::user())) {
            return redirect('home')->with('status', 'You are not authorize to view campaign');

        }

        // Get All Campaigns 
        $campaigns = $this->campaign->all();

        // Set Campaign for View 
        return view('campaign.all', compact('campaigns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Get campaign data 
        $campaign_data = $this->campaign->drops();

        // Set Campaign for View 
        return view('campaign.create', $campaign_data);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CampaignRequest $request)
    {
        // Adding New campaign 
        $status = $this->campaign->create($request);

        return redirect('campaign')->with('status', $status);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function edit($campaign_id)
    {
        // Get Campaign data
        $campaign_data = $this->campaign->get($campaign_id);

        return view('campaign.update', $campaign_data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Campaign  $Campaign
     * @return \Illuminate\Http\Response
     */
    public function update(CampaignRequest $request, $campaign_id)
    {
        // updating campaign data
        $status = $this->campaign->update($campaign_id, $request);

        return redirect('campaign')->with('status', $status);
    }

    /**
     * Publish the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Campaign  $Campaign
     * @return \Illuminate\Http\Response
     */
    public function publish($campaign_id)
    {
        // updating campaign data
        $status = $this->campaign->publish($campaign_id);

        return redirect('campaign')->with('status', $status);
    }

    /**
     * Unpublish the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Campaign  $Campaign
     * @return \Illuminate\Http\Response
     */
    public function unpublish($campaign_id)
    {
        // updating campaign data
        $status = $this->campaign->unpublish($campaign_id);

        return redirect('campaign')->with('status', $status);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Campaign  $Campaign
     * @return \Illuminate\Http\Response
     */
    public function destroy($campaign_id)
    {
       
        // Deleteing spacific records 
        $status = $this->campaign->destroy($campaign_id);
        
        return redirect('campaign')->with('status', $status);

    }
}

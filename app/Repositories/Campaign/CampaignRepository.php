<?php

namespace App\Repositories\Campaign;

use App\Brand;
use App\Media;
use App\Location;
use App\Campaign;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CampaignRepository implements CampaignRepositoryImplement 
{	
	public function all() {

        // Get All Campaigns by Current User, Order By and Paginate method
        return Campaign::with(['location', 'brand'])->GetAllCampaign();

	}

    public function drops() {

        // Get campaign Brands 
        $brands = Brand::GetAll();

        // Get All Locations 
        $locations = Location::GetAll();

        return compact('brands', 'locations');

    }

	public function create( $request) {

		if (Gate::denies('campaign.create', Auth::user())) {
            return __('messages.cam-create-unauth');
        }

        try {

            // Transaction Begin
            DB::beginTransaction();     

            // Create  Campaign 
            $campaign = Campaign::create([
                'name' => $request->name,
                'body' => $request->body,
                'user_id' => Auth::id(),
                'brand_id' => $request->brand,
                'location_id' => $request->location
            ]);

            // Get File names (Orginal and For save)
            $fileOriginalName = $request->banner->getClientOriginalName();
            $fileName = 'media_'.date('Y_is').'_'.$request->banner->getClientOriginalName();

            // Save Campaign Media file
            $path = $request->banner->storeAs('media', $fileName);   

            // Create Media Object
            $media = new Media([
                'name' => $fileOriginalName,
                'path' => $path,
            ]);

            // Create Media transaction in DB 
            $media = $campaign->media()->save($media);

            // Transaction Commit
            DB::commit();

            return __('messages.cam-create-success');

        } catch (Exception $e) {
            // anula la transacion
            DB::rollBack();

            return __('messages.cam-create-unsuccess');
        }

	}

	public function get($campaign_id) {

        // Find campaign 
        $campaign = Campaign::findOrFail($campaign_id);

        // Get campaign Brands 
        $brands = Brand::GetAll();

        // Get All Locations 
        $locations = Location::GetAll();

        return  compact('campaign', 'brands', 'locations');
	}

	public function update($campaign_id, $request) {

        if (Gate::denies('campaign.update', Auth::user())) {
            return __('messages.cam-update-unauth');
        }
        
        try {

            // Transaction Begin
            DB::beginTransaction();     

            // Update Campaign
            $campaign = Campaign::find($campaign_id);
            $campaign->name = $request->name;
            $campaign->body = $request->body;
            $campaign->user_id = Auth::id();
            $campaign->brand_id = $request->brand;
            $campaign->location_id = $request->location;
            $campaign->save();

            if ($request->hasFile('banner')) {

                // Get File names (Orginal and For save)
                $fileOriginalName = $request->banner->getClientOriginalName();
                $fileName = 'media_'.date('Y_is').'_'.$request->banner->getClientOriginalName();

                // Save Campaign Media file
                $path = $request->banner->storeAs('media', $fileName);   

                // Update Media transaction in DB 
                $media = $campaign->media()->update([
                    'name' => $fileOriginalName,
                    'path' => $path,
                ]);
            }

            // Transaction Commit
            DB::commit();

            return __('messages.cam-update-success');

        } catch (Exception $e) {
            // rollback transaction
            DB::rollBack();

            return __('messages.cam-update-unsuccess');
        }

	}

    public function publish($campaign_id)
    {

        if (Gate::denies('campaign.publish', Auth::user())) {
            return __('messages.cam-p-unauthorize');
        }

        try{

            Campaign::where('id', $campaign_id)->update(['is_publish' => true]);

            return __('messages.cam-publish-success');

        } catch (Exception $e) {

            return __('messages.cam-publish-unsuccess');
        
        }

    }

    public function unpublish($campaign_id)
    {
        if (Gate::denies('campaign.unpublish', Auth::user())) {
            return __('messages.cam-u-unauthorize');
        }

        try{

            Campaign::where('id', $campaign_id)->update(['is_publish' => false]);
            
            return __('messages.cam-unpublish-success');

        } catch (Exception $e) {

            return __('messages.cam-unpublish-unsuccess');
        
        }

    }

	public function destroy($campaign_id) {

        if (Gate::denies('campaign.delete', Auth::user())) {
            return __('messages.cam-delete-unauth');
        }

	    try {	

            // Find Campaign if Exist
            $campaign = Campaign::FindOrFail($campaign_id);

            // Delete Campaign
            $campaign->delete();
            $campaign->media->delete();


            return __('messages.cam-delete-success');

	    } catch (Exception $e) {

            return __('messages.cam-delete-unsuccess');

        }

	}

	
}
<?php

namespace App\Repositories\Location;

use App\Location;
use Illuminate\Support\Facades\{ DB, Auth, Gate };

class LocationRepository implements LocationRepositoryImplement 
{	
	public function all() {
	
        // Get All Locations 
        return Location::GetAll();

	}

	public function create( $request) {

        if (Gate::denies('location.create', Auth::user())) {
            return __('messages.loc-create-unauth');
        }

		try {
            // Create  Location 
            $location = Location::create([
                'name' => $request->name,
                'user_id' => Auth::id()
            ]);

            return __('messages.loc-create-success');

        } catch (Exception $e) {

            return __('messages.loc-create-unsuccess');
        }

	}

	public function get($location_id) {

        return Location::findOrFail($location_id);
	}

	public function update($location_id, $request) {

        if (Gate::denies('location.update', Auth::user())) {
            return __('messages.loc-update-unauth');
        }

        try {

            // Update Location
            $location = Location::find($location_id);
            $location->name = $request->name;
            $location->save();

            return __('messages.loc-update-success');

        } catch (Exception $e) {

            return __('messages.loc-update-unsuccess');
        }

	}

	public function destroy($location_id) {

        if (Gate::denies('location.delete', Auth::user())) {
            return __('messages.loc-delete-unauth');
        }

	    try {

			// Find Location if Exist
	        $location = Location::FindOrFail($location_id);

	        // Delete Location
	        $location->delete();

	        return __('messages.loc-delete-success');

	    } catch (Exception $e) {

            return __('messages.loc-delete-unsuccess');
        }

	}
	
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LocationRequest;
use App\Repositories\Location\LocationRepositoryImplement;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;


class LocationController extends Controller
{

    protected $location;

    public function __construct(LocationRepositoryImplement $location ) {
        
        return $this->location = $location;
    
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        if (Gate::denies('location.view', Auth::user())) {
            return redirect('home')->with('status', 'You are not authorize to view location');
        }

        // Get All Locations 
        $locations = $this->location->all();

        // Set location for View 
        return view('location.all', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('location.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LocationRequest $request)
    {
        $status = $this->location->create($request);
        return redirect('location')->with('status', $status);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit($location_id)
    {
        // Get Location
        $location = $this->location->get($location_id);
        return view('location.update', compact('location'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $location_id)
    {
        // Update Location
        $status = $this->location->update($location_id, $request);

        return redirect('location')->with('status', $status);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy($location_id)
    {
        // Delete Recotrd by Location ID
        $status = $this->location->destroy($location_id);

        return redirect('location')->with('status', $status);

    }
}

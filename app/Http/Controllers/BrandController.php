<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BrandRequest;
use App\Repositories\Brand\BrandRepositoryImplement;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{
    protected $brand;

    public function __construct(BrandRepositoryImplement $brand ) {
        
        return $this->brand = $brand;
    
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('brand.view', Auth::user())) {
            return redirect('home')->with('status', 'You are not authorize to view brand');
        }

        // Get All Brands 
        $brands = $this->brand->all(); 

        // Set Brand for View 
        return view('brand.all', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('brand.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */

    public function store(BrandRequest $request)
    {
        // Create new Brand
        $message = $this->brand->create($request);
        return redirect('brand')->with('status', $message);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit($brand_id)
    {
        $brand = $this->brand->get($brand_id);

        return view('brand.update', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(BrandRequest $request, $brand_id)
    {
        $message = $this->brand->update($brand_id, $request);

        return redirect('brand')->with('status', $message);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy($brand_id)
    {

        $result = $this->brand->destroy($brand_id);
        
        return redirect('brand')->with('status', $result);

    }
}

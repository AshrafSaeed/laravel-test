<?php

namespace App\Repositories\Brand;

use App\Brand;
use App\Media;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class BrandRepository implements BrandRepositoryImplement 
{	
	public function all() {
	
        // Get All Brands by Current User, Order By and Paginate method
        return Brand::ByCurrentUserAndOrderBy('desc')->paginate(5);
	}

	public function create( $request) {

        if (Gate::denies('brand.create', Auth::user())) {
            return __('messages.brand-create-unauth');
        }

		try {
            // Transaction Begin
            DB::beginTransaction();     

            // Create  Brand 
            $brand = Brand::create([
                'name' => $request->name,
                'description' => $request->description,
                'user_id' => Auth::id()
            ]);

            // Get File names (Orginal and For save)
            $fileOriginalName = $request->brand_logo->getClientOriginalName();
            $fileName = 'media_'.date('Y_is').'_'.$request->brand_logo->getClientOriginalName();

            // Save Brand Media file
            $path = $request->brand_logo->storeAs('media', $fileName);   

            // Create Media Object
            $media = new Media([
                'name' => $fileOriginalName,
                'path' => $path,
            ]);

            // Create Media transaction in DB 
            $media = $brand->media()->save($media);

            // Transaction Commit
            DB::commit();

            return __('messages.brand-create-success');

        } catch (Exception $e) {

            DB::rollBack();
            return __('messages.brand-create-unsuccess');
        }

	}

	public function get($brand_id) {

        return  Brand::findOrFail($brand_id);
	}

	public function update($brand_id, $request) {

        if (Gate::denies('brand.update', Auth::user())) {
            return __('messages.brand-update-unauth');
        }

        try {

            // Transaction Begin
            DB::beginTransaction();     

            // Update Brand
            $brand = Brand::find($brand_id);
            $brand->name = $request->name;
            $brand->description = $request->description;
            $brand->save();

            if ($request->hasFile('brand_logo')) {

                // Get File names (Orginal and For save)
                $fileOriginalName = $request->brand_logo->getClientOriginalName();
                $fileName = 'media_'.date('Y_is').'_'.$request->brand_logo->getClientOriginalName();

                // Save Brand Media file
                $path = $request->brand_logo->storeAs('media', $fileName);   

                // Update Media transaction in DB 
                $media = $brand->media()->update([
                    'name' => $fileOriginalName,
                    'path' => $path,
                ]);
            }

            // Transaction Commit
            DB::commit();

            return __('messages.brand-update-success');

        } catch (Exception $e) {
            // anula la transacion
            DB::rollBack();

            return __('messages.brand-update-unsuccess');
        }

	}

	public function destroy($brand_id) {

        if (Gate::denies('brand.delete', Auth::user())) {
            return __('messages.brand-delete-unauth');
        }

	    try {

			// Find Brand if Exist
	        $brand = Brand::FindOrFail($brand_id);

	        // Delete Brand
	        $brand->delete();
	        $brand->media->delete();

	        return __('messages.brand-delete-success');

	    } catch (Exception $e) {

            return __('messages.brand-delete-unsuccess');
        }

	}

	
}
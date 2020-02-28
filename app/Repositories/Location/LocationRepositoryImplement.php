<?php

namespace App\Repositories\Location;

interface LocationRepositoryImplement {
	
	public function all(); 

	public function get($brand_id);

	public function create( $request);
	
	public function update($brand_id, $request);

	public function destroy($brand_id);

}
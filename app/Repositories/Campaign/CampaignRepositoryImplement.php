<?php

namespace App\Repositories\Campaign;

interface CampaignRepositoryImplement {
	
	public function all(); 

	public function drops();

	public function get($brand_id);

	public function create( $request);
	
	public function update($brand_id, $request);

    public function publish($campaign_id);

    public function unpublish($campaign_id);

	public function destroy($brand_id);

}
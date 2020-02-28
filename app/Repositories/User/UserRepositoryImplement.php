<?php

namespace App\Repositories\User;

interface UserRepositoryImplement {
	
	public function all(); 

	public function show(); 

	public function create( $request);

   // protected function createuser(array $data);

	public function get($user_id);
	
	public function update($user_id, $request);

	public function destroy($user_id);

	public function active($user_id);

	public function inactive($user_id);
	
	public function allrole();
	
	public function getrole($getrole);

	public function updaterole($user_id, $request);

}
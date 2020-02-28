<?php

namespace App\Repositories\User;

use App\User;
use \Spatie\Permission\Models\Role;
use \Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; 

class UserRepository implements UserRepositoryImplement 
{	

	public function all() 
    {
        // Get All User
        return  User::paginate(10);
	}

    public function show() 
    {
        return Role::all();
    }

	public function create( $request) 
    {

        try {

            $user = $this->createuser($request->all());

            $user->assignRole($request->role);

            return __('messages.user-create-success');

        } catch (Exception $e) {

            return __('messages.user-create-unsuccess');
        }


	}

    protected function createuser(array $data)
    {

        $is_active = (isset($data['is_active']) && $data['is_active'] == 'on') ? 1 : 0;
        
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_active' => $is_active
        ]);

    }


	public function get($user_id) 
    {
        $user = User::find($user_id);
        $roles = Role::all();

        return compact('user', 'roles');
	}

	public function update($user_id, $request) 
    {
        try {

            $is_active = (isset($request->is_active) && $request->is_active == 'on') ? 1 : 0;
            
            $user = User::where('id', $user_id)->update([
                'name' => $request->name,
                'is_active' => $is_active
            ]);

            $user = User::find($user_id);
            $user->assignRole($request->role);

            return __('messages.user-update-success');


        } catch (Exception $e) {

            return __('messages.user-update-unsuccess');
        
        }
	}

    public function destroy($user_id) 
    {
        try {
            // Find user if exist
            $user = User::FindOrFail($user_id);
            // Delete user
            $user->delete();
            
            return __('messages.user-delete-success');

        } catch (Exception $e) {

            return __('messages.user-delete-unsuccess');
        
        }
    }

    public function active($user_id)
    {
        try{

            User::where('id', $user_id)->update(['is_active' => true]);
            
            return __('messages.user-active-success');

        } catch (Exception $e) {

            return __('messages.user-active-unsuccess');
        
        }
    }

    public function inactive($user_id)
    {
        try{

            User::where('id', $user_id)->update(['is_active' => false]);
            return __('messages.user-inactive-success');

        } catch (Exception $e) {

            return __('messages.user-inactive-unsuccess');
        }
    }

    public function allrole()
    {
        return Role::all();
    }

    public function getrole($role_id)
    {
        $role = Role::findOrFail($role_id);
        $permissions = Permission::all();

        return compact('role', 'permissions');
    }

    public function updaterole($user_id, $request)
    {
        try{

            // Transaction Begin
            DB::beginTransaction();    

                $role = Role::findOrFail($user_id);

                $input = $request->except(['permissions']);
                $permissions = $request['permissions'];
                $role->fill($input)->save();

                $allpermissions = Permission::all();

                foreach ($allpermissions as $perm) {
                    $role->revokePermissionTo($perm); 
                }

                foreach ($permissions as $permission) {

                    $p = Permission::where('id', '=', $permission)->firstOrFail(); 

                    $role->givePermissionTo($p);
                }

            DB::commit();

            return __('messages.role-update-success');

        } catch (Exception $e) {

            DB::rollBack();
            return __('messages.role-update-unsuccess');
        }

    }

	
}
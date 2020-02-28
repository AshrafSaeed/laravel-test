<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repositories\User\UserRepositoryImplement;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{

    protected $userrap;

    public function __construct(UserRepositoryImplement $userrap ) {

        $this->middleware(['role:owner']);
        return $this->userrap = $userrap;
    
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->userrap->all();
        return view('auth.all', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = $this->userrap->show();
        return view('auth.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $status = $this->userrap->create($request);
        return redirect('user')->with('status', $status);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($user_id)
    {
        $compact = $this->userrap->get($user_id);
        return view('auth.update', $compact);
    }

    /**
     * Active the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $user_id
     */
    public function update(request $request, $user_id)
    {
        $status = $this->userrap->update($user_id, $request);
        return redirect('user')->with('status', $status);
    }
    /**
     * Active the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $user_id
     */
    public function active($user_id)
    {
        
        $status = $this->userrap->active($user_id);

        return redirect('user')->with('status', $status);

    }


    /**
     * Inactive the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $user_id
     */
    public function inactive($user_id)
    {
        $status = $this->userrap->inactive($user_id);

        return redirect('user')->with('status', $status);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id)
    {
        $status = $this->userrap->destroy($user_id);
        return redirect('user')->with('status', $status);
    }


    /**
     * Role Permission the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $user_id
     */
    public function rolepermission()
    {
        $roles = $this->userrap->allrole();
        return view('auth.role.all', compact('roles'));
    }

      /**
     * Role Permission the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $user_id
     */
    public function editrolepermission($role_id)
    {
        $compact = $this->userrap->getrole($role_id);

        return view('auth.role.update', $compact);
    }

    public function updaterolepermission(Request $request, $user_id) {

        $this->validate($request, [
            'name'=>'required|max:10|unique:roles,name,'.$user_id,
            'permissions' =>'required',
        ]);

        $status = $this->userrap->updaterole($user_id, $request);

        return redirect()->route('role.index')->with('status', $status);
    }

}

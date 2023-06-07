<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    private $AUTH_USER_ID;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Permission::GET_ALL_BY_DESC();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->AUTH_USER_ID = auth()->user()->id;

        $permission = new Permission();
        $permission->name = $request->name;
        $permission->created_by = $this->AUTH_USER_ID;
        $permission->updated_by = $this->AUTH_USER_ID;
        $permission->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $this->AUTH_USER_ID = auth()->user()->id;
        $permission->name = $request->name;
        $permission->updated_at = new \DateTime;
        $permission->updated_by = $this->AUTH_USER_ID;
        $permission->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function delete(Permission $permission)
    {
        Permission::destroy($permission->id);
    }
}

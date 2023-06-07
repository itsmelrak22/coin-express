<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private $AUTH_USER_ID;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Role::GET_ALL_BY_DESC();
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

        $role = new Role();
        $role->name = $request->name;
        $role->created_by = $this->AUTH_USER_ID;
        $role->updated_by = $this->AUTH_USER_ID;
        $role->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $this->AUTH_USER_ID = auth()->user()->id;
        $role->name = $request->name;
        $role->updated_at = new \DateTime;
        $role->updated_by = $this->AUTH_USER_ID;
        $role->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function delete(Role $role)
    {
        Role::destroy($role->id);
    }
}

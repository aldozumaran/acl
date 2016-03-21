<?php

namespace AldoZumaran\Acl\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Acl\Permission;
use App\Models\Acl\Role;
use App\Models\Acl\Section;
use Illuminate\Http\Request;
use App\Models\Acl\PermissionRoleSection;

class AclRolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::get();
        return view('acl::roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('acl::roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Role::create($request->only('code','name','description'));
        return redirect()->route('acl.roles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::findOrFail($id);
        
        $sections = Section::get();
        $permissions = Permission::get();
        return view('acl::roles.show', compact('role','sections','permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('acl::roles.create', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        $role->fill($request->only('code','name','description'))->save();

        return redirect()->route('acl.roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Role::destroy($id);
        return redirect()->route('acl.roles.index');
    }
    public function permission(PermissionRoleSection $permission, Request $request)
    {
        $response = $permission->syncPermission($request->only('role_id','section_id','permission_id'));
      
        return response()->json([
            'response' => $response, 
        ]);
    }
}

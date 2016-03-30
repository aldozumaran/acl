<?php

namespace AldoZumaran\Acl\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Acl\Permission;
use App\Models\Acl\PermissionSectionUser;
use App\Models\Acl\Role;
use App\Models\Acl\Section;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class AclUsersController extends Controller
{
    protected $user;
    private $route;

    public function __construct()
    {
        $user = Config::get('acl.user');
        $this->user = new $user;
        $this->route = \Acl::route('users','index',[],false);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->get();
        return view('acl::users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::get();
        return view('acl::users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $this->user->create($request->only('name','email'));
        if ($request->get('password')){
            $user->password = bcrypt($request->get('password'));
            $user->save();
        }
        $user->roles()->sync($request->get('roles'));
        return redirect()->route($this->route);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->user->findOrFail($id);

        $sections = Section::get();
        $permissions = Permission::get();
        return view('acl::users.show', compact('user','sections','permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles = Role::get();
        $user = $this->user->findOrFail($id);
        $actives = $user->roles()->lists('id')->toArray();
        return view('acl::users.create', compact('user','roles','actives'));
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
        $user = $this->user->find($id);
        $user->fill($request->only('name','email'));
        if ($request->get('password'))
            $user->password = bcrypt($request->get('password'));
        $user->save();
        $user->roles()->sync($request->get('roles'));
        return redirect()->route($this->route);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->user->destroy($id);
        return redirect()->route($this->route);
    }

    public function permission(PermissionSectionUser $permission, Request $request)
    {
        $response = $permission->syncPermission($request->only('user_id','section_id','permission_id'));

        return response()->json([
            'response' => $response,
        ]);
    }
}

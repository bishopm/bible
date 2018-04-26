<?php

namespace Bishopm\Bible\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;
use Bishopm\Bible\Http\Requests\CreateRoleRequest;
use Bishopm\Bible\Http\Requests\UpdateRoleRequest;

class RolesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index()
    {
        $roles = Role::all();
        return view('bible::roles.index', compact('roles'));
    }

    public function edit(Role $role)
    {
        $permissions=Permission::all();
        return view('bible::roles.edit', compact('role', 'permissions'));
    }

    public function create()
    {
        $permissions=Permission::all();
        return view('bible::roles.create', compact('permissions'));
    }

    public function store(CreateRoleRequest $request)
    {
        $role=new Role();
        $role->name=$request->input('name');
        $perms=Permission::wherein('id', $request->input('permissions'))->get();
        $role->save();
        $role->syncPermissions($perms);
        return redirect()->route('admin.roles.index')
            ->withSuccess('New role added');
    }
    
    public function update(Role $role, UpdateRoleRequest $request)
    {
        $role->name=$request->input('name');
        $perms=Permission::wherein('id', $request->input('permissions'))->get();
        $role->syncPermissions($perms);
        $role->save();
        return redirect()->route('admin.roles.index')->withSuccess('Role has been updated');
    }
}

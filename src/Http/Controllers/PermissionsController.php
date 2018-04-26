<?php

namespace Bishopm\Bible\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;
use Bishopm\Bible\Http\Requests\CreatePermissionRequest;
use Bishopm\Bible\Http\Requests\UpdatePermissionRequest;

class PermissionsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index()
    {
        $permissions = Permission::all();
        return view('bible::permissions.index', compact('permissions'));
    }

    public function edit(Permission $permission)
    {
        return view('bible::permissions.edit', compact('permission'));
    }

    public function create()
    {
        return view('bible::permissions.create');
    }

    public function store(CreatePermissionRequest $request)
    {
        $permission=new Permission();
        $permission->name=$request->input('name');
        $permission->save();
        return redirect()->route('admin.permissions.index')
            ->withSuccess('New permission added');
    }
    
    public function update(Permission $permission, UpdatePermissionRequest $request)
    {
        $permission->name=$request->input('name');
        $permission->slug = $request->input('slug');
        $perms=array();
        foreach ($request->input('permissions') as $perm) {
            $perms[$perm]=true;
        }
        $permission->permissions=$perms;
        $permission->save();
        return redirect()->route('admin.permissions.index')->withSuccess('Permission has been updated');
    }

    public function addpermission(Permission $permission, $permissionid)
    {
        $permission->permissions()->attach($permissionid);
    }

    public function removepermission(Permission $permission, $permissionid)
    {
        $permission->permissions()->detach($permissionid);
    }
}

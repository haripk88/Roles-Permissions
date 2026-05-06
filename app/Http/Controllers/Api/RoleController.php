<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:roles_view')->only(['index', 'show']);
        $this->middleware('permission:roles_create')->only(['create', 'store']);
        $this->middleware('permission:roles_update')->only(['edit', 'update']);
        $this->middleware('permission:roles_delete')->only(['destroy']);
    }
    public function index()
    {
        $roles = Role::orderBy('created_at', 'desc')->paginate(10);
        return view('roles.list', ['roles' => $roles]);
    }

    public function create()
    {
        $permissions = Permission::OrderBy('name', 'asc')->get();
        return view('roles.create', ['permissions' => $permissions]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name',
        ]);
        $permissions = $request->permissions;
        if ($validator->passes()) {
            $role = Role::create($request->all());

            if (!empty($permissions)) {
                foreach ($permissions as $permission) {
                    $role->givePermissionTo($permission);
                }
            }
            return redirect()->route('roles.index')->with('success', 'Role created successfully.');
        } else {
            return redirect()->route('roles.create')->withInput()->withErrors($validator);
        }
    }

    public function show($id)
    {
        $permission = Permission::findOrFail($id);
        return response()->json($permission);
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::OrderBy('name', 'asc')->get();
        return view('roles.edit', ['role' => $role, 'permissions' => $permissions]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,' . $id . ',id',
        ]);

        $permissions = $request->permissions;
        if ($validator->passes()) {
            $role = Role::findOrFail($id);
            $role->update($request->all());

            if (!empty($permissions)) {
                $role->syncPermissions($permissions);
                // foreach ($permissions as $permission) {
                //     // $role->syncPermissions($permissions);
                // }
            } else {
                // $role->permissions()->detach();
                $role->syncPermissions([]);
            }
            return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
        } else {
            return redirect()->route('roles.edit', $id)->withInput()->withErrors($validator);
        }
    }


    public function destroy(Request $request)
    {
        $id = $request->id;

        $role = Role::find($id);

        if ($role == null) {
            session()->flash('error', 'Role not found.');
            return response()->json(['error' => 'Role not found.', 'status' => false], 404);
        }
        $role->delete();
        session()->flash('success', 'Role deleted successfully.');

        return response()->json(['success' => 'Role deleted successfully.', 'status' => true], 200);
    }
}

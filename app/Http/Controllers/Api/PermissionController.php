<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::orderBy('created_at', 'desc')->paginate(10);
        return view('permissions.list', ['permissions' => $permissions]);
    }

    public function create()
    {
        return view('permissions.create');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions,name',
            // 'guard_name' => 'required',
        ]);
        if ($validator->passes()) {
            Permission::create($request->all());
            return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
        } else {
            return redirect()->route('permissions.create')->withInput()->withErrors($validator);
        }
        // $request->validate([
        //     'name' => 'required|unique:permissions,name',
        //     'guard_name' => 'required',
        // ]);

        // $permission = Permission::create($request->all());
        // return response()->json($permission, 201);
    }

    public function show($id)
    {
        $permission = Permission::findOrFail($id);
        return response()->json($permission);
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('permissions.edit', ['permission' => $permission]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions,name,' . $id . ',id',
        ]);
        if ($validator->passes()) {
            $permission = Permission::findOrFail($id);
            $permission->update($request->all());
            return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
        } else {
            return redirect()->route('permissions.edit', $id)->withInput()->withErrors($validator);
        }
    }

    // public function destroy($id)
    // {
    //     $permission = Permission::findOrFail($id);
    //     $permission->delete();
    //     return response()->json(null, 204);
    // }

    public function destroy(Request $request)
    {
        $id = $request->id;

        $permission = Permission::find($id);

        if ($permission == null) {
            session()->flash('error', 'Permission not found.');
            return response()->json(['error' => 'Permission not found.', 'status' => false], 404);
        }
        $permission->delete();
        session()->flash('success', 'Permission deleted successfully.');

        return response()->json(['success' => 'Permission deleted successfully.', 'status' => true], 200);
    }
}

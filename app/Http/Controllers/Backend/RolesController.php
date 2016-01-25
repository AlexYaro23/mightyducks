<?php

namespace App\Http\Controllers\Backend;

use App\Models\Role;
use Illuminate\Http\Request;

use App\Http\Requests\Backend\RoleRequest;
use App\Http\Controllers\Controller;
use Laracasts\Flash\Flash;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::all();

        return view('backend.roles.list')->with('roles', $roles);
    }

    public function create()
    {
        return view('backend.roles.create');
    }

    public function store(RoleRequest $request)
    {
        Role::create($request->all());

        Flash::success(trans('general.created_msg'));

        return redirect(route('admin.roles'));
    }

    public function edit(Role $role)
    {
        return view('backend.roles.edit')->with('role', $role);
    }

    public function update(Role $role, RoleRequest $request)
    {
        $role->update($request->all());

        Flash::success(trans('general.updated_msg'));

        return redirect(route('admin.roles'));
    }
}

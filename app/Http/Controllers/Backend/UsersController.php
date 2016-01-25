<?php

namespace App\Http\Controllers\Backend;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests\Backend\UserRequest;
use App\Http\Controllers\Controller;
use Laracasts\Flash\Flash;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        $roles = Role::lists('name', 'id');

        return view('backend.users.list')
            ->with('users', $users)
            ->with('statuses', User::getStatuses())
            ->with('roles', $roles);
    }

    public function edit(User $user)
    {
        $roles = Role::lists('name', 'id');
        return view('backend.users.edit')
            ->with('user', $user)
            ->with('statuses', User::getStatuses())
            ->with('roles', $roles);
    }

    public function update(User $user, UserRequest $request)
    {
        $user->update($request->all());

        $user->roles()->sync($request->input('roleList'));

        Flash::success(trans('general.updated_msg'));

        return redirect(route('admin.users'));
    }
}

<?php

namespace Phrantiques\Security\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;
use Phrantiques\Security\Http\Request\UsersRolesFormRequest;

class UsersRolesController extends Controller
{
    public function index(): View
    {
        $data = [
            'users' => User::orderBy('id')->get(),
            'roles' => Role::orderBy('name')->get(),
        ];

        return view('security::users_roles')->with($data);
    }

    public function attach(UsersRolesFormRequest $request): Response
    {
        $userId = (int) $request->get('user_id');
        $roleId = (int) $request->get('role_id');
        $status = (bool) $request->get('status');

        /** @var User $permission */
        $user = User::findOrFail($userId);

        /** @var Role $role */
        $role = Role::findOrFail($roleId);

        $user->roles()->detach($role);

        if ($status === true) {
            $user->roles()->attach($role);
        }

        return response()->json(['status' => $status]);
    }
}

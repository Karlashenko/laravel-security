<?php

declare(strict_types=1);

namespace Phrantiques\Security\Http\Controllers;

use App\Models\Role;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;
use Phrantiques\Security\Http\Request\RoleFormRequest;

class RolesController extends Controller
{
    public function index(): View
    {
        $roles = Role::get();

        return view('security::roles.index')->withRoles($roles);
    }

    public function create(): View
    {
        return view('security::roles.form')->with([
            'action' => route('security.roles.store'),
            'method' => Request::METHOD_POST,
            'role'   => new Role(),
        ]);
    }

    public function store(RoleFormRequest $request): Response
    {
        $role = Role::create($request->except('_token', '_method'));

        $message = "Роль '{$role->getDisplayName()}' успешно создана.";

        return redirect()->route('security.roles.index')->withMessage($message);
    }

    public function show(Role $role): View
    {
        return view('security::roles.form')->with([
            'action' => route('security.roles.update', $role),
            'method' => Request::METHOD_PATCH,
            'role'   => $role,
        ]);
    }

    public function update(RoleFormRequest $request, Role $role): Response
    {
        $role->update($request->all());

        $message = "Роль '{$role->getDisplayName()}' успешно обновлена.";

        return redirect()->route('security.roles.index')->withMessage($message);
    }

    public function destroy(Role $role): Response
    {
        $role->delete();

        $message = "Роль '{$role->getDisplayName()}' успешно удалена.";

        return redirect()->route('security.roles.index')->withMessage($message);
    }
}

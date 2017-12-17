<?php

declare(strict_types=1);

namespace Phrantiques\Security\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Phrantiques\Security\Models\Rule;
use Phrantiques\Security\Models\Policy;
use Symfony\Component\HttpFoundation\Response;
use Phrantiques\Security\Http\Request\PolicyFormRequest;

class PoliciesController extends Controller
{
    public function index(): View
    {
        $policies = Policy::get();

        return view('security::policies.index')->withPolicies($policies);
    }
    public function create(): View
    {
        $data = [
            'action' => route('security.policies.store'),
            'method' => Request::METHOD_POST,
            'policy' => new Policy(),
            'rules' => Rule::get(),
        ];

        return view('security::policies.form')->with($data);
    }

    public function store(PolicyFormRequest $request): Response
    {
        $policy = Policy::create($request->except('_token', '_method'));

        $message = "Политика '{$policy->name}' успешно создана.";

        return redirect()->route('security.policies.show', $policy)->withMessage($message);
    }

    public function show(Policy $policy): View
    {
        $data = [
            'action' => route('security.policies.update', $policy),
            'method' => Request::METHOD_PATCH,
            'rules' => Rule::get(),
            'policy' => $policy,
        ];

        return view('security::policies.form')->with($data);
    }

    public function update(PolicyFormRequest $request, Policy $policy): Response
    {
        $policy->update($request->all());

        $rules = $request->get('rules');

        $policy->rules()->detach();
        $policy->rules()->attach($rules);

        $message = "Политика '{$policy->name}' успешно обновлена.";

        return redirect()->route('security.policies.show', $policy)->withMessage($message);
    }

    public function destroy(Policy $policy): Response
    {
        $policy->delete();

        $message = "Политика '{$policy->name}' успешно удалена.";

        return redirect()->route('security.policies.index')->withMessage($message);
    }
}

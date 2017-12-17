<?php

declare(strict_types=1);

namespace Phrantiques\Security\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Phrantiques\Security\Models\Rule;
use Symfony\Component\HttpFoundation\Response;
use Phrantiques\Security\Http\Request\RuleFormRequest;

class RulesController extends Controller
{
    public function index(): View
    {
        $rules = Rule::get();

        return view('security::rules.index')->withRules($rules);
    }

    public function create(): View
    {
        $data = [
            'action' => route('security.rules.store'),
            'method' => Request::METHOD_POST,
            'rule' => new Rule(),
        ];

        return view('security::rules.form')->with($data);
    }

    public function store(RuleFormRequest $request): Response
    {
        $rule = Rule::create($request->except('_token', '_method'));

        $message = "Правило '{$rule->name}' успешно создано.";

        return redirect()->route('security.rules.index')->withMessage($message);
    }

    public function show(Rule $rule): View
    {
        return view('security::rules.form')->with([
            'action'  => route('security.rules.update', $rule),
            'method'  => Request::METHOD_PATCH,
            'rule'    => $rule,
        ]);
    }

    public function update(RuleFormRequest $request, Rule $rule): Response
    {
        $rule->update($request->all());

        $message = "Правило '{$rule->name}' успешно обновлено.";

        return redirect()->route('security.rules.index')->withMessage($message);
    }

    public function destroy(Rule $rule): Response
    {
        $rule->delete();

        $message = "Правило '{$rule->name}' успешно удалено.";

        return redirect()->route('security.rules.index')->withMessage($message);
    }
}

<?php

declare(strict_types=1);

namespace Phrantiques\Security\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Phrantiques\Security\Models\Rule;
use Phrantiques\Security\Models\Policy;

class CheckController extends Controller
{
    public function index(): View
    {
        return view('security::check.form');
    }

    public function handle(Request $request): View
    {
        $user = User::findOrFail($request->get('user_id'));

        $values = $user->roles->pluck('display_name')
            ->push($user->id)
            ->push($user->id_prov)
            ->filter(function ($value) { return !empty($value); })
            ->map(function ($value) { return DB::getPdo()->quote((string) $value); })
            ->implode(', ');

        /** @var Collection $matchedRules */
        $matchedRules = Rule::where(function ($query) use ($values) {
                $query->whereRaw("regexp_split_to_array((condition -> 'propertyA') ->> 'value', ',') && ARRAY [{$values}]")
                      ->orWhereRaw("regexp_split_to_array((condition -> 'propertyB') ->> 'value', ',') && ARRAY [{$values}]");
            })
            ->get();

        $policies = Policy::whereSubject(get_class($user))
            ->whereHas('rules', function ($query) use ($matchedRules) {
                $query->whereIn('id', $matchedRules->pluck('id')->toArray());
            })->get();

        $data = [
            'matchedRules' => $matchedRules,
            'policies' => $policies,
        ];

        return view('security::check.result')->with($data);
    }
}

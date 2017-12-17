@if(Auth::user()->isAdmin())
    <li>
        <a href="{{ route('security.users_roles.index') }}"><i class="fa fa-lock"></i><span> Доступ</span></a>
        <ul>
            <li>
                <a href="{{ route('security.check.index') }}"><i class="fa fa-list"></i> Поиск доступных действий</a>
            </li>
            <li>
                <a href="{{ route('security.roles.index') }}"><i class="fa fa-list"></i> Роли</a>
            </li>
            <li>
                <a href="{{ route('security.policies.index') }}"><i class="fa fa-list"></i> Политики</a>
            </li>
            <li>
                <a href="{{ route('security.rules.index') }}"><i class="fa fa-list"></i> Правила</a>
            </li>
        </ul>
    </li>
@endif

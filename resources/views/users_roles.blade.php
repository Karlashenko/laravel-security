<style>
    input.form-control {
        padding: 5px !important;
        box-sizing: border-box;
    }

    .m-t1 {
        margin-top: 10px !important;
    }

    .table td:first-child {
        font-size: 0.85em;
    }

    .center-text {
        text-align: center !important;
        vertical-align: middle !important;
    }
</style>

@extends('layouts.app')

@section('content')
    <body class="menu-on-top smart-style-2">

    <header id="header">
        @include('blocks.logoBlock')
        <div class="pull-right">
            @include('blocks.notifications')
            @include('blocks.collapseMenuLink')
            @include('blocks.topMenuProfileLink')
            @include('blocks.logoutLink')
            @include('blocks.fullscreenLink')
        </div>
    </header>

    <aside id="left-panel">
        @include('blocks.loginInfo')
        @include('blocks.menu')
        @include('blocks.minifyMenu')
    </aside>

    <div id="main" role="main">
        <div id="content">
            <table class="table">
                <thead>
                <tr>
                    <th></th>
                    @foreach($roles as $role)
                        <th class="center-text">
                            {{ $role->getDisplayName() }}<br/>
                            <small>{{ $role->name }}</small>
                        </th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>
                            <b>{{ $user->getFio() }}</b><br/>
                            <small>{{ $user->getLogin() }}</small>
                        </td>
                        @foreach($roles as $role)
                            <td class="center-text">
                                <input class="role-checkbox" type="checkbox" {{ $user->roles->contains($role->id) ? 'checked' : '' }}
                                       data-user_id="{{ $user->id }}"
                                       data-role_id="{{ $role->id }}">
                            </td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </body>

    <script src="/js/libs/jquery-2.1.1.min.js"></script>
    <script src="/js/bootstrap/bootstrap.min.js"></script>

    <script>
        $(function () {
            $(".role-checkbox").click(function (event) {
                var userId = $(this).data("user_id");
                var roleId = $(this).data("role_id");
                var status = this.checked ? 1 : 0;
                var current = $(this);

                $(".role-checkbox").attr("disabled", true);

                $.ajax({
                    url: "{{ route('security.users_roles.attach') }}",
                    type: "post",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "user_id": userId,
                        "role_id": roleId,
                        "status": status
                    },
                    success: function (response) {
                        $(".role-checkbox").attr("disabled", false);
                        current.attr("checked", response['status']);
                    },
                    error: function (response) {
                        $(".role-checkbox").attr("disabled", false);
                        current.attr("checked", !status);
                    }
                });
            });
        });
    </script>
@endsection

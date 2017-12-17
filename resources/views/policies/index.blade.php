<style>
    table th, td {
        vertical-align: middle !important;
    }

    .table {
        margin-top: 20px;
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
            @include('blocks.messagesBlock')

            <div class="row">
                <div class="col-md-12">
                    <a class="btn btn-primary" href="{{ route('security.policies.create') }}">
                        <i class="fa fa fa-plus"></i> Новая политика
                    </a>

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Название</th>
                            <th>Субъект</th>
                            <th>Ресурс</th>
                            <th>Действие</th>
                            <th>Атрибуты</th>
                            <th class="center-text" style="width: 20%;">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($policies as $policy)
                            <tr>
                                <td>{{ $policy->name }}</td>
                                <td>{{ \Phrantiques\Security\Support\Config::getSubjectName($policy->subject) }}</td>
                                <td>{{ \Phrantiques\Security\Support\Config::getResourceName($policy->resource) }}</td>
                                <td>{{ \Phrantiques\Security\Support\Config::getActionName($policy->action) }}</td>
                                <td>{{ $policy->getPropertiesAsString() }}</td>

                                <td class="center-text">
                                    <a class="btn btn-default" href="{{ route('security.policies.show', $policy) }}">
                                        <i class="fa fa fa-edit"></i> Редактировать
                                    </a>

                                    <form style="display: inline;" action="{{ route('security.policies.destroy', $policy) }}" method="POST">
                                        {{ method_field('DELETE') }}
                                        {{ csrf_field() }}
                                        <button class="btn btn-danger" onclick="return confirm('Вы уверены?')">
                                            <i class="fa fa fa-trash"></i> Удалить
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="/js/libs/jquery-2.1.1.min.js"></script>
    <script src="/js/bootstrap/bootstrap.min.js"></script>

    </body>
@endsection

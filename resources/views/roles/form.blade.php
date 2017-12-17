<style>
    input.form-control {
        padding: 5px !important;
        box-sizing: border-box;
    }

    .m-t1 {
        margin-top: 10px !important;
    }

    .hint {
        margin-top: 15px !important;
    }

    .hint kbd {
        padding: 3px !important;
    }

    #content {
        padding: 25px 50px !important;
        position: relative !important;
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

            <?php
            $role->name = $role->name ?: old('name');
            $role->display_name = $role->display_name ?: old('display_name');
            $role->description = $role->description ?: old('description');
            ?>

            <form method="POST" action="{{ $action }}" accept-charset="UTF-8" class="form-horizontal smart-form">
                {{ method_field($method ?? 'POST') }}
                {{ csrf_field() }}

                <div class="{{ $errors->has('name') ? 'has-error' : '' }}">
                    <label class="input">
                        <span>Ключ</span>
                        <input type="text" class="form-control" name="name" value="{{ $role->name }}">
                    </label>

                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="m-t1 {{ $errors->has('display_name') ? 'has-error' : '' }}">
                    <label class="input">
                        <span>Название</span>
                        <input type="text" class="form-control" name="display_name" value="{{ $role->display_name }}">
                    </label>

                    @if ($errors->has('display_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('display_name') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="m-t1 {{ $errors->has('description') ? 'has-error' : '' }}">
                    <label class="input">
                        <span>Описание</span>
                        <input type="text" class="form-control" name="description" value="{{ $role->description }}">
                    </label>

                    @if ($errors->has('description'))
                        <span class="help-block">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                    @endif
                </div>

                <p class="buttons">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa fa-floppy-o"></i> Сохранить
                    </button>

                    <a href="{{ route('security.roles.index') }}" type="button" class="btn btn-danger">
                        <i class="fa fa fa-ban"></i> Отмена
                    </a>
                </p>
            </form>
        </div>
    </div>

    <script src="/js/libs/jquery-2.1.1.min.js"></script>
    <script src="/js/bootstrap/bootstrap.min.js"></script>

    </body>
@endsection

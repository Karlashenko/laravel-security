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

    table th {
        text-align: center !important;
    }

    #result-block {
        height: 100%;
    }

    #result-block > h3 {
        margin: 20px;
    }

    #result-block.loading {
        background-image: url("/img/preloader.svg");
        background-position: center center;
        background-repeat: no-repeat;
        background-size: 75%;
        height: 65%;
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

    <div id="main" rule="main">
        <div id="content">
            @include('blocks.messagesBlock')

            <form method="POST" action="{{ route('security.check.handle') }}" accept-charset="UTF-8" class="form-horizontal smart-form">
                {{ csrf_field() }}

                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="col-md-10">
                            <select id="user-select" class="form-control">
                                @foreach(\App\Models\User::orderBy('fio')->get() as $user)
                                    <option value="{{ $user->id }}">{{ $user->fio ?: $user->login }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <div class="col-md-1"></div>
                            <div class="col-md-11">
                                <button type="submit" class="btn btn-primary" style="width: 100%;">
                                    <i class="fa fa fa-search"></i> Найти
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2"></div>
                    <div id="result-block" class="col-md-8"></div>
                    <div class="col-md-2"></div>
                </div>
            </form>
        </div>
    </div>

    <script src="/js/libs/jquery-2.1.1.min.js"></script>
    <script src="/js/bootstrap/bootstrap.min.js"></script>

    <script>
        $(function () {
            $("form").submit(function (event) {
                event.preventDefault();

                $("select").attr("disabled", true);
                $("button").attr("disabled", true);
                $("#result-block").addClass("loading");
                $("#result-block").html("");

                $.ajax({
                    url: "{{ route('security.check.handle') }}",
                    data: {user_id: $("#user-select").val()},
                    type: "post",
                    success: function (response) {
                        $("select").attr("disabled", false);
                        $("button").attr("disabled", false);
                        $("#result-block").removeClass("loading");
                        $("#result-block").html(response);
                    },
                    error: function (response) {
                        $("select").attr("disabled", false);
                        $("button").attr("disabled", false);
                        $("#result-block").removeClass("loading");
                        $("#result-block").html('<h3>Во время выполнения запроса возникла ошибка.</h3>');
                    }
                });
            });
        });
    </script>

    </body>
@endsection

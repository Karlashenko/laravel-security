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

            <?php
            $rule->name = $rule->name ?: old('name');
            $rule->display_name = $rule->display_name ?: old('display_name');
            $rule->description = $rule->description ?: old('description');
            ?>

            <form method="POST" action="{{ $action }}" accept-charset="UTF-8" class="form-horizontal smart-form">
                {{ method_field($method ?? 'POST') }}
                {{ csrf_field() }}

                <div class="{{ $errors->has('name') ? 'has-error' : '' }}">
                    <label class="input">
                        <span>Название</span>
                        <input type="text" class="form-control" name="name" value="{{ $rule->name }}">
                    </label>

                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="m-t1 {{ $errors->has('effect') ? 'has-error' : '' }}">
                    <span>Эффект</span>
                    <select class="form-control" name="effect">
                        @foreach(config('security.effects') as $key => $name)
                            <?php $selected = $rule->effect === $key ? 'selected' : '' ?>
                            <option value="{{ $key }}" {{ $selected }}>{{ $name }}</option>
                        @endforeach
                    </select>

                    @if ($errors->has('effect'))
                        <span class="help-block">
                            <strong>{{ $errors->first('effect') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="m-t1">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Тип</th>
                            <th>Объект</th>
                            <th>Значение</th>
                            <th>Операция</th>
                            <th>Тип</th>
                            <th>Объект</th>
                            <th>Значение</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="col-md-1">
                                <select class="type-select form-control" name="condition[propertyA][type]">
                                    @foreach(config('security.property_types') as $key => $value)
                                        <?php $selected = array_get($rule->condition, 'propertyA.type') === $key ? 'selected' : '' ?>
                                        <option value="{{ $key }}" {{ $selected }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="col-md-2">
                                <select class="entity-select form-control" name="condition[propertyA][entity]"
                                        data-value="{{ array_get($rule->condition, 'propertyA.entity') }}">
                                </select>
                            </td>
                            <td class="col-md-2">
                                <select class="key-select form-control" name="condition[propertyA][key]"
                                        data-value="{{ array_get($rule->condition, 'propertyA.key') }}">
                                </select>
                                <input class="value-input form-control" type="text" name="condition[propertyA][value]"
                                       value="{{ array_get($rule->condition, 'propertyA.value') }}" style="display: none;">
                            </td>

                            <td class="col-md-1">
                                <select class="assertion-select form-control" name="condition[assertion]">
                                    @foreach(config('security.assertions') as $key => $value)
                                        <?php $selected = array_get($rule->condition, 'assertion') === $key ? 'selected' : '' ?>
                                        <option value="{{ $key }}" {{ $selected }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </td>

                            <td class="col-md-1">
                                <select class="type-select form-control" name="condition[propertyB][type]">
                                    @foreach(config('security.property_types') as $key => $value)
                                        <?php $selected = array_get($rule->condition, 'propertyB.type') === $key ? 'selected' : '' ?>
                                        <option value="{{ $key }}" {{ $selected }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="col-md-2">
                                <select class="entity-select form-control" name="condition[propertyB][entity]"
                                        data-value="{{ array_get($rule->condition, 'propertyB.entity') }}">
                                </select>
                            </td>
                            <td class="col-md-2">
                                <select class="key-select form-control" name="condition[propertyB][key]"
                                        data-value="{{ array_get($rule->condition, 'propertyB.key') }}">
                                </select>
                                <input class="value-input form-control" type="text" name="condition[propertyB][value]"
                                       value="{{ array_get($rule->condition, 'propertyB.value') }}" style="display: none;">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <p class="buttons">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa fa-floppy-o"></i> Сохранить
                    </button>

                    <a href="{{ route('security.rules.index') }}" type="button" class="btn btn-danger">
                        <i class="fa fa fa-ban"></i> Отмена
                    </a>
                </p>
            </form>
        </div>
    </div>

    <script src="/js/libs/jquery-2.1.1.min.js"></script>
    <script src="/js/bootstrap/bootstrap.min.js"></script>

    <script>
        $(function () {
            var config = {!! json_encode((array) config('security')) !!};
            var condition = {!! json_encode((array) $rule->condition) !!};

            $(".entity-select").on("change", function () {
                var valueSelect = $(this).parent().next("td").find(".key-select");

                valueSelect.find("option").remove();

                var type = $(this).parent().prev("td").find(".type-select").val();
                var entity = $(this).val();

                if (!type || !entity) {
                    return;
                }

                var properties = config.entities[type][entity].properties;

                for (var key in properties) {
                    valueSelect.append($("<option/>", {value: key, text: properties[key]}));
                }

                var value = valueSelect.data("value");
                value = value ? value : valueSelect.find("option:first").val();

                valueSelect.data("value", "");
                valueSelect.val(value).change();
            });

            $(".type-select").on("change", function () {
                var entitySelect = $(this).parent().next("td").find(".entity-select");

                entitySelect.find("option").remove();

                var type = $(this).val();

                if (!type) {
                    return;
                }

                var valueInput = $(this).parent().next('td').next('td').find('.value-input');
                var valueSelect = $(this).parent().next('td').next('td').find('.key-select');

                if (type === "raw") {
                    valueInput.show();
                    valueInput.data("name", valueInput.attr(""));
                    valueSelect.hide();
                    return;
                }

                valueInput.val("");
                valueInput.hide();

                valueSelect.show();

                var types = config.entities[type];

                for (var key in types) {
                    entitySelect.append($("<option/>", {value: key, text: types[key].name}));
                }

                var value = entitySelect.data("value");
                value = value ? value : entitySelect.find("option:first").val();

                entitySelect.data("value", "");
                entitySelect.val(value).change();
            }).change();
        });
    </script>

    </body>
@endsection

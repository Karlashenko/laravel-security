<style>
    input.form-control {
        padding: 5px !important;
        box-sizing: border-box;
    }

    .m-t1 {
        margin-top: 10px !important;
    }

    #content {
        padding: 25px 50px !important;
        position: relative !important;
    }

    select.multiple option {
        padding: 5px !important;
    }

    table th, td {
        vertical-align: middle !important;
    }

    table td {
        height: 50px !important;
    }

    pre {
        margin: 0 !important;
        padding: 8.5px !important;
    }

    .table {
        margin-top: 20px;
    }

    .center-text {
        text-align: center !important;
        vertical-align: middle !important;
    }

    .red {
        color: #880000;
    }

    .green {
        color: #008800;
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
            $policy->name = $policy->name ?: old('name');
            $policy->subject = $policy->subject ?: old('subject');
            $policy->resource = $policy->resource ?: old('resource');
            $policy->properties = $policy->properties ?: old('properties');
            $policy->action = $policy->action ?: old('action');
            $policy->algorithm = $policy->algorithm ?: old('algorithm');
            $policy->rules = $policy->rules ?: collect(old('rules'));
            ?>

            <form method="POST" action="{{ $action }}" accept-charset="UTF-8" class="form-horizontal smart-form">
                {{ method_field($method ?? 'POST') }}
                {{ csrf_field() }}

                <div class="{{ $errors->has('name') ? 'has-error' : '' }}">
                    <label class="input">
                        <span>Название</span>
                        <input type="text" class="form-control" name="name" value="{{ $policy->name }}">
                    </label>

                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="m-t1 {{ $errors->has('subject') ? 'has-error' : '' }}">
                    <label class="input">
                        <span>Субъект</span>
                        <select name="subject" class="form-control">
                            @foreach(\Phrantiques\Security\Support\Config::getSubjectEntities() as $key => $entity)
                                <?php $selected = $policy->subject === $key ? 'selected' : '' ?>
                                <option value="{{ $key }}" {{ $selected }}>{{ $entity['name'] }}</option>
                            @endforeach
                        </select>
                    </label>

                    @if ($errors->has('subject'))
                        <span class="help-block">
                            <strong>{{ $errors->first('subject') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="m-t1 {{ $errors->has('resource') ? 'has-error' : '' }}">
                    <label class="input">
                        <span>Ресурс</span>
                        <select name="resource" class="form-control">
                            @foreach(\Phrantiques\Security\Support\Config::getResourceEntities() as $key => $entity)
                                <?php $selected = $policy->resource === $key ? 'selected' : '' ?>
                                <option value="{{ $key }}" {{ $selected }}>{{ $entity['name'] }}</option>
                            @endforeach
                        </select>
                    </label>

                    @if ($errors->has('resource'))
                        <span class="help-block">
                            <strong>{{ $errors->first('resource') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="m-t1 {{ $errors->has('properties') ? 'has-error' : '' }}">
                    <label class="input">
                        <span>Атрибуты</span>
                        <select name="properties[]" class="multiple form-control" multiple data-value='{!! json_encode((array) $policy->properties) !!}'>
                            <option value="">Нет</option>
                        </select>
                    </label>

                    @if ($errors->has('properties'))
                        <span class="help-block">
                            <strong>{{ $errors->first('properties') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="m-t1 {{ $errors->has('action') ? 'has-error' : '' }}">
                    <label class="input">
                        <span>Действие</span>
                        <select name="action" class="form-control">
                            @foreach(\Phrantiques\Security\Support\Config::getActions() as $key => $name)
                                <?php $selected = $policy->action === $key ? 'selected' : '' ?>
                                <option value="{{ $key }}" {{ $selected }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </label>

                    @if ($errors->has('action'))
                        <span class="help-block">
                            <strong>{{ $errors->first('action') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="m-t1 {{ $errors->has('algorithm') ? 'has-error' : '' }}">
                    <label class="input">
                        <span>Алгоритм</span>
                        <select name="algorithm" class="form-control">
                            @foreach(\Phrantiques\Security\Support\Config::getAlgorithms() as $key => $name)
                                <?php $selected = $policy->algorithm === $key ? 'selected' : '' ?>
                                <option value="{{ $key }}" {{ $selected }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </label>

                    @if ($errors->has('algorithm'))
                        <span class="help-block">
                            <strong>{{ $errors->first('algorithm') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="m-t1 {{ $errors->has('rules') ? 'has-error' : '' }}">
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="center-text">Правило</th>
                            <th class="center-text">Условие</th>
                            <th class="center-text">Эффект</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rules as $rule)
                            <tr>
                                <td>
                                    <?php $checked = $policy->rules->contains($rule->id) ? 'checked' : '' ?>
                                    <label>
                                        <input type="checkbox" name="rules[]" value="{{ $rule->id }}" {{ $checked }} style="margin-right: 10px;">
                                        {{ $rule->name }}
                                    </label>
                                </td>
                                <td class="center-text">
                                    <pre>{{ $rule->getConditionAsString() }}</pre>
                                </td>
                                <td class="center-text {{ $rule->effect === \Phrantiques\Security\Services\Security::EVALUATION_EFFECT_PERMIT ? 'green' : 'red' }}">
                                    {{ \Phrantiques\Security\Support\Config::getEffectName($rule->effect) }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    @if ($errors->has('rules'))
                        <span class="help-block">
                            <strong>{{ $errors->first('rules') }}</strong>
                        </span>
                    @endif
                </div>

                <p class="buttons">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa fa-floppy-o"></i> Сохранить
                    </button>

                    <a href="{{ route('security.policies.index') }}" type="button" class="btn btn-danger">
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
            var config = {!! json_encode(\Phrantiques\Security\Support\Config::getConfig()) !!};

            var resourceSelect = $("[name='resource']");
            var propertySelect = $("[name='properties[]']");
            var policyProperties = {!! json_encode((array) $policy->properties) !!};

            resourceSelect.change(function () {
                var type = $(this).val();
                var properties = {};

                try {
                    properties = config["entities"]["resource"][type]["properties"];
                } catch (e) {}

                propertySelect.find("option").remove();
                propertySelect.append($("<option/>", {value: "", text: "Нет"}));

                for (var key in properties) {
                    var option = $("<option/>", {value: key, text: properties[key]});

                    if (policyProperties.indexOf(key) !== -1) {
                        option.attr("selected", true);
                    }

                    propertySelect.append(option)
                }

                if (policyProperties.length === 0) {
                    propertySelect.find("option:first").attr("selected", true);
                }

                policyProperties = [];

                propertySelect.attr("size", propertySelect.find("option").length);
            }).change();
        });
    </script>

    </body>
@endsection

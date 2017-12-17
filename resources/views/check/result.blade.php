<style>
    .green {
        color: #008800;
    }

    .orange {
        color: #AC8800;
    }

    .policy {
        padding: 20px;
        margin-top: 20px;
        border: 1px dashed #aaa;
    }

    .rule {
        margin-left: 20px;
        font-size: 1.1em;
    }

    .rule i {
        width: 15px;
        text-align: center;
    }
</style>

@forelse($policies as $policy)
    <div class="policy">
        <h3>{{ $policy->name }}</h3>

        @foreach($policy->rules as $rule)
            <?php $matched = $matchedRules->contains($rule) ?>
            <p class="rule {{ $matched ? 'green' : 'orange' }}">
                <i class="fa {{ $matched ? 'fa-check' : 'fa-question' }}"></i> {{ $rule->name }}
            </p>
        @endforeach
    </div>
@empty
    <h3>Не удалось найти доступные действия.</h3>
@endforelse

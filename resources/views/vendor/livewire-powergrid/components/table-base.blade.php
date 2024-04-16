@props([
    'theme' => null,
    'readyToLoad' => false,
])
<div @isset($this->setUp['responsive']) x-data="pgResponsive" @endisset>
    <table
        class="table power-grid-table {{ $theme->tableClass }}"
        style="width:100%; {{ $theme->tableStyle }}"
    >
        <thead
            class="shadow-sm rounded-t-lg bg-pg-primary-200"
            style="{{ $theme->theadStyle }}"
        >
            {{ $header }}
        </thead>
        @if ($readyToLoad)
            <tbody
                class="{{ $theme->tbodyClass }}"
                style="{{ $theme->tbodyStyle }}"
            >
                {{ $body }}
            </tbody>
        @else
            <tbody
                class="{{ $theme->tbodyClass }}"
                style="{{ $theme->tbodyStyle }}"
            >
                {{ $loading }}
            </tbody>
        @endif
    </table>
</div>
